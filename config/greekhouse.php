<?php

return [
    'css_version' => env('CSS_VERSION'),
    'product' => [
        'price_limit' => env('PRODUCT_PRICE_LIMIT'),
        'expensive_threshold' => env('PRODUCT_EXPENSIVE_THRESHOLD'),
    ],
    'campaign' => [
        'quantity_not_met_retries' => env('CAMPAIGN_QUANTITY_RETRY'),
    ],
    'billing' => [
        'mode' => env('BILLING_MODE'), //live/test
        'provider' => env('BILLING_PROVIDER'), //AUTHORIZE
        'allow_test' => env('BILLING_ALLOW_TEST'),
        'providers' => [
            'authorize' => [
                'login' => env('BILLING_AUTHORIZE_LOGIN'),
                'key' => env('BILLING_AUTHORIZE_KEY'),
                'public_key' => env('BILLING_AUTHORIZE_PUBLIC_KEY'),
                'secret' => env('BILLING_AUTHORIZE_SECRET'),
                'dashboard' => env('BILLING_AUTHORIZE_DASHBOARD'),
                'dashboard_charge' => env('BILLING_AUTHORIZE_DASHBOARD_CHARGE'),
                'dpm_url' => [
                    'live' => 'https://secure2.authorize.net/gateway/transact.dll',
                    'test' => 'https://test.authorize.net/gateway/transact.dll',
                ],
            ],
            'braintree' => [
                'environment' => env('BILLING_BRAINTREE_ENVIRONMENT'),
                'merchantId' => env('BILLING_BRAINTREE_MERCHANT_ID'),
                'publicKey' => env('BILLING_BRAINTREE_PUBLIC_KEY'),
                'privateKey' => env('BILLING_BRAINTREE_PRIVATE_KEY'),
            ],
            'manual' => [
                'dashboard' => env('BILLING_AUTHORIZE_DASHBOARD'),
                'dashboard_charge' => env('BILLING_AUTHORIZE_DASHBOARD_CHARGE'),
            ],
        ],
    ],
    'seeder' => [
        'include_images' => env('SEEDER_INCLUDE_IMAGES', false),
    ],
    'branch' => env('GREEKHOUSE_BRANCH'),
    'developer' => env('GREEKHOUSE_DEVELOPER'),
    'proxies' => env('LOAD_BALANCER_IP') ? [env('LOAD_BALANCER_IP')] : null,
];
