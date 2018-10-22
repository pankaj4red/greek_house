<?php

namespace App\Jobs;

use App\Logging\Logger;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessDatabaseLog extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $record;

    function __construct($record)
    {
        $this->record = $record;
    }

    public function handle()
    {
        if ($this->attempts() >= 10) {
            $this->delete();
        }

        try {
            log_repository()->log([
                'channel'  => $this->record['channel'],
                'level'    => $this->record['level'],
                'message'  => mb_substr($this->record['message'], 0, 4096),
                'user_id'  => $this->record['user_id'],
                'username' => $this->record['username'],
                'ip'       => $this->record['ip'],
                'context'  => $this->record['context'],
                'extra'    => $this->record['extra'],
                'trace'    => $this->record['level'] >= 250 ? $this->record['trace'] : null,
            ]);
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }
}
