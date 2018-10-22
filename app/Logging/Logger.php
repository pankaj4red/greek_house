<?php

namespace App\Logging;

use App;
use App\Jobs\ProcessEmailLog;
use DateTime;
use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Message;
use Illuminate\Support\MessageBag;
use Log;
use Request;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Device;
use Sinergi\BrowserDetector\Os;

class Logger
{
    use DispatchesJobs;

    /**
     * Module that is currently being logged (usually set by the Controller
     *
     * @var string
     */
    public static $module = '';

    /**
     * Sets the module that is currently being logged
     *
     * @param string $module
     */
    public static function setModule($module)
    {
        static::$module = $module;
    }

    /**
     * Forces a method of the current Request (for testing purposes)
     *
     * @var string
     */
    public static $forceMethod = null;

    /**
     * Returns the method of the current Request
     *
     * @return string
     */
    public static function getMethod()
    {
        if (static::$forceMethod) {
            return static::$forceMethod;
        }

        return Request::method();
    }

    /**
     * Forces a method of the current Request (for testing purposes)
     *
     * @param $method
     */
    public static function forceMethod($method)
    {
        static::$forceMethod = $method;
    }

    /**
     * Forces a url for the current Request (for testing purposes)
     *
     * @var string
     */
    public static $forceUrl = null;

    /**
     * Returns the url of the current Request
     *
     * @return string
     */
    public static function getUrl()
    {
        if (static::$forceUrl) {
            return static::$forceUrl;
        }

        return Request::url();
    }

    /**
     * Forces a url of the current Request (for testing purposes)
     *
     * @param string $url
     */
    public static function forceUrl($url)
    {
        static::$forceUrl = $url;
    }

    public static function processRecord($record)
    {
        if (App::environment() == 'testing') {
            return $record;
        }

        if ($record['channel'] == 'local') {
            if (mb_strpos($record['message'], '#System') !== false) {
                $record['channel'] = 'system';
            }
        }
        if (isset($record['context']['exception'])) {
            /** @var \Exception $exception */
            $exception = $record['context']['exception'];
            $record['context']['file'] = $exception->getFile();
            $record['context']['line'] = $exception->getLine();
            $record['context']['trace'] = call_stack_normalize_trace($exception->getTrace());
            unset($record['context']['exception']);
        }
        $record['extra']['user_id'] = \Auth::user() ? \Auth::user()->id : 0;
        $record['extra']['username'] = \Auth::user() ? \Auth::user()->username : 'anonymous';
        $record['extra']['ip'] = \Request::ip();
        $record['extra']['url'] = \Request::fullUrl();
        $record['context']['request'] = array_except(\Request::all(), ['_token', 'password', 'password_confirmation']);
        $session = \Session::all();
        if (isset($session['_token'])) {
            unset($session['_token']);
        }
        if (isset($session['flash'])) {
            if (empty($session['flash']['old'])) {
                unset($session['flash']['old']);
            }
            if (empty($session['flash']['new'])) {
                unset($session['flash']['new']);
            }
        }
        if (isset($session['_previous']) && isset($session['_previous']['url'])) {
            $session['_previous'] = $session['_previous']['url'];
        }
        foreach ($session as $key => $value) {
            if (empty($session[$key])) {
                unset($session[$key]);
            }
        }
        $record['context']['session'] = $session;

        try {
            $browserInfo = new Browser();
            $osInfo = new Os();
            $deviceInfo = new Device();
            $record['extra']['browser'] = trim(str_replace('unknown', '', $browserInfo->getName().' '.$browserInfo->getVersion().(get_bot($browserInfo->getUserAgent()->getUserAgentString()) !== null ? ' ['.get_bot($browserInfo->getUserAgent()->getUserAgentString()).']' : '')));
            $record['extra']['os'] = trim(str_replace('unknown', '', $osInfo->getName().' '.$osInfo->getVersion()));
            $record['extra']['hardware'] = trim(str_replace('unknown', '', $deviceInfo->getName()));
        } catch (\Exception $ex) {
            $record['extra']['browser'] = 'Unknown Browser';
            $record['extra']['os'] = 'Unknown OS';
            $record['extra']['hardware'] = 'Unknown Hardware';
        }

        $recordFinal = [
            'level_name' => $record['level_name'],
            'message'    => $record['message'],
            'channel'    => $record['channel'],
            'datetime'   => $record['datetime'] instanceof DateTime ? $record['datetime']->format('Y-m-d H:i:s') : $record['datetime'],
            'extra'      => $record['extra'],
            'context'    => $record['context'],
        ];
        foreach ($record as $key => $value) {
            if (! in_array($key, ['level_name', 'message', 'channel', 'datetime', 'extra', 'context'])) {
                $recordFinal[$key] = $value;
            }
        }

        return $recordFinal;
    }

