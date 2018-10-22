<?php

namespace App\Listeners;

use App\Events\Campaign\QuoteProvided;

class CampaignQuoteProvidedTracking
{
    /**
     * Handle the event.
     *
     * @param  QuoteProvided $event
     * @return void
     */
    public function handle(QuoteProvided $event)
    {
        campaign_repository()->find($event->campaignId)->track('quote_provided');
    }
}
