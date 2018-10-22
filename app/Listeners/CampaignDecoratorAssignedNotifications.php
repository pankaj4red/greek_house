<?php

namespace App\Listeners;

use App\Events\Campaign\DecoratorAssigned;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignDecoratorAssignedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  DecoratorAssigned $event
     * @return void
     */
    public function handle(DecoratorAssigned $event)
    {
        $this->dispatch(new SendEmailJob('fulfillmentSubmitted', [$event->campaignId]));
    }
}
