<?php

namespace App\Listeners;

use App\Events\Order\Refunded;

class OrderRefundedLogging
{
    /**
     * Handle the event.
     *
     * @param  Refunded $event
     * @return void
     */
    public function handle(Refunded $event)
    {
        order_repository()->find($event->orderId)->track('refunded');
    }
}
