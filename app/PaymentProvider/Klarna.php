<?php

namespace App\PaymentProvider;

use Sofort\SofortLib\Sofortueberweisung;
use App\Purchase;
use App\Exceptions\PaymentProviderException;
use Illuminate\Support\Facades\Log;

/**
 * Class to process requests to Klarna
 * 
 * Find docs @ https://github.com/sofort/sofortlib-php
 */
class Klarna
{
    /**
     * API-Object; initialized by constructor
     */
    protected $sofortApi;

    /**
     * 
     * @param $configKey Configuration key for this exact project
     * @return void
     */
    public function __construct($configKey)
    {
        $this->sofortApi = new Sofortueberweisung($configKey);
    }

    /**
     * Generates for a given Purchase a payment request at Klarna and
     * returns a payment url where the customer can pay the purchase
     * 
     * @param $purchase the customer's purchase
     * @return string PaymentUrl to Klarna for the given purchase
     */
    public function getPaymentUrl(Purchase $purchase)
    {
        $this->sofortApi->setAmount($purchase->total());
        $this->sofortApi->setCurrencyCode('EUR');
        $this->sofortApi->setReason('Ticket purchase #' . $purchase->id);
        $this->sofortApi->setSuccessUrl(route('ts.payment.successful', [
            'purchase' => $purchase->random_id,
            'secret' => $purchase->payment_secret
        ]));
        $this->sofortApi->setAbortUrl(route('ts.payment.aborted', ['purchase' => $purchase->random_id]));
        $this->sofortApi->setTimeoutUrl(route('ts.payment.timedout', ['purchase' => $purchase->random_id]));

        $this->sofortApi->sendRequest();

        if ($this->sofortApi->isError()) {
            // SOFORT-API didn't accept the data
            Log::error($this->sofortApi->getErrors());
            throw new PaymentProviderException("SOFORT got errors...");
        }
        // get unique transaction-ID useful for check payment status
        $transactionId = $this->sofortApi->getTransactionId();
        Log::info('[Klarna] TransactionId for purchase #' . $purchase->id . ' is ' . $transactionId);
        // buyer must be redirected to $paymentUrl else payment cannot be successfully completed!
        return $this->sofortApi->getPaymentUrl();
    }

}
