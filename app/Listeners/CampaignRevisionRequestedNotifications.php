<?php

namespace App\Listeners;

use App\Events\Campaign\RevisionRequested;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignRevisionRequestedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  RevisionRequested $event
     * @return void
     */
    public function handle(RevisionRequested $event)
    {
        $this->dispatch(new SendEmailJob('revisionRequested', [$event->campaignId]));
    }
}
