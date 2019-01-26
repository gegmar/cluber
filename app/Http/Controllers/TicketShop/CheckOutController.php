<?php

namespace App\Http\Controllers\TicketShop;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\PayTickets;
use App\Http\Controllers\Controller;
use App\PaymentProvider\PayPal;
use App\PaymentProvider\Klarna;
use App\Exceptions\PaymentProviderException;
use App\Purchase;
use App\Role;
use App\User;
use App\Ticket;

class CheckOutController extends Controller
{
    public function getOverview()
    {
        // Only allow requests for sessions with existing customer data
        if (!session()->has('customerData')) {
            return redirect()->route('ts.customerData');
        }

        $cData = session('customerData');

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
            DB::rollbackTransaction();
            // Empty session data so user must select new tickets
            $request->session()->forget('tickets');
            // Redirect user to select a valid amount of tickets
            return redirect()->route('ts.seatmap')
                ->with('status', 'There are not as many tickets as you chose left. Please only choose a lesser amount of tickets!');
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
        $prices = $prices->keyBy('name');

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

        // forget all session data that has been written into database
        $request->session()->forget(['customerData', 'event', 'tickets']);

        $paymentUrl = 'https://www.github.com';
        switch ($request->validated()['paymethod']) {
            case 'Klarna':
                $paymentUrl = Klarna::getPaymentUrl($purchase);
                break;
            case 'PayPal':
                $paymentUrl = PayPal::getPaymentUrl($purchase);
                break;
        }

        return redirect()->away($paymentUrl);
    }

    /**
     * Success-Function for users that paid at a payment provider for their purchase
     */
    public function paymentSuccessful(Purchase $purchase, string $secret)
    {
        try {
            $purchase->setStateToPaid($secret);
        } catch (PaymentProviderException $e) {
            return redirect()->route('ts.overview')->with('status', $e->getMessage());
        }

        return redirect()->route('ticket.purchase', ['purchase' => $purchase])->with('status', 'Purchase successful - Please download your tickets.');
    }

    public function paymentAborted(Purchase $purchase)
    {
        $purchase->deleteWithAllData();
        return redirect()->route('ts.events')->with('status', 'Purchase aborted - Your previously selected tickets have been deleted.');
    }

    public function paymentTimedOut(Purchase $purchase)
    {
        return $this->paymentAborted($purchase);
    }


    /*
     *************************
     * Methods for later use *
     *************************
     */
    public function notifyLoss(Purchase $purchase, string $secret)
    {

    }

    public function notifyPending(Purchase $purchase, string $secret)
    {

    }

    public function notifyReceived(Purchase $purchase, string $secret)
    {

    }

    public function notifyRefunded(Purchase $purchase, string $secret)
    {

    }
}