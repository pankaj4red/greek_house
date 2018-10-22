<?php

namespace App\Events\Order;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Authorized
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $orderId;

    /**
     * Create a new event instance.
     *
     * @param integer $orderId
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }
}
