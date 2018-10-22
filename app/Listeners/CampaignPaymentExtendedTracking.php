<?php

namespace App\Listeners;

use App\Events\Campaign\PaymentExtended;

class CampaignPaymentExtendedTracking
{
    /**
     * Handle the event.
     *
     * @param  PaymentExtended $event
     * @return void
     */
    public function handle(PaymentExtended $event)
    {
        campaign_repository()->find($event->campaignId)->track('payment_extended');
    }
}
