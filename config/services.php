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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'rest_countries' => [
        'api_version' => env('REST_COUNTRIES_API_VERSION', 'v3.1'),
    ],

    'open_weather' => [
        'api_key' => env('OPEN_WEATHER_API_KEY'),
        'api_version' => env('OPEN_WEATHER_API_VERSION', '3.0'),
    ],

    'weather_stack' => [
        'api_key' => env('WEATHER_STACK_API_KEY')
    ],

    'accuweather' => [
        'api_key' => env('ACCUWEATHER_API_KEY'),
        'api_version' => env('ACCUWEATHER_API_VERSION', 'v1'),
    ]
];
