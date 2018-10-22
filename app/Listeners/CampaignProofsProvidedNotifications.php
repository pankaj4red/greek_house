<?php

namespace App\Listeners;

use App\Events\Campaign\ProofsProvided;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignProofsProvidedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  ProofsProvided $event
     * @return void
     */
    public function handle(ProofsProvided $event)
    {
        $this->dispatch(new SendEmailJob('designUploaded', [$event->campaignId]));
    }
}
