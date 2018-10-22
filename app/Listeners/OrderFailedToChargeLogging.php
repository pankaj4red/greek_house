<?php

namespace App\Listeners;

use App\Events\Order\FailedToCharge;

class OrderFailedToChargeLogging
{
    /**
     * Handle the event.
     *
     * @param  FailedToCharge $event
     * @return void
     */
    public function handle(FailedToCharge $event)
    {
        order_repository()->find($event->orderId)->track('charging_failed');
    }
}
