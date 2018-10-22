<?php

namespace App\Events\Campaign;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DecoratorAssigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $campaignId;

    /**
     * @var int
     */
    public $decoratorId;

    /**
     * Create a new event instance.
     *
     * @param integer $campaignId
     * @param integer $decoratorId
     */
    public function __construct($campaignId, $decoratorId)
    {
        $this->campaignId = $campaignId;
        $this->decoratorId = $decoratorId;
    }
}
