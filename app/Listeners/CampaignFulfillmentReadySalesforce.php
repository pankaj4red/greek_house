<?php

namespace App\Listeners;

use App\Events\Campaign\FulfillmentReady;
use App\Logging\Logger;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;
use App\Salesforce\SFOpportunity;
use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignFulfillmentReadySalesforce
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  FulfillmentReady $event
     * @return void
     */
    public function handle(FulfillmentReady $event)
    {
        $campaign = campaign_repository()->find($event->campaignId);
        $sfOpportunity = SFOpportunity::createFromCampaign($campaign);

        if (! config('services.salesforce.enabled')) {
            Logger::logDebug('Salesforce Integration Fulfillment Ready Skipped');

            return;
        }
        try {
            $salesforce = SalesforceRepositoryFactory::get();
            $salesforce->opportunity()->putOpportunity($sfOpportunity);
        } catch (Exception $ex) {
            Logger::logError('Fulfillment Ready SF: '.$ex->getMessage(), ['exception' => $ex]);
        }
    }
}
