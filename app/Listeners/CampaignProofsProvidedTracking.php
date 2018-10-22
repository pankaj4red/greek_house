<?php

namespace App\Listeners;

use App\Events\Campaign\ProofsProvided;

class CampaignProofsProvidedTracking
{
    /**
     * Handle the event.
     *
     * @param  ProofsProvided $event
     * @return void
     */
    public function handle(ProofsProvided $event)
    {
        campaign_repository()->find($event->campaignId)->track('proofs_provided');
    }
}
