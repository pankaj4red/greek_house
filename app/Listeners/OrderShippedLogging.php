<?php

namespace App\Listeners;

use App\Events\Order\Shipped;
use Illuminate\Foundation\Bus\DispatchesJobs;

class OrderShippedLogging
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  Shipped $event
     * @return void
     */
    public function handle(Shipped $event)
    {
        order_repository()->find($event->orderId)->track('shipped');
    }
}
