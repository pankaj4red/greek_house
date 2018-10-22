<?php

namespace App\Events\Campaign;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DesignerAssigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $campaignId;

    /**
     * @var
     */
    public $designerId;

    /**
     * Create a new event instance.
     *
     * @param integer $campaignId
     * @param         $designerId
     */
    public function __construct($campaignId, $designerId)
    {
        $this->campaignId = $campaignId;
        $this->designerId = $designerId;
    }
}
