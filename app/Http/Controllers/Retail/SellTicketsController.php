<?php

namespace App\Http\Controllers\Retail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellTickets;
use App\Project;
use App\Purchase;
use App\Ticket;
use App\Event;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SellTicketsController extends Controller
{
    /**
     * Display all available events
     */
    public function events()
    {
        $projects = Project::with(['events' => function ($query) {
            $query->where('end_date', '>=', new \DateTime())->orderBy('start_date', 'ASC');
        }, 'events.location'])->get();

        $currentProjects = $projects->filter(function ($project) {
            return $project->events->count() > 0;
        })->all();

        return view('retail.events', ['projects' => $currentProjects]);
    }

    /**
     * Display available price categories for the selected event
     */
    public function seats(Request $request, Event $event)
    {
        $seatMapView = 'retail.seatmaps.seatmap-js';
        if ($event->seatMap->layout === null) {
            $seatMapView = 'retail.seatmaps.no-seats';
        }

        return view($seatMapView, ['event' => $event]);
    }

    /**
     * Create a paid purchase mapped on the current logged in user as vendor
     */
    public function sellTickets(SellTickets $request, Event $event)
    {
        $validated = $request->validated();
        $tickets = $validated['tickets'];
        $action = $validated['action'];

        // If the purchase shall be a reservation, check if the user has the permission to do so
        if ($action === 'reserved' && !Auth::user()->hasPermission('RESERVE_TICKETS')) {
            Log::warning('Unauthorized action "RESERVE_TICKETS" by user#' . Auth::user()->id . ' failed');
            // Redirect user to select a valid amount of tickets
            return redirect()->route('retail.sell.seats', [$event])
                ->with('status', 'You are not allowed to perform this action. This will be reported!');
        }

        // If the purchase shall be a reservation, check if the user has the permission to do so
        if ($action === 'free' && !Auth::user()->hasPermission('HANDLING_FREE_TICKETS')) {
            Log::warning('Unauthorized action "HANDLING_FREE_TICKETS" by user#' . Auth::user()->id . ' failed');
            // Redirect user to select a valid amount of tickets
            return redirect()->route('retail.sell.seats', [$event])
                ->with('status', 'You are not allowed to perform this action. This will be reported!');
        }

        // Check if customer data was sent. Then handle the user.
        if (array_key_exists('customer-name', $validated)) {
            $customerName = $validated['customer-name'];
        }

        // Start a transaction for inserting all session data into database
        // and generating a purchase.
        // Checks at the end validate if tickets are still free/available
        DB::beginTransaction();

        $ticketSum = array_sum($tickets);
        if ($event->freeTickets() < $ticketSum) {
            // End transaction
            DB::rollbackTransaction();
            // Redirect user to select a valid amount of tickets
            return redirect()->route('retail.sell.seats', [$event])
                ->with('status', 'There are not as many tickets as you chose left. Please only choose a lesser amount of tickets!');
        }

        if ($event->seatMap->layout !== null) {
            // Check if seats are still free and not booked by a concurrent transaction in the meantime
            $seats = $validated['selected-seats'];
            if (!$event->areSeatsFree($seats)) {
                // End transaction
                DB::rollBackTransaction();
                // redirect user to select a new set of seats
                return redirect()->route('retail.sell.seats', [$event])
                    ->with('status', 'Not all of your selected seats are still free. Please choose a new set of seats!');
            }
        }

        $prices = $event->priceList->categories;
        $prices = $prices->keyBy('id');

        $purchase = new Purchase();
        $purchase->generateSecrets();
        $purchase->state = $action;
        $purchase->vendor_id = auth()->user()->id;
        $purchase->customer_name = isset($customerName) ? $customerName : null;
        $purchase->save();

        $seatsIndex = 0;
        foreach ($tickets as $ticketCategory => $ticketCount) {
            for ($i = 0; $i < $ticketCount; $i++) {
                Ticket::create([
                    'random_id' => Str::random(32),
                    'seat_number' => isset($seats) ? $seats[$seatsIndex] : 0,
                    'purchase_id' => $purchase->id,
                    'event_id' => $event->id,
                    'price_category_id' => $prices[$ticketCategory]->id
                ]);
                $seatsIndex++;
            }
        }

        DB::commit();

        // On successful sale, redirect browser to purchase overview
        return redirect()->route('ticket.purchase', ['purchase' => $purchase->random_id])
            ->with('status', 'Purchase successful!');
    }
}
