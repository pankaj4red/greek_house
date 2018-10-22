<?php

namespace App\Listeners;

use App\Events\Order\Charged;

class OrderChargedNotifications
{
    /**
     * Handle the event.
     *
     * @param  Charged $event
     * @return void
     */
    public function handle(Charged $event)
    {

    }
}
