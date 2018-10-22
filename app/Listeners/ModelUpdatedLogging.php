<?php

namespace App\Listeners;

use App\Events\Model\ModelUpdated;
use App\Logging\Logger;

class ModelUpdatedLogging
{
    /**
     * Handle the event.
     *
     * @param  ModelUpdated $event
     * @return void
     */
    public function handle(ModelUpdated $event)
    {
        if (in_array($event->model->getTable(), ['emails', 'email_attachments'])) {
            return;
        }
        try {
            $array = $event->model->toArray();
            foreach ($array as $key => $entry) {
                if (is_array($entry)) {
                    unset($array[$key]);
                }
            }
            Logger::track($event->model->getTable(), $event->model->id, 'updated', array_diff($array, $event->model->getOriginal()));
        } catch (\Exception $ex) {

        }
    }
}
