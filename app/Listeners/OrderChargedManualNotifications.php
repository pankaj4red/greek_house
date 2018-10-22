<?php

namespace App\Listeners;

use App\Events\Order\ChargedManual;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class OrderChargedManualNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  ChargedManual $event
     * @return void
     */
    public function handle(ChargedManual $event)
    {
        $this->dispatch(new SendEmailJob('orderReceipt', [$event->orderId]));
    }
}
