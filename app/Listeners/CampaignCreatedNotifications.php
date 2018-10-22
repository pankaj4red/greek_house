<?php

namespace App\Listeners;

use App\Events\Campaign\FullyCreated;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignCreatedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  FullyCreated $event
     * @return void
     */
    public function handle(FullyCreated $event)
    {
        $this->dispatch(new SendEmailJob('newCampaign', [$event->campaignId]));
    }
}
