<?php

return [
    'contacts' => [
        'support' => [
            'name' => 'Greek House',
            'email' => 'support@greekhouse.org',
        ],
        'sales' => [
            'name' => 'Sales',
            'email' => 'greek-house-sales@googlegroups.com',
        ],
        'hello' => [
            'name' => 'Greek House',
            'email' => 'hello@greekhouse.org',
        ],
        'designer' => [
            'name' => 'Designer Group',
            'email' => 'GHDESIGN@googlegroups.com',
        ],
    ],

    'mail' => [
        'prefix' => env('MAIL_PREFIX'),
        'override' => env('MAIL_OVERRIDE'),
        'from' => [
            'email' => env('MAIL_FROM'),
            'name' => env('MAIL_FROM_NAME'),
        ],
        'from_new_campaign' => [
            'email' => env('MAIL_FROM_NEW_CAMPAIGN'),
            'name' => env('MAIL_FROM_NEW_CAMPAIGN_NAME'),
        ],
        'support' => [
            'subject' => env('MAIL_SUPPORT_SUBJECT'),
            'email' => env('MAIL_SUPPORT'),
            'name' => env('MAIL_SUPPORT_NAME'),
        ],
        'bcc' => [
            'email' => env('MAIL_BCC'),
            'name' => env('MAIL_BCC_NAME'),
        ],
        'error' => [
            'email' => env('MAIL_ERROR'),
            'name' => env('MAIL_ERROR_NAME'),
        ],
        'fulfillment' => [
            'email' => env('MAIL_FULFILLMENT'),
            'name' => env('MAIL_FULFILLMENT_NAME'),
        ],
        'design_new' => [
            'email' => env('MAIL_DESIGN_NEW'),
            'name' => env('MAIL_DESIGN_NEW_NAME'),
        ],
        'jobs' => [
            'email' => env('MAIL_JOBS'),
            'name' => env('MAIL_JOBS_NAME'),
        ],
        'reports' => [
            'email' => env('MAIL_FROM_REPORTS'),
            'name' => env('MAIL_FROM_REPORTS_NAME'),
        ],
        'log_report' => [
            'email' => env('MAIL_LOG_REPORT'),
        ],
        'schedule_log' => [
            'email' => env('MAIL_SCHEDULE_LOG'),
        ],
    ],
];