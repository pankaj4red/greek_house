<?php

namespace App\Listeners;

use App\Events\User\UserCreated;
use Illuminate\Foundation\Bus\DispatchesJobs;

class UserCreatedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  UserCreated $event
     * @return void
     */
    public function handle(UserCreated $event)
    {

    }
}
