<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single', 'email', 'database', 'syslog'],
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'email' => [
            'driver' => 'monolog',
            'handler' => App\Logging\EmailLogHandler::class,
            'level' => env('LOG_LEVEL_EMAIL', 'error'),
        ],

        'database' => [
            'driver' => 'monolog',
            'handler' => App\Logging\DatabaseLogHandler::class,
            'level' => env('LOG_LEVEL_DATABASE', 'debug'),
        ],

        'syslog' => [
            'driver' => 'syslog',
            'tap' => [App\Logging\SysLogFormatter::class],
            'level' => 'debug',
        ],
    ],

];
