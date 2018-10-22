<?php

namespace App\Listeners;

use App\Events\Campaign\DesignerAssigned;

class CampaignDesignerAssignedTracking
{
    /**
     * Handle the event.
     *
     * @param  DesignerAssigned $event
     * @return void
     */
    public function handle(DesignerAssigned $event)
    {
        campaign_repository()->find($event->campaignId)->track('designer_assigned');
    }
}
