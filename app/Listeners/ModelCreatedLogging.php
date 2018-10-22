<?php

namespace App\Listeners;

use App\Events\Model\ModelCreated;
use App\Logging\Logger;

class ModelCreatedLogging
{
    /**
     * Handle the event.
     *
     * @param  ModelCreated $event
     * @return void
     */
    public function handle(ModelCreated $event)
    {
        if (in_array($event->model->getTable(), ['emails', 'email_attachments'])) {
            return;
        }
        Logger::track($event->model->getTable(), $event->model->id, 'created', $event->model->toArray());
    }
}
