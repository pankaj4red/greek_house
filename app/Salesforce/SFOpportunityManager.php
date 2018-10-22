<?php

namespace App\Salesforce;

use App\Helpers\ModelCache;
use App\Models\Campaign;

class SFOpportunityManager
{
    use Verbose;

    /**
     * Opportunities yet to be analyzed
     *
     * @var SFOpportunityCollection
     */
    protected $unanalyzed;

    /**
     * Opportunities with invalid critical data (such as no campaign id)
     * These are not processed at all.
     *
     * @var SFOpportunityCollection
     */
    protected $invalid;

    /**
     * Opportunities that no longer need processing (ie, Opportunities already in shipped stage)
     * These are not processed at all.
     *
     * @var SFOpportunityCollection
     */
    protected $noProcess;

    /**
     * Opportunities that need to be saved on salesforce
     *
     * @var SFOpportunityCollection
     */
    protected $toSave;

    /**
     * Collection of Opportunities not needing action.
     *
     * @var SFOpportunityCollection
     */
    protected $noAction;

    /**
     * A cache for campaigns. Improves performance by avoiding constant database access.
     *
     * @var ModelCache
     */
    protected $campaignCache;

    /**
     * SFOpportunityManager constructor.
     *
     * @param SFOpportunityCollection $opportunities
     */
    public function __construct($opportunities)
    {
        $this->unanalyzed = clone $opportunities;
        $this->invalid = new SFOpportunityCollection();
        $this->noProcess = new SFOpportunityCollection();
        $this->toSave = new SFOpportunityCollection();
        $this->noAction = new SFOpportunityCollection();

        $this->campaignCache = new ModelCache(campaign_repository());
    }

    /**
     * Processes opportunities into invalid, to be saved on salesforce and "no action"
     */
    public function process()
    {
        $this->processInvalid();
        $this->processToSave();

        $this->noAction = $this->unanalyzed;
        $this->unanalyzed = new SFOpportunityCollection();
    }

    /**
     * Processes invalid opportunities
     */
    public function processInvalid()
    {
        $this->verboseStart('Processing Invalid Opportunities...');

        /** @var SFOpportunity $opportunity */
        foreach ($this->unanalyzed as $key => $opportunity) {
            if ($opportunity->Id === null) {
                $this->invalid->push($opportunity);
                $this->unanalyzed->forget($key);
                continue;
            }

            if ($opportunity->Campaign__c === null) {
                $this->invalid->push($opportunity);
                $this->unanalyzed->forget($key);
                continue;
            }
        }

        $this->verboseEnd($this->invalid->count());
    }

    /**
     * Processes opportunities to save on Salesforce
     */
    private function processToSave()
    {
        $this->verboseStart('Processing Campaigns to save in Salesforce...');

        $campaigns = campaign_repository()->getCreatedAfter(config('services.salesforce.cutout_date'));
        $all = $this->getAll();
        $count = 0;
        foreach ($campaigns as $campaign) {
            if ($count % 100 == 0) {
                $this->verbose('Processing Campaigns: '.$count.'/'.count($campaigns));
            }
            $this->campaignCache->put($campaign->id, $campaign);

            if ($all->findByCampaignId($campaign->id) === null) {
                $this->verbose('Campaign insert in salesforce: '.$campaign->id);
                $this->toSave->push(SFOpportunity::createFromCampaign($campaign));
            }
            $count++;
        }

        $count = 0;
        $total = count($this->unanalyzed);
        /** @var SFOpportunity $opportunity */
        foreach ($this->unanalyzed as $key => $opportunity) {
            if ($count % 100 == 0) {
                $this->verbose('Processing Unanalyzed: '.$count.'/'.$total);
            }
            $count++;
            /** @var Campaign $campaign */
            $campaign = $this->campaignCache->getOrFetch((int) $opportunity->Campaign__c);
            if (! $campaign) {
                continue;
            }
            if ($campaign->created_at < config('services.salesforce.cutout_date')) {
                continue;
            }

            try {
                $opportunityFromCampaign = SFOpportunity::createFromCampaign($campaign);
                if (! $opportunityFromCampaign->isEqual($opportunity, SFOpportunity::FIELDS_WRITEABLE)) {
                    $differences = $opportunityFromCampaign->getDifferentFields($opportunity, SFOpportunity::FIELDS_WRITEABLE);
                    $this->verbose('Campaign save in salesforce: '.$opportunity->Campaign__c);
                    $opportunity->setData($opportunityFromCampaign->getData(SFOpportunity::FIELDS_WRITEABLE));

                    $this->toSave->push($opportunity);
                    $this->unanalyzed->forget($key);
                }
            } catch (\Exception $ex) {
                $this->verbose('Campaign failed with exception: '.$campaign->id.': '.$ex->getMessage().' ('.$ex->getFile().':'.$ex->getLine().')');
            }
        }

        $this->verboseEnd($this->toSave->count());
    }

    /**
     * List of all valid Opportunities
     *
     * @return SFOpportunityCollection
     */
    public function getAll()
    {
        return new SFOpportunityCollection(array_merge($this->unanalyzed->toArray(), $this->toSave->toArray(), $this->noAction->toArray()));
    }

    /**
     * List of Invalid Opportunities
     * These will not be processed
     *
     * @return SFOpportunityCollection
     */
    public function getInvalid()
    {
        return $this->invalid;
    }

    /**
     * List of Opportunities to be saved on Salesforce
     *
     * @return SFOpportunityCollection
     */
    public function getToSave()
    {
        return $this->toSave;
    }

    /**
     * List of Opportunities not needing any action
     *
     * @return SFOpportunityCollection
     */
    public function getNoAction()
    {
        return $this->noAction;
    }

    /**
     * Associates all Salesforce objects with campaigns
     */
    public function associateInDatabase()
    {
        $this->verboseStart('Associating Opportunities in database...');

        /** @var SFOpportunity $opportunity */
        foreach ($this->getAll() as $opportunity) {
            $opportunity->associateInDatabase($this->campaignCache);
        }
    }
}