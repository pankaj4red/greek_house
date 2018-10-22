<?php

namespace App\Listeners;

use App\Events\User\Registered;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class UserRegisteredNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $this->dispatch(new SendEmailJob('newCustomer', [$event->userId]));
    }
}
