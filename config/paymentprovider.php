<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sofortueberweisung
    |--------------------------------------------------------------------------
    |
    | You need an own SOFORT Gateway-Project, where you can set 
    |
    | Supported: "smtp", "sendmail", "mailgun", "mandrill", "ses",
    |            "sparkpost", "log", "array"
    |
    */

    'sofortConfigKey' => env('KLARNA_CONFIG_KEY', ''),
];
