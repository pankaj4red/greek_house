<?php

namespace App\Salesforce;

class SFOpportunityCollection extends SFModelCollection
{
    /**
     * Find Opportunity based on Campaign Id
     *
     * @param string $id
     * @return SFOpportunity|null
     */
    public function findByCampaignId($id)
    {
        return $this->findBy(['Campaign__c' => $id]);
    }
}