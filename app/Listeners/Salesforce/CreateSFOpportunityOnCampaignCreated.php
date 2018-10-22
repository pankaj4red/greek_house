<?php

namespace App\Listeners\Salesforce;

use App\Events\Campaign\FullyCreated;
use App\Logging\Logger;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;
use App\Salesforce\SFOpportunity;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CreateSFOpportunityOnCampaignCreated
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  FullyCreated $event
     * @return void
     */
    public function handle(FullyCreated $event)
    {
        if (config('services.salesforce.enabled')) {
            try {
                $campaign = campaign_repository()->find($event->campaignId);
                $opportunity = SFOpportunity::createFromCampaign($campaign);

                $repository = SalesforceRepositoryFactory::get();
                $repository->opportunity()->putOpportunity($opportunity);
                Logger::logDebug('#CreateSFOpportunityOnCampaignCreated '.$event->campaignId.' information sent to #Salesforce');
            } catch (\Exception $exception) {
                Logger::logError('#CreateSFOpportunityOnCampaignCreated SF: '.$exception->getMessage(), ['exception' => $exception]);
            }
        } else {
            Logger::logDebug('#CreateSFOpportunityOnCampaignCreated '.$event->campaignId.' information sent [SKIPPED] to #Salesforce');
        }
    }
}