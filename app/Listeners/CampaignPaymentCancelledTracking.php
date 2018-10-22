<?php

namespace App\Listeners;

use App\Events\Campaign\PaymentCancelled;

class CampaignPaymentCancelledTracking
{
    /**
     * Handle the event.
     *
     * @param  PaymentCancelled $event
     * @return void
     */
    public function handle(PaymentCancelled $event)
    {
        campaign_repository()->find($event->campaignId)->track('payment_cancelled');
    }
}
