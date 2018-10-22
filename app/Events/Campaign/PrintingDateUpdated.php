<?php

namespace App\Events\Campaign;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrintingDateUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $campaignId;

    /**
     * @var string
     */
    public $printingDate;

    /**
     * @var string
     */
    public $oldPrintingDate;

    /**
     * Create a new event instance.
     *
     * @param integer $campaignId
     * @param string  $printingDate
     * @param string  $oldPrintingDate
     */
    public function __construct($campaignId, $printingDate, $oldPrintingDate)
    {
        $this->campaignId = $campaignId;
        $this->printingDate = $printingDate;
        $this->oldPrintingDate = $oldPrintingDate;
    }
}
