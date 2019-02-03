<?php

namespace App\Http\Controllers\TicketShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentProvider\PayPal;
use App\Purchase;
use App\Exceptions\PaymentProviderException;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketsPaid;

class PaymentProviderController extends Controller
{
    public function payPalExecutePayment(Request $request, Purchase $purchase, string $secret)
    {
        $payerId = $request->query('PayerID');
        $paymentId = $request->query('paymentId');

        $returnable = redirect()->route('ts.overview');
        try {
            PayPal::executePayment($paymentId, $payerId);

            $purchase->setStateToPaid($secret);

            Mail::to($purchase->customer)->send(new TicketsPaid($purchase));

            $returnable = redirect()->route('ticket.purchase', ['purchase' => $purchase])
                ->with('status', 'Purchase successful - Please download your tickets.');
        } catch (PaymentProviderException $e) {
            $returnable->with('status', $e->getMessage());
        }
        return $returnable;
    }
}
