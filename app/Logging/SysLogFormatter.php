<?php

namespace App\Logging;

use Monolog\Formatter\JsonFormatter;

class SysLogFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param  \Illuminate\Log\Logger $logger
     * @return void
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $logFormat = "%datetime% [%level_name%] (%channel%): %message% %context% %extra%\n";
            $formatter = new JsonFormatter($logFormat);
            $handler->setFormatter($formatter);
        }
    }
}