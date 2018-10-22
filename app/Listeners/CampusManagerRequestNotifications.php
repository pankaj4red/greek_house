<?php

namespace App\Listeners;

use App\Events\Misc\CampusManagerRequest;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampusManagerRequestNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  CampusManagerRequest $event
     * @return void
     */
    public function handle(CampusManagerRequest $event)
    {
        $this->dispatch(new SendEmailJob('campusManagerApp', [$event->data]));
    }
}
