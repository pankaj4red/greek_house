<?php

namespace App\Listeners;

use App\Events\Campaign\DesignApproved;

class CampaignDesignApprovedTracking
{
    /**
     * Handle the event.
     *
     * @param  DesignApproved $event
     * @return void
     */
    public function handle(DesignApproved $event)
    {
        campaign_repository()->find($event->campaignId)->track('design_approved');
    }
}
