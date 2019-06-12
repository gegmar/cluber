<?php

namespace App\Http\Controllers\TicketShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Purchase;
use App\Exceptions\PaymentProviderException;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketsPaid;

use PayPal\Exception\PayPalConnectionException;
use Illuminate\Support\Facades\Log;

class PaymentProviderController extends Controller
{

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

        Mail::to($purchase->customer)->send(new TicketsPaid($purchase));

        return redirect()->route('ticket.purchase', ['purchase' => $purchase])
            ->with('status', 'Purchase successful - Please download your tickets.');
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

    public function payPalExecutePayment(Request $request, Purchase $purchase, string $secret)
    {
        $payerId = $request->query('PayerID');
        $paymentId = $request->query('paymentId');

        $returnable = redirect()->route('ts.overview');
        try {
            $purchase->setStateToPaid($secret);

            Mail::to($purchase->customer)->send(new TicketsPaid($purchase));

            $returnable = redirect()->route('ticket.purchase', ['purchase' => $purchase])
                ->with('status', 'Purchase successful - Please download your tickets.');

            $payPal = resolve('App\PaymentProvider\PayPal');
            // Might get risky to call --> set purchase to paid, but log the error!
            $payPal->executePayment($paymentId, $payerId);
        } catch (PaymentProviderException $e) {
            $returnable->with('status', $e->getMessage());
        } catch (PayPalConnectionException $e) {
            Log::warning('[PayPal] ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::warning('[General] ' . $e->getMessage());
        }
        return $returnable;
    }
}
