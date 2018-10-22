<?php
/**
 * Created by PhpStorm.
 * User: Asma Shaheen
 * Date: 6/20/2018
 * Time: 12:13 PM
 */

namespace App\Listeners;

use App\Events\Campaign\DeliverEarlier;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignDeliverEarlierNotifications
{
    use DispatchesJobs;

    public function handle(DeliverEarlier $event)
    {
        $this->dispatch(new SendEmailJob('deliverEarlier', [$event->campaignId]));
    }
}