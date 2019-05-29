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



class PayPal
{

    /**
     * Generate context by supplying PayPal-Credentials
     */
    private static function getApiContext(): ApiContext
    {
        $context = new ApiContext(
            new OAuthTokenCredential(
                config('paymentprovider.payPalClientId'),     // ClientID
                config('paymentprovider.payPalClientSecret')  // ClientSecret
            )
        );
        if (App::environment('prod')) {
            $context->setConfig([
                'mode' => 'live'
            ]);
        }
        return $context;
    }

    /**
     * Contains full logic and switches in code for the correct payment method
     * 
     * @throws PaymentProviderException on errors
     */
    public static function getPaymentUrl(Purchase $purchase)
    {
        $apiContext = static::getApiContext();

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
            $payment->create($apiContext);
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
    public static function executePayment($paymentId, $payerId)
    {
        $apiContext = static::getApiContext();

        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            // Execute the payment
            $payment->execute($execution, $apiContext);
            try {
                $payment = Payment::get($paymentId, $apiContext);
            } catch (\Exception $ex) {
                throw new PaymentProviderException('Error on getting Payment-ID.');
            }
        } catch (\Exception $ex) {
            throw new PaymentProviderException('Error on executing PayPal payment.');
        }
        return $payment;
    }
}
