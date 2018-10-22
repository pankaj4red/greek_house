<?php

namespace App\Listeners;

use App\Events\Order\Charged;

class OrderChargedLogging
{
    /**
     * Handle the event.
     *
     * @param  Charged $event
     * @return void
     */
    public function handle(Charged $event)
    {
        order_repository()->find($event->orderId)->track('charged');
    }
}
