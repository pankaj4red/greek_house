<?php

namespace App\Listeners;

use App\Events\Campaign\DesignApproved;
use App\Logging\Logger;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;
use App\Salesforce\SFOpportunity;

class CampaignDesignApprovedSalesforce
{
    /**
     * Handle the event.
     *
     * @param  DesignApproved $event
     * @return void
     */
    public function handle(DesignApproved $event)
    {
        if (config('services.salesforce.enabled')) {
            $body = null;
            try {
                $campaign = campaign_repository()->find($event->campaignId);
                $opportunity = SFOpportunity::createFromCampaign($campaign);

                $repository = SalesforceRepositoryFactory::get();
                $repository->opportunity()->putOpportunity($opportunity);
                Logger::logDebug('#CampaignDesignApprovedSalesforce '.$event->campaignId.' information sent to #Salesforce');
            } catch (\BadMethodCallException $ex) {
                throw $ex;
            } catch (\Exception $ex) {
                Logger::logError('#CampaignDesignApprovedSalesforce SF: '.$ex->getMessage(), ['exception' => $ex]);
            }
        } else {
            Logger::logDebug('#CampaignDesignApprovedSalesforce '.$event->campaignId.' information sent [SKIPPED] to #Salesforce');
        }
    }
}
