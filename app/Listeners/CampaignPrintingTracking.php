<?php

namespace App\Listeners;

use App\Events\Campaign\Printing;

class CampaignPrintingTracking
{
    /**
     * Handle the event.
     *
     * @param  Printing $event
     * @return void
     */
    public function handle(Printing $event)
    {
        campaign_repository()->find($event->campaignId)->track('printing');
    }
}
