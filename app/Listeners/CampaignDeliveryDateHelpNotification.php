<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 8/1/2018
 * Time: 4:23 PM
 */

namespace App\Listeners;

use App\Events\Campaign\DeliveryDateHelp;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignDeliveryDateHelpNotification
{
    use DispatchesJobs;

    public function handle(DeliveryDateHelp $event)
    {
        $this->dispatch(new SendEmailJob('deliveryDateHelp', [$event->campaignId]));
    }
}