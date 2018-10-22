<?php

namespace App\Listeners;

use App\Events\Order\ChargedManual;

class OrderChargedManualLogging
{
    /**
     * Handle the event.
     *
     * @param  ChargedManual $event
     * @return void
     */
    public function handle(ChargedManual $event)
    {
        order_repository()->find($event->orderId)->track('charged_manual');
    }
}
