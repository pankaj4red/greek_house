<?php

namespace App\Repositories\Models;

use Carbon\Carbon;

class LogRepository
{
    public function logSalesforce($message)
    {
        \DB::connection('logs')->table('logs')->insert([
            'channel'    => 'sf',
            'message'    => $message,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function logChange($message, $context)
    {
        \DB::connection('logs')->table('logs')->insert([
            'channel'    => 'change',
            'message'    => $message,
            'user_id'    => \Auth::user() ? \Auth::user()->id : null,
            'username'   => \Auth::user() ? \Auth::user()->username : null,
            'ip'         => \Request::ip(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $logId = \DB::connection('logs')->getPdo()->lastInsertId();

        $this->insertDetails($logId, $context);
    }

    public function track($objectType, $objectId, $action, $context)
    {
        \DB::connection('logs')->table('logs')->insert([
            'channel'    => 'tracking',
            'level'      => 'info',
            'message'    => $objectType.' ('.$objectId.') '.$action,
            'user_id'    => \Auth::user() ? \Auth::user()->id : null,
            'username'   => \Auth::user() ? \Auth::user()->username : null,
            'ip'         => \Request::ip(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $logId = \DB::connection('logs')->getPdo()->lastInsertId();

        $this->insertDetails($logId, $context);
    }

    public function logApi($message, $context)
    {
        \DB::connection('logs')->table('logs')->insert([
            'channel'    => 'api',
            'message'    => $message,
            'user_id'    => \Auth::user() ? \Auth::user()->id : null,
            'username'   => \Auth::user() ? \Auth::user()->username : null,
            'ip'         => \Request::ip(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $logId = \DB::connection('logs')->getPdo()->lastInsertId();

        $this->insertDetails($logId, ['context' => $context]);

        return $logId;
    }

    public function logApiResponse($logId, $response)
    {
        $this->insertDetails($logId, ['response' => $response]);
    }

    public function log($log)
    {
        \DB::connection('logs')->table('logs')->insert([
            'channel'    => $log['channel'],
            'level'      => $log['level'],
            'message'    => $log['message'],
            'user_id'    => $log['user_id'],
            'username'   => $log['username'],
            'ip'         => $log['ip'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $logId = \DB::connection('logs')->getPdo()->lastInsertId();

        $this->insertDetails($logId, array_only($log, ['context', 'extra', 'trace']));
    }

    private function insertDetails($logId, $data)
    {
        if (! is_array($data)) {
            $data = [$data];
        }
        $data = array_dot($data);
        $details = [];
        foreach ($data as $key => $value) {
            if (is_object($value) && method_exists($value, 'toArray')) {
                $value = $value->toArray();
            }
            if (is_object($value) && method_exists($value, 'toString')) {
                $value = $value->toString();
            }
            if (is_object($value)) {
                $value = get_object_vars($value);
            }
            if (is_array($value)) {
                $value = json_encode($value);
            }
            $detail = ['log_id' => $logId, 'key' => $key, 'value' => (string) $value];
            \DB::connection('logs')->table('log_details')->insert($detail);
        }
    }

    /**
     * @param string     $message
     * @param \Exception $ex
     * @return string
     */
    public function logApiError($message, $ex)
    {
        \DB::connection('logs')->table('logs')->insert([
            'channel'    => 'api',
            'message'    => $message,
            'user_id'    => \Auth::user() ? \Auth::user()->id : null,
            'username'   => \Auth::user() ? \Auth::user()->username : null,
            'ip'         => \Request::ip(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $logId = \DB::connection('logs')->getPdo()->lastInsertId();

        $this->insertDetails($logId, ['exception' => $ex->getMessage()]);

        return $logId;
    }
}