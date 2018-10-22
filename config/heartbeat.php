<?php

return [

    'sf_leads' => env('HEARTBEAT_SF_LEADS'),
    'process_payments' => env('HEARTBEAT_PROCESS_PAYMENTS'),
    'void_payments' => env('HEARTBEAT_VOID_PAYMENTS'),
    'printing_date' => env('HEARTBEAT_PRINTING_DATE'),
    'sf_contacts' => env('HEARTBEAT_SF_CONTACTS'),
    'sf_accounts' => env('HEARTBEAT_ACCOUNTS'),
    'sf_campaigns' => env('HEARTBEAT_CAMPAIGNS'),
    'awaiting_approval_reminder' => env('HEARTBEAT_AWAITING_APPROVAL_REMINDER'),
    'awaiting_approval_follow_up' => env('HEARTBEAT_AWAITING_APPROVAL_FOLLOW_UP'),
    'collecting_payment_reminder' => env('HEARTBEAT_COLLECTING_PAYMENT_REMINDER'),
    'collecting_payment_follow_up' => env('HEARTBEAT_COLLECTING_PAYMENT_FOLLOW_UP'),
    'deadline_reminder' => env('HEARTBEAT_DEADLINE_REMINDER'),
    'deadline_follow_up' => env('HEARTBEAT_DEADLINE_FOLLOW_UP'),
    'log_report' => env('HEARTBEAT_LOG_REPORT'),
    'close_date' => env('HEARTBEAT_CLOSE_DATE'),
];
