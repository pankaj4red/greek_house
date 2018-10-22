<?php

namespace App\Jobs;

use App\Logging\Logger;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessEmailLog extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $emailInformation;

    function __construct($emailInformation)
    {
        $this->emailInformation = $emailInformation;
    }

    public function handle()
    {
        if ($this->attempts() >= 10) {
            $this->delete();
        }

        try {
            /*$model = */
            email_repository()->create([
                'to'      => $this->emailInformation['to'],
                'from'    => $this->emailInformation['from'],
                'cc'      => $this->emailInformation['cc'],
                'subject' => mb_substr($this->emailInformation['subject'], 0, 255),
                'body'    => $this->emailInformation['body'],
            ]);

            //TODO: log attachments
            /*
            foreach ($this->emailInformation['attachments'] as $attachmentInformation) {
                email_attachment_repository()->create(
                    [
                        'email_id' => $model->id,
                        'name'     => $attachmentInformation['name'],
                        'content'  => $attachmentInformation['content'],
                    ]
                );
            }
            */
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }
}
