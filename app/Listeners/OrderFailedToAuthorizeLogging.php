<?php

namespace App\Listeners;

use App\Events\Order\FailedToAuthorize;

class OrderFailedToAuthorizeLogging
{
    /**
     * Handle the event.
     *
     * @param  FailedToAuthorize $event
     * @return void
     */
    public function handle(FailedToAuthorize $event)
    {
        order_repository()->find($event->orderId)->track('authorization_failed');
    }
}
