<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 8/1/2018
 * Time: 4:20 PM
 */

namespace App\Events\Campaign;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryDateHelp
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