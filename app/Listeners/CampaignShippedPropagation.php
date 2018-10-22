<?php

namespace App\Listeners;

use App\Events\Campaign\Shipped as CampaignShipped;
use App\Events\Order\Shipped as OrderShipped;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignShippedPropagation
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  CampaignShipped $event
     * @return void
     */
    public function handle(CampaignShipped $event)
    {
        foreach (campaign_repository()->find($event->campaignId)->success_orders as $order) {
            event(new OrderShipped($order->id));
        }
    }
}
