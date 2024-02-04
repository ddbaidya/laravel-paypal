<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Paypal Configuration File
    |--------------------------------------------------------------------------
    |
    | This document has been created by Ddbaidya\LaravelPaypal.
    | Exercise caution before making any modifications to this file,
    | as it contains all the configurations related to PayPal payments..
    |
    |
    */
    'mode'    => env('PAYPAL_MODE', 'sandbox'), // 'sandbox' Or 'live'.
    'client_id'         => env('PAYPAL_CLIENT_ID', ''),
    'client_secret'     => env('PAYPAL_CLIENT_SECRET', ''),
];
