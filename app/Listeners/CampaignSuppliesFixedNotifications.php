<?php

namespace App\Listeners;

use App\Events\Campaign\SuppliesFixed;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignSuppliesFixedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  SuppliesFixed $event
     * @return void
     */
    public function handle(SuppliesFixed $event)
    {
        $this->dispatch(new SendEmailJob('newGarmentUpdate', [$event->campaignId]));
    }
}
