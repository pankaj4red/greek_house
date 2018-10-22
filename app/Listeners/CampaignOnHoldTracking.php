<?php

namespace App\Listeners;

use App\Events\Campaign\OnHold;

class CampaignOnHoldTracking
{
    /**
     * Handle the event.
     *
     * @param  OnHold $event
     * @return void
     */
    public function handle(OnHold $event)
    {
        campaign_repository()->find($event->campaignId)->track('on_hold: '.$event->ruleName, ['rule' => $event->ruleName]);
    }
}
