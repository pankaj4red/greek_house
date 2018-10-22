<?php
/**
 * Created by PhpStorm.
 * User: Asma Shaheen
 * Date: 6/20/2018
 * Time: 12:11 PM
 */

namespace App\Events\Campaign;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliverEarlier
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