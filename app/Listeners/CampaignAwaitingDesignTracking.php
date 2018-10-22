<?php

namespace App\Listeners;

use App\Events\Campaign\AwaitingDesign;

class CampaignAwaitingDesignTracking
{
    /**
     * Handle the event.
     *
     * @param  AwaitingDesign $event
     * @return void
     */
    public function handle(AwaitingDesign $event)
    {
        campaign_repository()->find($event->campaignId)->track('awaiting_design');
    }
}
