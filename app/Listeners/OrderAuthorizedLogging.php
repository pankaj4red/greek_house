<?php

namespace App\Listeners;

use App\Events\Order\Authorized;

class OrderAuthorizedLogging
{
    /**
     * Handle the event.
     *
     * @param  Authorized $event
     * @return void
     */
    public function handle(Authorized $event)
    {
        order_repository()->find($event->orderId)->track('authorized');
    }
}
