<?php

namespace App\Listeners;

use App\Events\Campaign\DecoratorAssigned;

class CampaignDecoratorAssignedTracking
{
    /**
     * Handle the event.
     *
     * @param  DecoratorAssigned $event
     * @return void
     */
    public function handle(DecoratorAssigned $event)
    {
        campaign_repository()->find($event->campaignId)->track('decorator_assigned');
    }
}
