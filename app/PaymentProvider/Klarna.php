<?php

namespace App\PaymentProvider;

use Sofort\SofortLib\Sofortueberweisung;
use App\Purchase;
use App\Exceptions\PaymentProviderException;

class Klarna
{
    // Find docs @ https://github.com/sofort/sofortlib-php

    /**
     * 
     */
    public static function getPaymentUrl(Purchase $purchase)
    {
        $configKey = config('paymentprovider.sofortConfigKey');

        $sofort = new Sofortueberweisung($configKey);

        $sofort->setAmount($purchase->total());
        $sofort->setCurrencyCode('EUR');
        $sofort->setReason('Ticket purchase #' . $purchase->id);
        $sofort->setSuccessUrl(route('ts.payment.successful', [
            'purchase' => $purchase->random_id,
            'secret' => $purchase->payment_secret
        ]));
        $sofort->setAbortUrl(route('ts.payment.aborted', ['purchase' => $purchase->random_id]));
        $sofort->setTimeoutUrl(route('ts.payment.timedout', ['purchase' => $purchase->random_id]));
        $sofort->setNotificationUrl(route('ts.payment.notify.loss', [
            'purchase' => $purchase->random_id,
            'secret' => $purchase->payment_secret
        ]), 'loss');
        $sofort->setNotificationUrl(route('ts.payment.notify.pending', [
            'purchase' => $purchase->random_id,
            'secret' => $purchase->payment_secret
        ]), 'pending');
        $sofort->setNotificationUrl(route('ts.payment.notify.received', [
            'purchase' => $purchase->random_id,
            'secret' => $purchase->payment_secret
        ]), 'received');
        $sofort->setNotificationUrl(route('ts.payment.notify.refunded', [
            'purchase' => $purchase->random_id,
            'secret' => $purchase->payment_secret
        ]), 'refunded');

        $sofort->sendRequest();

        if ($sofort->isError()) {
            // SOFORT-API didn't accept the data
            $errors = $sofort->getErrors();
            throw new PaymentProviderException("SOFORT got errors...");
        }
        // get unique transaction-ID useful for check payment status
        $transactionId = $sofort->getTransactionId();
        Log::info('[Klarna] TransactionId for purchase #' . $purchase->id . ' is ' . $transactionId);
        // buyer must be redirected to $paymentUrl else payment cannot be successfully completed!
        return $sofort->getPaymentUrl();
    }

}
