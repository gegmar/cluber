<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sofortueberweisung
    |--------------------------------------------------------------------------
    |
    | You need an own SOFORT Gateway-Project, where you can create a Gateway-Project
    | to receive an API-Key.
    |
 */

    'sofortConfigKey' => env('KLARNA_CONFIG_KEY', ''),


    /*
    |--------------------------------------------------------------------------
    | PayPal
    |--------------------------------------------------------------------------
    |
    | Create a PayPal-merchant-account, go to the developer portal and create a
    | PayPal Rest Express Checkout Client. Enter those credentials into the .env-file.
    |
     */

    'payPalClientId' => env('PAYPAL_CLIENT_ID', ''),
    'payPalClientSecret' => env('PAYPAL_CLIENT_SECRET', ''),
];
