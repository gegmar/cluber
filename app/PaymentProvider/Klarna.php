<?php

namespace App\PaymentProvider;

use Sofort\SofortLib\Sofortueberweisung;
use App\Purchase;

class Klarna
{
    // Find docs @ https://github.com/sofort/sofortlib-php

    /**
     * 
     */
    public function getPaymentUrl(Purchase $purchase)
    {

        $configKey = config('sofortConfigKey');

        $sofort = new Sofortueberweisung($configKey);

        $sofort->setAmount($paymentAmount);
        $sofort->setCurrencyCode('EUR');
        $sofort->setReason('');
    }

}
