<?php

namespace App\Http\Controllers\Retail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellTickets;
use App\Project;
use App\Purchase;
use App\Ticket;
use App\Event;

class SellTicketsController extends Controller
{
    /**
     * Display all available events
     */
    public function events()
    {
        $projects = Project::with(['events' => function ($query) {
            $query->where('start_date', '>=', new \DateTime())->orderBy('start_date', 'ASC');
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
        if ($event->seatMap->layout !== null) {
            // handle seat ids
            // TODO for later
        }

        $validated = $request->validated();
        $tickets = $validated['tickets'];

        // Start a transaction for inserting all session data into database
        // and generating a purchase.
        // Checks at the end validate if tickets are still free/available
        DB::beginTransaction();

        $ticketSum = array_sum($tickets);
        if ($event->freeTickets() < $ticketSum) {
            // End transaction
            DB::rollbackTransaction();
            // Redirect user to select a valid amount of tickets
            return redirect()->route('retail.sell.seats')
                ->with('status', 'There are not as many tickets as you chose left. Please only choose a lesser amount of tickets!');
        }

        $prices = $event->priceList->categories;
        $prices = $prices->keyBy('name');

        $purchase = new Purchase();
        $purchase->generateSecrets();
        $purchase->state = 'paid';
        $purchase->vendor_id = auth()->user()->id;
        $purchase->save();

        foreach ($tickets as $ticketCategory => $ticketCount) {
            for ($i = 0; $i < $ticketCount; $i++) {
                $ticket = Ticket::create([
                    'random_id' => str_random(32),
                    'seat_number' => 0,
                    'purchase_id' => $purchase->id,
                    'event_id' => $event->id,
                    'price_category_id' => $prices[$ticketCategory]->id
                ]);
            }
        }

        DB::commit();

        // On successful sale, redirect browser to purchase overview
        return redirect()->route('ticket.purchase', ['purchase' => $purchase->random_id])
            ->with('status', 'Purchase successful!');
    }
}
