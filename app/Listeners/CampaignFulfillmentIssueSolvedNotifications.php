<?php

namespace App\Listeners;

use App\Events\Campaign\FulfillmentIssueSolved;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignFulfillmentIssueSolvedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  FulfillmentIssueSolved $event
     * @return void
     */
    public function handle(FulfillmentIssueSolved $event)
    {
        $this->dispatch(new SendEmailJob('fulfillmentIssueSolved', [$event->campaignId]));
    }
}
