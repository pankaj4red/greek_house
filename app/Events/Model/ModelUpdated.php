<?php

namespace App\Events\Model;

use App\Models\Model;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModelUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Model
     */
    public $model;

    /**
     * Create a new event instance.
     *
     * @param Model $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }
}
