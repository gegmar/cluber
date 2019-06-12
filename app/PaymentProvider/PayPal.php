<?php

namespace App\PaymentProvider;

use App\Purchase;
use PayPal\Exception\PayPalConnectionException;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use Illuminate\Support\Facades\Log;
use App\Exceptions\PaymentProviderException;
use PayPal\Api\PaymentOptions;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\App;


/**
 * Class to process requests and responses to and from PayPal
 * 
 * Find docs @ https://github.com/paypal/PayPal-PHP-SDK
 */
class PayPal
{
    /**
     * API-Object; initialized by constructor
     */
    protected $apiContext;


    /**
     * @param $clientId ClientID for the shops paypal REST endpoint
     * @param $clientSecret Secret for the shops paypal REST endpoint
     * @return void
     */
    public function __construct($clientId, $clientSecret)
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential( $clientId, $clientSecret)
        );

        if (App::environment('prod')) {
            $this->apiContext->setConfig([
                'mode' => 'live'
            ]);
        }
    }

    /**
     * Contains full logic and switches in code for the correct payment method
     * 
     * @throws PaymentProviderException on errors
     */
    public function getPaymentUrl(Purchase $purchase)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($purchase->total());
        $amount->setCurrency('EUR');

        $paymentOptions = new PaymentOptions();
        $paymentOptions->setAllowedPaymentMethod('INSTANT_FUNDING_SOURCE');

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setPaymentOptions($paymentOptions);
        $transaction->setDescription('Ticket purchase #' . $purchase->id);
        $transaction->setInvoiceNumber($purchase->id);

        $redirectUrls = new RedirectUrls();
        $redirectUrls
            ->setReturnUrl(route('ts.payment.payPalExec', [
                'purchase' => $purchase->random_id,
                'secret' => $purchase->payment_secret
            ]))
            ->setCancelUrl(route('ts.payment.aborted', ['purchase' => $purchase->random_id]));

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return $payment->getApprovalLink();
        } catch (PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            Log::error($ex->getData());
            throw new PaymentProviderException('PayPal has errors...');
        }
    }

    /**
     * Excute payment after user returns from PayPal
     * 
     * @throws PaymentProviderException if something goes wrong
     */
    public function executePayment($paymentId, $payerId)
    {
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            // Execute the payment
            $payment->execute($execution, $this->apiContext);
            try {
                $payment = Payment::get($paymentId, $this->apiContext);
            } catch (\Exception $ex) {
                throw new PaymentProviderException('Error on getting Payment-ID.');
            }
        } catch (\Exception $ex) {
            throw new PaymentProviderException('Error on executing PayPal payment.');
        }
        return $payment;
    }
}
