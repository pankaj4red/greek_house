<?php

namespace App\Listeners;

use App\Events\Campaign\QuoteProvided;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignQuoteProvidedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  QuoteProvided $event
     * @return void
     */
    public function handle(QuoteProvided $event)
    {
        $this->dispatch(new SendEmailJob('quotePosted', [$event->campaignId]));
    }
}
