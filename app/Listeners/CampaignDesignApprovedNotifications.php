<?php

namespace App\Listeners;

use App\Events\Campaign\DesignApproved;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignDesignApprovedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  DesignApproved $event
     * @return void
     */
    public function handle(DesignApproved $event)
    {
        $this->dispatch(new SendEmailJob('designApproved', [$event->campaignId]));
    }
}
