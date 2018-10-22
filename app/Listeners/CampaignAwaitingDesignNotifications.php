<?php

namespace App\Listeners;

use App\Events\Campaign\AwaitingDesign;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignAwaitingDesignNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  AwaitingDesign $event
     * @return void
     */
    public function handle(AwaitingDesign $event)
    {
        $this->dispatch(new SendEmailJob('newCampaign', [$event->campaignId]));
    }
}
