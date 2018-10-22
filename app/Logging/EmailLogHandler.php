<?php

namespace App\Logging;

use App\Jobs\SendEmailJob;
use App\Logging\Logger as GHLogger;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Monolog\Handler\AbstractProcessingHandler;

class EmailLogHandler extends AbstractProcessingHandler
{
    use DispatchesJobs;

    /**
     * @param array $record
     */
    protected function write(array $record)
    {
        try {
            if ($record['level'] < array_search(config('logging.channels.email.level'), self::$levels)) {
                return;
            }

            $record = GHLogger::processRecord($record);
            $method = null;
            $args = null;
            if (isset($record['context']['trace'])) {
                $trace = $record['context']['trace'];
                unset($record['context']['trace']);
            } else {
                $trace = debug_backtrace();
                if (call_stack_args($trace, true)) {
                    $args = call_stack_args($trace, true);
                }
                if (call_stack_method($trace, true)) {
                    $method = call_stack_method($trace, true);
                }
            }
            $record['context'] = array_merge(['args' => json_encode($args)], $record['context']);
            $record['context'] = array_merge(['method' => $method], $record['context']);
            $record['context']['stack'] = call_stack_print($trace, true);
            $record['context']['message'] = $record['message'];
            $record['level'] = $this->getLevelText($record['level']);
            $this->dispatch(new SendEmailJob('sendErrorAlert', [$record]));
        } catch (\Exception $ex) {
            GHLogger::logFallback($ex);
        }
    }

    private static $levels = [
        100 => 'debug',
        200 => 'info',
        250 => 'notice',
        300 => 'warning',
        400 => 'error',
        500 => 'critical',
        550 => 'alert',
        600 => 'emergency',
        700 => 'fallback',
    ];

    private function getLevelText($level)
    {
        return isset(static::$levels[$level]) ? static::$levels[$level] : 'DEBUG';
    }
}
