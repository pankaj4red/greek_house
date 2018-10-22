<?php

namespace App\Listeners;

use App\Events\Order\Authorized;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class OrderAuthorizedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  Authorized $event
     * @return void
     */
    public function handle(Authorized $event)
    {
        $this->dispatch(new SendEmailJob('orderReceipt', [$event->orderId]));
    }
}
