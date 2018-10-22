<?php

namespace App\Listeners;

use App\Events\Campaign\Delivered;

class CampaignDeliveredTracking
{
    /**
     * Handle the event.
     *
     * @param  Delivered $event
     * @return void
     */
    public function handle(Delivered $event)
    {
        campaign_repository()->find($event->campaignId)->track('delivered');
    }
}
