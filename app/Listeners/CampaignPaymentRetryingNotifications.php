<?php

namespace App\Listeners;

use App\Events\Campaign\PaymentRetrying;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignPaymentRetryingNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  PaymentRetrying $event
     * @return void
     */
    public function handle(PaymentRetrying $event)
    {
        $this->dispatch(new SendEmailJob('campaignQuantityNotMet', [$event->campaignId]));
    }
}
