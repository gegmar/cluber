<?php

namespace App\Http\Controllers\TicketShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentProvider\PayPal;
use App\Purchase;
use App\Exceptions\PaymentProviderException;

class PaymentProviderController extends Controller
{
    public function payPalExecutePayment(Request $request, Purchase $purchase, string $secret)
    {
        $payerId = $request->query('PayerID');
        $paymentId = $request->query('paymentId');

        $returnable = redirect()->route('ts.overview');
        try {
            PayPal::executePayment($paymentId, $payerId);

            // Validate if the sent secret matches the purchase-secret
            if ($purchase->payment_secret != $secret) {
                throw new PaymentProviderException('Error - Secret does not match purchase!');
            }

            $purchase->state = 'paid';
            $purchase->state_updated = new \DateTime();
            $purchase->save();

            $returnable = redirect()->route('ticket.purchase', ['purchase' => $purchase])->with('status', 'Purchase successful - Please download your tickets.');
        } catch (PaymentProviderException $e) {
            $returnable->with('status', $e->getMessage());
        }
        return $returnable;
    }
}
