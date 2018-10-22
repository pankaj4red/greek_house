<?php

namespace App\Logging;

use App\Jobs\ProcessDatabaseLog;
use App\Logging\Logger as GHLogger;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Monolog\Handler\AbstractProcessingHandler;

class DatabaseLogHandler extends AbstractProcessingHandler
{
    use DispatchesJobs;

    /**
     * @param array $record
     */
    protected function write(array $record)
    {
        try {
            if ($record['level'] < array_search(config('logging.channels.database.level'), self::$levels)) {
                return;
            }

            $record = GHLogger::processRecord($record);
            $method = null;
            $args = null;
            if (isset($record['context']['trace'])) {
                $trace = $record['context']['trace'];
                unset($record['context']['trace']);
            } else {
                $trace = debug_backtrace(0);
            }

            if (isset($record['context']['request'])) {
                foreach ($record['context']['request'] as $key => $context) {
                    if ($context instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                        $record['context']['request'][$key] = [
                            'name'      => $context->getClientOriginalName(),
                            'extension' => $context->getClientOriginalExtension(),
                            'mime'      => $context->getClientMimeType(),
                            'size'      => $context->getClientSize(),
                        ];
                    }
                }
            }

            $logInformation = [
                'channel'  => $record['channel'],
                'level'    => $this->getLevelText($record['level']),
                'message'  => $record['message'],
                'user_id'  => $record['extra']['user_id'],
                'username' => $record['extra']['username'],
                'ip'       => $record['extra']['ip'],
                'context'  => $record['context'],
                'extra'    => $record['extra'],
                'trace'    => $this->traceToString($trace),
            ];
            $this->dispatch(new ProcessDatabaseLog($logInformation));
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

    private function traceToString($trace)
    {
        $string = '';
        if (is_array($trace)) {
            for ($i = 0; $i < count($trace); $i++) {
                $row = $trace[$i];
                $string .= ($i + 1).') ';
                if (isset($row['file'])) {
                    $string .= $row['file'];
                }
                if (isset($row['line'])) {
                    $string .= '('.$row['line'].')';
                }
                if (! empty($string)) {
                    $string .= ': ';
                }
                if (isset($row['class'])) {
                    $string .= $row['class'].'::';
                }
                if (isset($row['function'])) {
                    $string .= $row['function'];
                }
                $string .= '(';
                $string .= ')';
                $string .= PHP_EOL;
            }
        } else {
            $string = (string) $trace;
        }

        return $string;
    }

    private function getLevelText($level)
    {
        return isset(static::$levels[$level]) ? static::$levels[$level] : 'DEBUG';
    }
}
