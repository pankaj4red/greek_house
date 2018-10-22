<?php

namespace App\Listeners;

use App\Events\Campaign\PaymentProcessed;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignPaymentProcessedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  PaymentProcessed $event
     * @return void
     */
    public function handle(PaymentProcessed $event)
    {
        //
    }
}
