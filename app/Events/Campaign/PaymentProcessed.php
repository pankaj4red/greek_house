<?php

namespace App\Events\Campaign;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentProcessed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $campaignId;

    /**
     * @var string
     */
    public $reason;

    /**
     * Create a new event instance.
     *
     * @param integer $campaignId
     * @param string  $reason
     */
    public function __construct($campaignId, $reason)
    {
        $this->campaignId = $campaignId;
        $this->reason = $reason;
    }
}
