<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'mshastra' => [
        'url' => 'https://mshastra.com/sendurl.aspx',
        'user' => env('mshastra_user'),
        'pwd' => env('mshastra_pwd'),
        'senderid' => env('mshastra_senderid'),
        'priority' => env('mshastra_priority'),
        'CountryCode' => env('mshastra_CountryCode'),
    ],

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'currency' => env('CASHIER_CURRENCY'),
        'logger' => env('CASHIER_LOGGER'),
        'min' => env('CASHIER_MIN'),
    ],
    'agora' => [
        'app_id' => env('AGORA_APPID'),
        'app_secret' => env('AGORA_SECRET'),
    ],
    'myfatoorah' => [
        'country_iso' => env('MYFATOORAH_COUNTRY_ISO'),
    ],
];
