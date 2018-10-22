<?php

namespace App\Events\Campaign;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OnHold
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $campaignId;

    /**
     * @var string
     */
    public $ruleName;

    /**
     * Create a new event instance.
     *
     * @param integer $campaignId
     * @param string  $ruleName
     */
    public function __construct($campaignId, $ruleName)
    {
        $this->campaignId = $campaignId;
        $this->ruleName = $ruleName;
    }
}
