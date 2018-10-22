<?php

namespace App\Events\Campaign;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StateManuallyChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $campaignId;

    /**
     * @var string
     */
    public $state;

    /**
     * Create a new event instance.
     *
     * @param integer $campaignId
     * @param string  $state
     */
    public function __construct($campaignId, $state)
    {
        $this->campaignId = $campaignId;
        $this->state = $state;
    }
}
