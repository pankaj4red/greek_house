<?php

namespace App\Listeners;

use App\Events\Campaign\PaymentRetrying;

class CampaignPaymentRetryingTracking
{
    /**
     * Handle the event.
     *
     * @param  PaymentRetrying $event
     * @return void
     */
    public function handle(PaymentRetrying $event)
    {
        campaign_repository()->find($event->campaignId)->track('payment_retrying');
    }
}
