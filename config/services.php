<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model'  => App\Models\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'desk' => [
        'auth'            => env('DESK_AUTH'),
        'client_username' => env('DESK_USERNAME'),
        'client_password' => env('DESK_PASSWORD'),
        'client_id'       => env('DESK_CLIENT_ID'),
        'client_secret'   => env('DESK_SECRET'),
        'base_url'        => env('DESK_URL'),
    ],

    'filepicker' => [
        'key' => env('FILEPICKER_KEY'),
    ],

    'salesforce' => [
        'enabled'     => env('SALESFORCE_ENABLED'),
        'mode'        => env('SALESFORCE_MODE'),
        'api_limit'   => env('SALESFORCE_API_LIMIT'),
        'cutout_date' => env('SALESFORCE_CUTOUT_DATE'),
        'live'        => [
            'consumer_key'    => env('SALESFORCE_KEY_LIVE'),
            'consumer_secret' => env('SALESFORCE_SECRET_LIVE'),
            'login_url'       => 'https://login.salesforce.com/',
            'oauth_url'       => env('SALESFORCE_OAUTH_URL_LIVE'),
            'token'           => env('SALESFORCE_TOKEN_LIVE'),
        ],
        'sandbox'     => [
            'consumer_key'    => env('SALESFORCE_KEY_SANDBOX'),
            'consumer_secret' => env('SALESFORCE_SECRET_SANDBOX'),
            'login_url'       => 'https://test.salesforce.com/',
            'oauth_url'       => env('SALESFORCE_OAUTH_URL_SANDBOX'),
            'token'           => env('SALESFORCE_TOKEN_SANDBOX'),
        ],
    ],

    'lob' => [
        'enabled' => env('LOB_ENABLED'),
        'key'     => env('LOB_KEY'),
    ],

    'ga' => [
        'enabled' => env('GANALYTICS'),
        'key'     => env('GANALYTICS_KEY'),
    ],

    'gtag' => [
        'enabled' => env('GTAG_ENABLED'),
        'key'     => env('GTAG_KEY'),
    ],

    'adworks' => [
        'enabled' => env('ADWORKS_ENABLED'),
    ],

    'facebook_pixel' => [
        'enabled' => env('FACEBOOK_PIXEL'),
    ],

    'drift' => [
        'enabled' => env('DRIFT_ENABLED'),
        'key'     => env('DRIFT_KEY'),
        'except'  => 'store/*',
    ],

    'google_places' => [
        'enabled' => env('GOOGLE_PLACES_ENABLED'),
        'key'     => env('GOOGLE_PLACES_KEY'),
    ],

    'zarget' => [
        'enabled' => env('ZARGET_ENABLED'),
    ],

    'hubspot' => [
        'api'        => [
            'enabled'       => env('HUBSPOT_API_ENABLED'),
            'client_id'     => env('HUBSPOT_API_CLIENT_ID'),
            'client_secret' => env('HUBSPOT_API_CLIENT_SECRET'),
            'refresh_token' => env('HUBSPOT_API_REFRESH_TOKEN'),
            'portal_id'     => env('HUBSPOT_API_PORTAL_ID'),
            'forms'         => [
                'work_with_us'   => env('HUBSPOT_API_FORM_WORK_WITH_US'),
                'campus_manager' => env('HUBSPOT_API_FORM_CAMPUS_MANAGER'),
                'wizard'         => env('HUBSPOT_API_FORM_WIZARD'),
                'checkout'       => env('HUBSPOT_API_FORM_CHECKOUT'),
            ],
        ],
        'javascript' => [
            'enabled' => env('HUBSPOT_JAVASCRIPT_ENABLED'),
        ],
    ],

    'freshmarketer' => [
        'enabled' => env('FRESHMARKETER_ENABLED'),
    ],

    'monsterin' => [
        'enabled' => env('MONSTERIN_ENABLED'),
    ],

    'gatsby' => [
        'enabled' => env('GATSBY_ENABLED'),
    ],
];
