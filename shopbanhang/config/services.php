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
    
    'google' => [

        'client_id' => '92698640780-a3k9npvr3judhcvuslt8gp59b42ju2e7.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'https://shopbanhang.laravel.com/auth/google/callback',

    ],
    'facebook' => [
        'client_id' => '410631331052743',
        'client_secret' => 'e75491dc790714335a29b9c070c5ed8b',
        'redirect' => 'https://shopbanhang.laravel.com/auth/facebook/callback',
    ],

];
