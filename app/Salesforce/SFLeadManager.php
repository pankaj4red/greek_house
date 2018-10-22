<?php

namespace App\Salesforce;

use Carbon\Carbon;

class SFLeadManager
{
    use Verbose;

    /**
     * Leads yet to be analyzed
     *
     * @var SFLeadCollection
     */
    protected $unanalyzed;

    /**
     * Leads that need to be saved on salesforce
     * These are not processed at all.
     *
     * @var SFLeadCollection
     */
    protected $toSave;

    /**
     * Collection of Leads not needing action.
     *
     * @var SFLeadCollection
     */
    protected $noAction;

    /**
     * SFLeadManager constructor.
     *
     * @param SFLeadCollection $leads
     */
    public function __construct($leads)
    {
        $this->unanalyzed = clone $leads;
        $this->toSave = new SFLeadCollection();
        $this->noAction = new SFLeadCollection();
    }

    /**
     * Processes opportunities into to be saved on salesforce or "no action"
     */
    public function process()
    {
        $this->processToSave();

        $this->noAction = $this->unanalyzed;
        $this->unanalyzed = new SFOpportunityCollection();
    }

    /**
     * Processes opportunities to save on Salesforce
     */
    private function processToSave()
    {
        $this->verboseStart('Processing Leads to save in Salesforce...');

        /** @var SFLead $lead */
        foreach ($this->unanalyzed as $key => $lead) {

            $user = user_repository()->findByEmail($lead->Email);

            if (! $user) {
                continue;
            }

            if (! $user->created_at->greaterThanOrEqualTo(Carbon::parse('2017-01-01'))) {
                continue;
            }

            $original = clone $lead;
            $placed = false;
            $closed = false;
            $cancelled = false;

            foreach ($user->campaigns as $campaign) {
                $placed = true;
                if ($campaign->state == 'cancelled') {
                    $cancelled = true;
                }
                if (in_array($campaign->state, ['processing_payment', 'fulfillment_ready', 'fulfillment_validation', 'printing', 'shipped', 'delivered'])) {
                    $closed = true;
                }
            }

            if (! starts_with($lead->Status, 'Archived')) {
                $status = 'Qualified';
                if ($placed) {
                    $status = 'Campaign Placed';
                }
                if ($cancelled) {
                    $status = 'Campaign Cancelled';
                }
                if ($closed) {
                    $status = 'Campaign Closed';
                }
                $lead->Status = $status;
            }

            $lead->Contact__c = $user->sf_id;
            if ($lead->Status != $original->Status || $lead->Contact__c != $original->Contact__c) {
                $this->toSave->push($lead);
                $this->unanalyzed->forget($key);
            }
        }

        $this->verboseEnd($this->toSave->count());
    }

    /**
     * List of all valid Opportunities
     *
     * @return SFLeadCollection
     */
    public function getAll()
    {
        return new SFLeadCollection(array_merge($this->unanalyzed->toArray(), $this->toSave->toArray(), $this->noAction->toArray()));
    }

    /**
     * List of Opportunities to be saved on Salesforce
     *
     * @return SFLeadCollection
     */
    public function getToSave()
    {
        return $this->toSave;
    }

    /**
     * List of Opportunities not needing any action
     *
     * @return SFLeadCollection
     */
    public function getNoAction()
    {
        return $this->noAction;
    }
}