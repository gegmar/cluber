<?php

namespace App\PaymentProvider;

use App\Purchase;
use App\Exceptions\PaymentProviderException;
use App\Mail\TicketsPaid;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mollie\Api\MollieApiClient;

/**
 * Class to process requests to Mollie
 * 
 * Find docs @ https://github.com/mollie/mollie-api-php
 */
class Mollie
{
    /**
     * API-Object; initialized by constructor
     */
    protected $apiClient;

    /**
     * 
     * @param string $configKey Configuration key for this exact project
     * @return void
     */
    public function __construct($configKey)
    {
        $this->apiClient = new MollieApiClient();
        $this->apiClient->setApiKey($configKey);
    }

    /**
     * Generates for a given Purchase a payment request at Mollie and
     * returns a payment url where the customer can pay the purchase
     * 
     * For more details on the payment-create-process take a look at
     * https://github.com/mollie/mollie-api-php/blob/master/examples/payments/create-payment.php
     * 
     * @param Purchase $purchase the customer's purchase
     * @return string PaymentUrl to Mollie for the given purchase
     */
    public function getPaymentUrl(Purchase $purchase)
    {
        // Format the purchase's total to have 2 decimals being seperated by a dot and without
        // a thousand-seperator. Format = 123456.78
        $amountFormatted = number_format($purchase->total(), 2, '.', '');

        $firstEvent = $purchase->events()->pop();

        try {
            $payment = $this->apiClient->payments->create([
                'amount' => [
                    'currency' => 'EUR',
                    'value'    => $amountFormatted
                ],
                'description' => $firstEvent->project->name . ' | ' . $firstEvent->second_name,
                'redirectUrl' => route('ticket.purchase', $purchase),
                'webhookUrl'  => route('ts.payment.mollie.webhook'),
                'metadata' => [
                    'purchase_id' => $purchase->id
                ]
            ]);
            
            // Store the payment-reference from Mollie to the associated purchase
            $purchase->payment_id = $payment->id;
            $purchase->save();

        } catch( \Mollie\Api\Exceptions\ApiException $e ) {
            throw new PaymentProviderException( $e );
        }

        // Set a reference to the customer, depending if a user object exists
        $customerReference = $purchase->customer ? $purchase->customer->id : $purchase->customer_name;
        Log::info('[Purchase#' . $purchase->id . '] Created Payment#' . $payment->id . ' @Mollie and sending customer#' . $customerReference . ' to payment provider');
        
        return $payment->getCheckoutUrl();
    }

    /**
     * This function gets called by the mollie webhook
     * 
     * For more details on the payment-create-process take a look at
     * https://github.com/mollie/mollie-api-php/blob/master/examples/payments/webhook.php
     * 
     * @param string $paymentId 
     * @return void 
     * @throws PaymentProviderException 
     */
    public function updatePayment(string $paymentId)
    {
        try {
            // Retrieve the payment's current state and its associated purchase
            $payment = $this->apiClient->payments->get($paymentId);
            $purchaseId = $payment->metadata->purchase_id;
            $purchase = Purchase::find($purchaseId);

            if( !$purchase ) {
                throw new PaymentProviderException('Payment-Id "' . $paymentId . '" has no matching purchase!');
            }

            if( $payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks() ) {
                /*
                * The payment is paid and isn't refunded or charged back.
                */
                // Only send an email with the tickets on the change of state to "paid"
                if($purchase->state != 'paid') {
                    Log::info('[Purchase#' . $purchase->id . '] Sending Ticket-Mail.');
                    Mail::to($purchase->customer)->send(new TicketsPaid($purchase));
                }
            } elseif( $payment->isOpen() ) {
                /*
                * The payment is open.
                */
            } elseif( $payment->isPending() ) {
                /*
                * The payment is pending.
                */
            } elseif( $payment->isFailed() ) {
                /*
                * The payment has failed.
                */
                $purchase->deleteWithAllData();
            } elseif( $payment->isExpired() ) {
                /*
                * The payment is expired.
                */
                $purchase->deleteWithAllData();
            } elseif( $payment->isCanceled() ) {
                /*
                * The payment has been canceled.
                */
                $purchase->deleteWithAllData();
            } elseif( $payment->hasRefunds() ) {
                /*
                * The payment has been (partially) refunded.
                * The status of the payment is still "paid"
                */
            } elseif( $payment->hasChargebacks() ) {
                /*
                * The payment has been (partially) charged back.
                * The status of the payment is still "paid"
                */
            }

            // Update the purchase's state
            $purchase->state = $payment->status;
            $purchase->state_updated = new \DateTime();
            $purchase->save();

        } catch (\Mollie\Api\Exceptions\ApiException $e) {
            throw new PaymentProviderException( $e );
        }
    }

}
