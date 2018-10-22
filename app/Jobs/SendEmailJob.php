<?php

namespace App\Jobs;

use App\Logging\Logger;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $method;

    protected $parameters;

    function __construct($method, $parameters)
    {
        $this->method = $method;
        $this->parameters = $parameters;
    }

    public function handle(MailService $mailService)
    {
        //        if (\DB::transactionLevel() == 0) {
        //            \DB::reconnect();
        //        }

        if ($this->attempts() >= 10) {
            $this->delete();
        }
        try {
            call_user_func_array([$mailService, $this->method], $this->parameters);
        } catch (\Exception $ex) {
            Logger::logError($ex->getMessage(), [
                'job'        => 'SendEmailJob',
                'method'     => $this->method,
                'parameters' => $this->parameters,
                'exception'  => $ex,
            ]);
            $this->release(60);
        }
    }
}
