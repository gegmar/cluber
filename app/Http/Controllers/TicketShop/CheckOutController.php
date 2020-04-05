<?php

namespace App\Http\Controllers\TicketShop;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\PayTickets;
use App\Http\Controllers\Controller;
use App\Purchase;
use App\Role;
use App\User;
use App\Ticket;
use Illuminate\Support\Str;

class CheckOutController extends Controller
{

    public function getOverview()
    {
        // Only allow requests for sessions with existing customer data
        if (!session()->has('customerData')) {
            return redirect()->route('ts.customerData');
        }

        return view('ticketshop.purchase-overview', [
            'event' => session('event'),
            'tickets' => session('tickets'),
            'customerData' => session('customerData'),
        ]);
    }

    public function startPayment(PayTickets $request)
    {
        // Only allow requests for sessions with existing customer data
        if (!session()->has('customerData')) {
            return redirect()->route('ts.customerData');
        }
        $cData = session('customerData');

        // Start a transaction for inserting all session data into database
        // and generating a purchase.
        // Checks at the end validate if tickets are still free/available
        DB::beginTransaction();

        // Retrieve selected event and refresh it by loading all related data
        // from database
        $event = session('event');
        $event->refresh();

        $tickets = session('tickets');
        $ticketSum = array_sum($tickets);
        if ($event->freeTickets() < $ticketSum) {
            // End transaction
            DB::rollback();
            // Empty session data so user must select new tickets
            $request->session()->forget('tickets');
            // Redirect user to select a valid amount of tickets
            return redirect()->route('ts.seatmap')
                ->with('status', 'There are not as many tickets as you chose left. Please only choose a lesser amount of tickets!');
        }

        if ($event->seatMap->layout !== null) {
            // Check if seats are still free and not booked by a concurrent transaction in the meantime
            $seats = session('seats');
            if (!$event->areSeatsFree($seats)) {
                // End transaction
                DB::rollback();
                // Empty session data in order to select new seats
                $request->session()->forget('seats');
                // redirect user to select a new set of seats
                return redirect()->route('ts.seatmap')
                    ->with('status', 'Not all of your selected seats are still free. Please choose a new set of seats!');
            }
        }

        try {
            $customer = User::where('email', $cData['email'])->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $customer = User::create([
                'name' => $cData['name'],
                'email' => $cData['email'],
                'password' => '',
            ]);

            if (array_key_exists('newsletter', $cData) && $cData['newsletter'] == 'true') {
                $customer->roles()->attach(Role::where('name', 'NewsletterReceiver')->first());
            }
        }

        $prices = $event->priceList->categories;
        $prices = $prices->keyBy('id');

        $purchase = new Purchase();
        $purchase->generateSecrets();
        $purchase->customer_id = $customer->id;
        // If someone already has bought tickets with the same email address
        // but with a different name, we store the custom name to the purchase.
        if ($cData['name'] != $customer->name) {
            $purchase->customer_name = $cData['name'];
        }
        $purchase->vendor_id = User::where('name', $request->validated()['paymethod'])->first()->id;
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

        switch($request->validated()['paymethod'])
        {
            case 'Klarna':
                $paymentProvider = resolve('App\PaymentProvider\Klarna');
                break;
            case 'PayPal':
                $paymentProvider = resolve('App\PaymentProvider\PayPal');
                break;
            case 'Mollie':
                $paymentProvider = resolve('App\PaymentProvider\Mollie');
                break;
            default:
                DB::rollBack();
                return redirect()->route('ts.overview')
                    ->with('status', 'The selected PaymentProvider is not supported!');
        }

        DB::commit();
        // forget all session data that has been written into database
        $request->session()->forget(['customerData', 'event', 'tickets', 'seats']);

        return redirect()->away(
            $paymentProvider->getPaymentUrl($purchase)
        );
    }
}
