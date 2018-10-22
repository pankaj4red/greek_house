<?php

namespace App\Events\User;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Registered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var int
     */
    public $campaignId;

    /**
     * Create a new event instance.
     *
     * @param integer $userId
     * @param integer $campaignId
     */
    public function __construct($userId, $campaignId)
    {
        $this->userId = $userId;
        $this->campaignId = $campaignId;
    }
}
