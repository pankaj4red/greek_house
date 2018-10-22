<?php

namespace App\Listeners;

use App\Events\Campaign\Created;

class CampaignCreatedTracking
{
    /**
     * Handle the event.
     *
     * @param  Created $event
     * @return void
     */
    public function handle(Created $event)
    {
        campaign_repository()->find($event->campaignId)->track('created');
    }
}
