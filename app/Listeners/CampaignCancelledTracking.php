<?php

namespace App\Listeners;

use App\Events\Campaign\Cancelled;

class CampaignCancelledTracking
{
    /**
     * Handle the event.
     *
     * @param  Cancelled $event
     * @return void
     */
    public function handle(Cancelled $event)
    {
        campaign_repository()->find($event->campaignId)->track('cancelled');
    }
}
