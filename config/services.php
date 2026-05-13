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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'easyparcel' => [
        'key' => env('EASYPARCEL_API_KEY'),
        'url' => env('EASYPARCEL_API_URL', 'https://demo.easyparcel.com/v1'),
        'sender_postcode' => '40000',
        'sender_state'    => 'Selangor',
        'sender_city'     => 'Shah Alam',
        'sender_name'     => 'Reef Store Warehouse',
        'sender_phone'    => '0123456789',
        'sender_address'  => 'No 1, Jalan Perindustrian 2, Kawasan Perindustrian',
    ],

];
