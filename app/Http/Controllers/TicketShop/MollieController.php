<?php

namespace App\Http\Controllers\TicketShop;

use App\Exceptions\PaymentProviderException;
use App\Http\Controllers\Controller;
use App\PaymentProvider\Mollie;
use App\Purchase;
use App\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Handles all mollie.com related requests
 * 
 * @package App\Http\Controllers\Ticketshop
 */
class MollieController extends Controller
{
    /**
     * Instance of the type-hinted Mollie-PaymentProvider
     * @var Mollie
     */
    protected $paymentProvider;

    /**
     * Create a new Controller instance with the Mollie-PaymentProvider via DPI
     * 
     * @param Mollie $paymentProvider 
     * @return void 
     */
    public function __construct(Mollie $paymentProvider)
    {
        $this->paymentProvider = $paymentProvider;
    }

    /**
     * Process POST-Requests from Mollie to published Webhooks.
     * They only contain an id-field referencing a previously created payment.
     * 
     * @param Request $request 
     * @return Response|ResponseFactory 
     */
    public function processWebhook(Request $request)
    {
        $id = $request->input('id');

        // Check if a purchase with the given payment id exists
        // Someone could try to cause high load on webservice by
        // requesting the webhook endpoint with fake ids
        $purchase = Purchase::firstWhere('payment_id', $id);
        if( !$purchase ) {
            return response('PaymentId invalid', 403);
        }

        $this->paymentProvider->updatePayment($id);

        return response('Payment processed', 200);
    }

    /**
     * Update the state of the given purchase with the payment-state @mollie.com
     * 
     * @param Purchase $purchase Any purchase that has been submitted for payment to mollie.com
     * @return Response|ResponseFactory State of the given Purchase
     * @throws PaymentProviderException 
     * @throws ModelNotFoundException 
     */
    public function getPaymentUpdate(Purchase $purchase)
    {
        // First check, if the purchase is linked to mollie.
        // Else we would trigger unneccessary api calls
        $mollie = User::firstWhere('email', 'mollie@system.local');
        if( $purchase->vendor->id !== $mollie->id ) {
            return response('Not a mollie purchase!', 403); // 403 = Forbidden
        }

        // Trigger the update by calling the mollie-api
        $this->paymentProvider->updatePayment($purchase->payment_id);

        // Refresh the model in order to have its current state
        $purchase->refresh();

        // Just send back the purchase's state.
        return response($purchase->state);
    }
}
