<?php

namespace App\Listeners;

use App\Events\Campaign\MessageCreated;

class CampaignMessageCreatedTracking
{
    /**
     * Handle the event.
     *
     * @param  MessageCreated $event
     * @return void
     */
    public function handle(MessageCreated $event)
    {
        campaign_repository()->find($event->campaignId)->track('message_created');
    }
}
