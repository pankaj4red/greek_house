<?php

namespace App\Listeners;

use App\Events\Campaign\PaymentProcessed;

class CampaignPaymentProcessedTracking
{
    /**
     * Handle the event.
     *
     * @param  PaymentProcessed $event
     * @return void
     */
    public function handle(PaymentProcessed $event)
    {
        campaign_repository()->find($event->campaignId)->track('payment_processed ['.$event->reason.']');
    }
}
