<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    |
    | Language that should primarily used for payment pages.
    |
     */
    'locale' => env('PAYMENT_LOCALE', 'de_AT'),

    /*
    |--------------------------------------------------------------------------
    | Mollie
    |--------------------------------------------------------------------------
    |
    | Get credentials by creating an account @ mollie.com . Enter the api key
    | into the .env-file.
    |
     */
    'mollieApiKey' => env('MOLLIE_API_KEY', ''),

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
