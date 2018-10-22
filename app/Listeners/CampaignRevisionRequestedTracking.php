<?php

namespace App\Listeners;

use App\Events\Campaign\RevisionRequested;

class CampaignRevisionRequestedTracking
{
    /**
     * Handle the event.
     *
     * @param  RevisionRequested $event
     * @return void
     */
    public function handle(RevisionRequested $event)
    {
        campaign_repository()->find($event->campaignId)->track('revision_requested');
    }
}
