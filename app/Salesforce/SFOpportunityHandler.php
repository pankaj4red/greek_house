<?php

namespace App\Salesforce;

use App\Repositories\Salesforce\SalesforceRepository;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;

class SFOpportunityHandler
{
    use Verbose;

    /** @var SalesforceRepository */
    protected $repository;

    /**
     * @return SalesforceRepository
     */
    protected function getRepository()
    {
        if (! $this->repository) {
            $this->repository = SalesforceRepositoryFactory::get();
        }

        return $this->repository;
    }

    /**
     * @param SFOpportunityCollection $existingOpportunities
     */
    public function handle($existingOpportunities)
    {
        $campaigns = campaign_repository()->getSalesforceCampaigns();

        $number = 0;
        foreach ($campaigns as $campaign) {
            if ($number++ % 100 == 0) {
                $this->verbose('Checking Campaign '.$number.'/'.$campaigns->count().'['.human_bytes(memory_get_usage(true)).']');
            }

            $opportunityCollection = $existingOpportunities->filter(function ($value) use ($campaign) {
                return $value->Campaign__c == $campaign->id;
            });

            if ($opportunityCollection->count() == 0) {
                // Insert new Opportunity
                $this->verbose('Campaign insert in salesforce: '.$campaign->id);
                $convertedCampaign = SFOpportunity::createFromCampaign($campaign);
                self::getRepository()->opportunity()->putOpportunity($convertedCampaign);

                $campaign->update([
                    'sf_id' => $convertedCampaign->Id,
                ]);

                continue;
            }

            $convertedCampaign = SFOpportunity::createFromCampaign($campaign);
            if (! $convertedCampaign->isEqual($opportunityCollection->first(), SFModel::FIELDS_WRITEABLE)) {
                // Update outdated Opportunity
                $this->verbose('Campaign update in salesforce: '.$convertedCampaign->Campaign__c);
                $convertedCampaign = SFOpportunity::createFromCampaign($campaign);

                self::getRepository()->opportunity()->putOpportunity($convertedCampaign);
            }
        }
    }
}