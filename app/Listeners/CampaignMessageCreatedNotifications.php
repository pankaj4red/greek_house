<?php

namespace App\Listeners;

use App\Events\Campaign\MessageCreated;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignMessageCreatedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  MessageCreated $event
     * @return void
     */
    public function handle(MessageCreated $event)
    {
        $comment = comment_repository()->find($event->commentId);

        switch ($comment->channel) {
            case 'customer':
                $this->dispatch(new SendEmailJob('messagePosted', [
                    $event->campaignId,
                    \Auth::user()->id,
                    str_replace("\r", "", $comment->body),
                    $comment->file_id,
                ]));
                break;
            case 'fulfillment':
                $this->dispatch(new SendEmailJob('fulfillmentMessage', [
                    $event->campaignId,
                    \Auth::user()->id,
                    str_replace("\r", "", $comment->body),
                ]));
                break;
        }
    }
}