    /**
     * Registers the email sending event
     */
    public static function listenToEmail()
    {
        if (App::environment() == 'testing') {
            return;
        }

        \Event::listen(MessageSending::class, function (MessageSending $event) {
            $message = $event->message;
            $to = '';
            $cc = '';
            $from = '';
            foreach ($message->getTo() as $emailAddress => $name) {
                if (! empty($to)) {
                    $to .= ', ';
                }
                $to .= '<'.$emailAddress.'> "'.$name.'"';
            }
            foreach ($message->getFrom() as $emailAddress => $name) {
                if (! empty($from)) {
                    $from .= ', ';
                }
                $from .= '<'.$emailAddress.'> "'.$name.'"';
            }
            if ($message->getCC()) {
                foreach ($message->getCC() as $emailAddress => $name) {
                    if (! empty($cc)) {
                        $cc .= ', ';
                    }
                    $cc .= '<'.$emailAddress.'> "'.$name.'"';
                }
            }
            //TODO: log attachments
            /*
            $attachments = [];
            foreach ($message->getChildren() as $attachment) {
                dd($message);
                $attachments[] = [
                    'name' => $attachment->getFilename(),
                    'content' => $attachment->getBody()
                ];
            }
            */

            $body = $message->getBody();
            $body = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $body);
            $body = strip_tags($body);

            $emailInformation = [
                'to'      => $to,
                'from'    => $from,
                'cc'      => $cc,
                'subject' => $message->getSubject(),
                'body'    => $body,
                //'attachments' => $attachments,
            ];
            event(new ProcessEmailLog($emailInformation));
        });
    }

    /**
     * Log access
     *
     * @param string $message
     */
    public static function logAccess($message = '')
    {
        if (App::environment() == 'testing') {
            return;
        }

        try {
            Log::debug(str_clean('['.static::getMethod().'] ('.static::$module.') '.$message.' '.static::getUrl()));
        } catch (\Exception $ex) {
            try {
                static::logError($ex->getMessage(), ['exception' => $ex]);
            } catch (\Exception $ex) {
                static::logFallback($ex);
            }
        }
    }

    /**
     * Log Debug
     *
     * @param string $message
     * @param array  $context
     */
    public static function logDebug($message, $context = [])
    {
        if (App::environment() == 'testing') {
            return;
        }

        try {
            Log::debug(str_clean('('.static::$module.') '.$message), $context);
        } catch (\Exception $ex) {
            try {
                Log::error($ex->getMessage(), ['exception' => $ex]);
            } catch (\Exception $ex) {
                static::logFallback($ex);
            }
        }
    }

    /**
     * Log Logic Errors (Usually validation issues)
     *
     * @param array $errors
     * @return mixed
     */
    public static function logLogicError($errors = [])
    {
        if (App::environment() == 'testing') {
            return;
        }

        try {
            if (is_string($errors)) {
                static::logLogicError([$errors]);

                return;
            }
            if ($errors instanceof MessageBag) {
                $errors = $errors->all();
            }
            $errorList = [];
            foreach ($errors as $key1 => $error) {
                if (is_array($error)) {
                    if (count($error) > 1) {
                        foreach ($error as $key2 => $value) {
                            $errorList[$key1.'.'.$key2] = $value;
                        }
                    } else {
                        $errorList[$key1] = array_values($error)[0];
                    }
                } else {
                    $errorList[$key1] = (string) $error;
                }
            }
            $message = implode(', ', $errorList);
            Log::debug(str_clean('[Logic] ('.static::$module.') '.$message.' '.static::getUrl()), $errors);
        } catch (\Exception $ex) {
            try {
                Log::error($ex->getMessage(), ['exception' => $ex]);
            } catch (\Exception $ex) {
                static::logFallback($ex);
            }
        }
    }

    /**
     * Track item history
     *
     * @param       $objectType
     * @param       $objectId
     * @param       $action
     * @param array $data
     * @param array $userContext
     * @param array $campaignContext
     * @param array $orderContext
     */
    public static function track(
        $objectType,
        $objectId,
        $action,
        $data = [],
        $userContext = [],
        $campaignContext = [],
        $orderContext = []
    ) {
        if (App::environment() == 'testing') {
            return;
        }

        try {
            log_repository()->track($objectType, $objectId, $action, [
                'data'     => $data,
                'user'     => $userContext,
                'campaign' => $campaignContext,
                'order'    => $orderContext,
            ]);
        } catch (\Exception $ex) {
            try {
                Log::error($ex->getMessage(), ['exception' => $ex]);
            } catch (\Exception $ex) {
                static::logFallback($ex);
            }
        }
    }

    /**
     * Log Notice
     *
     * @param       $message
     * @param array $context
     */
    public static function logNotice($message, $context = [])
    {
        if (App::environment() == 'testing') {
            return;
        }

        try {
            Log::notice(str_clean('('.static::$module.') '.$message), $context);
        } catch (\Exception $ex) {
            try {
                Log::notice($ex->getMessage(), ['exception' => $ex]);
            } catch (\Exception $ex) {
                static::logFallback($ex);
            }
        }
    }

    /**
     * Log Warning
     *
     * @param       $message
     * @param array $context
     */
    public static function logWarning($message, $context = [])
    {
        if (App::environment() == 'testing') {
            return;
        }

        try {
            Log::warning(str_clean('('.static::$module.') '.$message), $context);
        } catch (\Exception $ex) {
            try {
                Log::warning($ex->getMessage(), ['exception' => $ex]);
            } catch (\Exception $ex) {
                static::logFallback($ex);
            }
        }
    }

    /**
     * Log Alert
     *
     * @param       $message
     * @param array $context
     */
    public static function logAlert($message, $context = [])
    {
        if (App::environment() == 'testing') {
            return;
        }

        try {
            Log::alert(str_clean('('.static::$module.') '.$message), $context);
        } catch (\Exception $ex) {
            try {
                Log::alert($ex->getMessage(), ['exception' => $ex]);
            } catch (\Exception $ex) {
                static::logFallback($ex);
            }
        }
    }

    /**
     * Log Error
     *
     * @param       $message
     * @param array $context
     */
    public static function logError($message, $context = [])
    {
        if (App::environment() == 'testing') {
            return;
        }

        try {
            Log::error(str_clean('('.static::$module.') '.$message), $context);
        } catch (\Exception $ex) {
            try {
                Log::error($ex->getMessage(), ['exception' => $ex]);
            } catch (\Exception $ex) {
                static::logFallback($ex);
            }
        }
    }

    /**
     * Log API Call
     *
     * @param string $message
     * @param array  $context
     * @return null
     */
    public static function logApi($message, $context = [])
    {
        if (App::environment() == 'testing') {
            return;
        }

        try {
            return log_repository()->logApi($message, $context);
        } catch (\Exception $ex) {
            try {
                Log::error($ex->getMessage(), ['exception' => $ex]);
            } catch (\Exception $ex) {
                static::logFallback($ex);
            }

            return null;
        }
    }

    /**
     * LÇog API Call Response
     *
     * @param integer         $logId
     * @param string|string[] $response
     */
    public static function logApiResponse($logId, $response)
    {
        if (App::environment() == 'testing') {
            return;
        }

        try {
            log_repository()->logApiResponse($logId, $response);
        } catch (\Exception $ex) {
            try {
                Log::error($ex->getMessage(), ['exception' => $ex]);
            } catch (\Exception $ex) {
                static::logFallback($ex);
            }
        }
    }

    /**
     * Log Salesforce
     *
     * @param string $message
     */
    public static function logSalesforce($message)
    {
        if (App::environment() == 'testing') {
            return;
        }

        try {
            log_repository()->logSalesforce($message);
        } catch (\Exception $ex) {
            try {
                Log::error($ex->getMessage(), ['exception' => $ex]);
            } catch (\Exception $ex) {
                static::logFallback($ex);
            }
        }
    }

    /**
     * @param string    $message
     * @param Exception $exception
     * @throws Exception
     */
    public static function logApiError($message, $exception = null)
    {
        if (App::environment() == 'testing') {
            return;
        }

        try {
            log_repository()->logApiError($message, $exception);
        } catch (\Exception $ex) {
            try {
                Log::error($ex->getMessage(), ['exception' => $ex]);
            } catch (\Exception $ex) {
                static::logFallback($ex);
            }
        }
    }

    public static function logFallback(Exception $ex)
    {
        if (App::environment() == 'testing') {
            return;
        }

        try {
            $record = [
                'level'   => 'FALLBACK',
                'channel' => 'fallback',
                'message' => $ex->getMessage(),
                'extra'   => [
                    'user_id'  => \Auth::user() ? \Auth::user()->id : 0,
                    'username' => \Auth::user() ? \Auth::user()->username : 'anonymous',
                    'ip'       => \Request::ip(),

                ],
                'context' => [
                    'request' => \Request::all(),
                    'session' => \Session::all(),
                    'file'    => $ex->getFile(),
                    'line'    => $ex->getLine(),
                    'stack'   => call_stack_print($ex->getTrace()),
                    'method'  => 'N/A',
                    'args'    => [],
                ],
            ];

            try {
                $browserInfo = new Browser();
                $osInfo = new Os();
                $deviceInfo = new Device();
                $record['extra']['browser'] = trim(str_replace('unknown', '', $browserInfo->getName().' '.$browserInfo->getVersion()));
                $record['extra']['os'] = trim(str_replace('unknown', '', $osInfo->getName().' '.$osInfo->getVersion()));
                $record['extra']['hardware'] = trim(str_replace('unknown', '', $deviceInfo->getName()));
            } catch (\Exception $ex) {
                $record['extra']['browser'] = 'Unknown Browser';
                $record['extra']['os'] = 'Unknown OS';
                $record['extra']['hardware'] = 'Unknown Hardware';
            }

            $record['message'] = mb_substr($record['message'], 0, 200);

            \Mail::send('emails.error_alert', ['record' => $record], function (Message $message) use ($record) {
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(config('notifications.mail.error.email'), config('notifications.mail.error.name'));
                $message->subject(config('notifications.mail.prefix').'[Exception][FailBack] '.$record['message'].' ['.uniqid().']');
            });

            return true;
        } catch (\Exception $ex) {
            //Logger::logError($ex->getMessage(), ['exception' => $ex]);
            return false;
        }
    }
}
