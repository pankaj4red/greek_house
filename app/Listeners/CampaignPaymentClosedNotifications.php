<?php

namespace App\Listeners;

use App\Events\Campaign\PaymentClosed;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignPaymentClosedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  PaymentClosed $event
     * @return void
     */
    public function handle(PaymentClosed $event)
    {
        $this->dispatch(new SendEmailJob('campaignClosed', [$event->campaignId]));
        $this->dispatch(new SendEmailJob('campaignFulfillment', [$event->campaignId]));
    }
}
