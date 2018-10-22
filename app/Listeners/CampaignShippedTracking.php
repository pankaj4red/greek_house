<?php

namespace App\Listeners;

use App\Events\Campaign\Shipped;

class CampaignShippedTracking
{
    /**
     * Handle the event.
     *
     * @param  Shipped $event
     * @return void
     */
    public function handle(Shipped $event)
    {
        campaign_repository()->find($event->campaignId)->track('shipped');
    }
}
