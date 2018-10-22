<?php

namespace App\Listeners;

use App\Events\Campaign\PaymentExtended;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignPaymentExtendedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  PaymentExtended $event
     * @return void
     */
    public function handle(PaymentExtended $event)
    {
        //
    }
}
