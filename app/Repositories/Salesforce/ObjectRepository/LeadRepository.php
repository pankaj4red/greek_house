<?php

namespace App\Repositories\Salesforce\ObjectRepository;

use App\Console\ConsoleOutput;
use App\Repositories\Salesforce\SalesforceRepository;
use App\Salesforce\SFLead;
use App\Salesforce\SFLeadCollection;
use App\Salesforce\SFModel;

class LeadRepository
{
    /**
     * The Repository for Salesforce
     *
     * @var SalesforceRepository
     */
    protected $repository;

    /**
     * LeadRepository constructor.
     *
     * @param SalesforceRepository $repository
     */
    public function __construct(SalesforceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Creates a single lead
     *
     * @param SFLead $lead
     * @return SFLead
     */
    public function createLead($lead)
    {
        $lead->Id = $this->repository->create(SFLead::objectName(), $lead->getData(SFLead::FIELDS_INSERT));

        return $lead;
    }

    /**
     * Gets a list of Leads
     *
     * @return SFLeadCollection
     */
    public function getLeads()
    {
        ConsoleOutput::subtitle('Fetching leads Information');

        $list = $this->repository->list(SFLead::objectName(), SFLead::getFields());

        $leads = [];
        foreach ($list as $row) {
            $leads[] = new SFLead($row);
        }

        return new SFLeadCollection($leads);
    }

    /**
     * Gets an lead based on it's email
     *
     * @param string $email
     * @return SFLead|null
     */
    public function getLead($email)
    {
        $results = $this->repository->find(SFLead::objectName(), SFLead::getFields(), ['Email' => $email]);

        return collect($results)->first() ? new SFLead(collect($results)->first()) : null;
    }

    /**
     * Upserts a lead list on salesforce
     *
     * @param SFLeadCollection $leads
     * @return SFLeadCollection
     */
    public function putLeads($leads)
    {
        ConsoleOutput::subtitle('Pushing Lead Information');

        /** @var SFLead $lead */
        foreach ($leads as $lead) {
            $this->putLead($lead);
        }

        return $leads;
    }

    /**
     * Upserts a lead on salesforce
     *
     * @param SFLead $lead
     * @return SFLead
     */
    public function putLead($lead)
    {
        if (! $lead->Id) {
            return null;
        }

        $this->repository->update(SFLead::objectName(), $lead->Id, $lead->getData(SFModel::FIELDS_UPDATE));

        return $lead;
    }

    /**
     * Updates a lead on salesforce with array data
     *
     * @param string   $id
     * @param string[] $data
     * @return void
     */
    public function updateLead($id, $data)
    {
        if (! $id) {
            return null;
        }

        $this->repository->update(SFLead::objectName(), $id, $data);
    }

    /**
     * Updates the leads status
     *
     * @param SFLeadCollection $leads
     * @return SFLeadCollection
     */
    public function setLeadsStatus($leads)
    {
        ConsoleOutput::subtitle('Updating Lead Statuses');

        foreach ($leads as $lead) {
            $this->setLeadStatus($lead);
        }

        return $leads;
    }

    /**
     * Updates a single lead status
     *
     * @param SFLead $lead
     * @return SFLead
     */
    public function setLeadStatus($lead)
    {
        $this->repository->update(SFLead::objectName(), $lead->Id, ['Status' => $lead->Status, 'Contact__c' => $lead->Contact__c]);

        return $lead;
    }
}