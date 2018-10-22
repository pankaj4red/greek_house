<?php

namespace App\Listeners;

use App\Events\Campaign\PaymentCancelled;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignPaymentCancelledNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  PaymentCancelled $event
     * @return void
     */
    public function handle(PaymentCancelled $event)
    {
        //
    }
}
