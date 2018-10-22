<?php

namespace App\Listeners;

use App\Events\Campaign\PaymentClosed;

class CampaignPaymentClosedTracking
{
    /**
     * Handle the event.
     *
     * @param  PaymentClosed $event
     * @return void
     */
    public function handle(PaymentClosed $event)
    {
        campaign_repository()->find($event->campaignId)->track('payment_closed');
    }
}
