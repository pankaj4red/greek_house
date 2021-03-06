<?php

namespace App\Events\Campaign;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrintFilesProvided
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $campaignId;

    /**
     * Create a new event instance.
     *
     * @param integer $campaignId
     */
    public function __construct($campaignId)
    {
        $this->campaignId = $campaignId;
    }
}
