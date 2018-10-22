<?php

namespace App\Repositories\Salesforce\ObjectRepository;

use App\Console\ConsoleOutput;
use App\Repositories\Salesforce\SalesforceRepository;
use App\Salesforce\SFModel;
use App\Salesforce\SFOpportunity;
use App\Salesforce\SFOpportunityCollection;
use Carbon\Carbon;

class OpportunityRepository
{
    /**
     * The Repository for Salesforce
     *
     * @var SalesforceRepository
     */
    protected $repository;

    /**
     * OpportunityRepository constructor.
     *
     * @param SalesforceRepository $repository
     */
    public function __construct(SalesforceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Gets a list of Opportunities
     *
     * @return SFOpportunityCollection
     * @throws \Exception
     */
    public function getOpportunities()
    {
        ConsoleOutput::subtitle('Fetching Opportunity Information');

        $list = $this->repository->list(SFOpportunity::objectName(), SFOpportunity::getFields());

        $accounts = [];
        foreach ($list as $row) {
            $accounts[] = new SFOpportunity($row);
        }

        return new SFOpportunityCollection($accounts);
    }

    /**
     * Gets a list of Opportunities
     *
     * @param string $date
     * @return SFOpportunityCollection
     * @throws \Exception
     */
    public function getOpportunitiesFromDate($date)
    {
        ConsoleOutput::subtitle('Fetching Opportunity Information');

        $list = $this->repository->find(SFOpportunity::objectName(), SFOpportunity::getFields(), ['CreatedDate' => ['>', Carbon::parse($date)->subDay(1)->format('c')]]);

        $accounts = [];
        foreach ($list as $row) {
            $accounts[] = new SFOpportunity($row);
        }

        return new SFOpportunityCollection($accounts);
    }

    /**
     * Gets an opportunity based on it's Campaign Id
     *
     * @param integer $campaignId
     * @return string[]|null
     */
    public function getOpportunity($campaignId)
    {
        $results = $this->repository->find(SFOpportunity::objectName(), SFOpportunity::getFields(), ['Campaign__c' => $campaignId]);

        return collect($results)->first();
    }

    /**
     * Upserts a opportunity list on Salesforce
     *
     * @param SFOpportunityCollection $opportunities
     * @return SFOpportunityCollection
     * @throws \Exception
     */
    public function putOpportunities($opportunities)
    {
        ConsoleOutput::subtitle('Pushing campaign Information');

        /** @var SFOpportunity $opportunity */
        foreach ($opportunities as $opportunity) {
            $this->putOpportunity($opportunity);
        }

        return $opportunities;
    }

    /**
     * Upserts a single opportunity on Salesforce
     *
     * @param SFOpportunity $opportunity
     * @return SFOpportunity
     * @throws \Exception
     */
    public function putOpportunity($opportunity)
    {
        if (! $opportunity->Id) {
            $salesforceOpportunity = $this->getOpportunity($opportunity->Campaign__c);

            if ($salesforceOpportunity && is_array($salesforceOpportunity) && array_key_exists('Id', $salesforceOpportunity)) {
                $opportunity->Id = $salesforceOpportunity['Id'];
            }
        }

        if ($opportunity->Id) {
            $this->repository->update(SFOpportunity::objectName(), $opportunity->Id, $opportunity->getData(SFModel::FIELDS_UPDATE));
        } else {
            $opportunity->Id = $this->repository->create(SFOpportunity::objectName(), $opportunity->getData(SFModel::FIELDS_INSERT));
        }

        return $opportunity;
    }
}