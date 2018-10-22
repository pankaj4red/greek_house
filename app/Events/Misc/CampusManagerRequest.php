<?php

namespace App\Events\Misc;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CampusManagerRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array|mixed[]
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
