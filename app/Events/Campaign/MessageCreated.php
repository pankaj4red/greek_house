<?php

namespace App\Events\Campaign;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $campaignId;

    /**
     * @var int
     */
    public $commentId;

    /**
     * Create a new event instance.
     *
     * @param integer $campaignId
     * @param integer $commentId
     */
    public function __construct($campaignId, $commentId)
    {
        $this->campaignId = $campaignId;
        $this->commentId = $commentId;
    }
}
