<?php

namespace App\Listeners;

use App\Events\Campaign\SuppliesFixed;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignSuppliesFixedTracking
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
        campaign_repository()->find($event->campaignId)->track('supplies_fixed');
    }
}
