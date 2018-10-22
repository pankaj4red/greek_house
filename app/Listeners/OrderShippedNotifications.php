<?php

namespace App\Listeners;

use App\Events\Order\Shipped;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class OrderShippedNotifications
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
        $this->dispatch(new SendEmailJob('orderShipped', [$event->orderId]));
    }
}
