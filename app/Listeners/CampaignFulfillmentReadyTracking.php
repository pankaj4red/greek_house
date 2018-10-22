<?php

namespace App\Listeners;

use App\Events\Campaign\FulfillmentReady;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignFulfillmentReadyTracking
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  FulfillmentReady $event
     * @return void
     */
    public function handle(FulfillmentReady $event)
    {
        campaign_repository()->find($event->campaignId)->track('fulfillment_ready');
    }
}
