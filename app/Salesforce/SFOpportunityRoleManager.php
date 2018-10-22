<?php

namespace App\Salesforce;

use App\Helpers\ModelCache;

class SFOpportunityRoleManager
{
    use Verbose;

    /**
     * Opportunities Roles yet to be analyzed
     *
     * @var SFOpportunityRoleCollection
     */
    protected $unanalyzed;

    /**
     * Opportunities Roles deemed to be valid
     *
     * @var SFOpportunityRoleCollection
     */
    protected $valid;

    /**
     * Opportunity roles with invalid critical data (such as no contact id)
     * These are not processed at all.
     *
     * @var SFOpportunityRoleCollection
     */
    protected $invalid;

    /**
     * Opportunity Roles that need to be saved on salesforce
     *
     * @var SFOpportunityRoleCollection
     */
    protected $toSave;

    /**
     * Opportunity Roles that need removing from salesforce
     *
     * @var SFOpportunityRoleCollection
     */
    protected $toDelete;

    /**
     * A cache for campaigns. Improves performance by avoiding constant database access.
     *
     * @var ModelCache
     */
    protected $campaignCache;

    /**
     * SFOpportunityContactRoleManager constructor.
     *
     * @param SFOpportunityRoleCollection $opportunityRoles
     */
    public function __construct($opportunityRoles)
    {
        $this->unanalyzed = clone $opportunityRoles;
        $this->invalid = new SFOpportunityCollection();
        $this->toDelete = new SFOpportunityCollection();
        $this->toSave = new SFOpportunityCollection();

        $this->campaignCache = new ModelCache(campaign_repository());
    }

    /**
     * Processes opportunity roles into invalid, to be saved or removed from salesforce and "no action"
     */
    public function process()
    {
        $this->processInvalid();

        $this->valid = $this->unanalyzed;
        $this->unanalyzed = new SFOpportunityCollection();

        $this->processToSave();
        $this->processToDelete();
    }

    /**
     * Processes invalid opportunity roles
     */
    public function processInvalid()
    {
        $this->verboseStart('Processing Invalid Roles...');

        /** @var SFOpportunityRole $role */
        foreach ($this->unanalyzed as $key => $role) {
            if ($role->Id === null) {
                $this->invalid->push($role);
                $this->unanalyzed->forget($key);
                continue;
            }

            if ($role->OpportunityId === null) {
                $this->invalid->push($role);
                $this->unanalyzed->forget($key);
                continue;
            }

            if ($role->ContactId === null) {
                $this->invalid->push($role);
                $this->unanalyzed->forget($key);
                continue;
            }

            if ($role->Role === null) {
                $this->invalid->push($role);
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
        $this->verboseStart('Processing Opportunity Roles to save in Salesforce...');

        $roles = ['Campus Manager', 'Decision Maker', 'Designer', 'Printer'];
        $campaigns = campaign_repository()->getCreatedAfter(config('services.salesforce.cutout_date'));
        $all = $this->getValid();
        $count = 0;
        foreach ($campaigns as $campaign) {
            if ($count % 100 == 0) {
                $this->verbose('Processing Campaigns: '.$count.'/'.count($campaigns));
            }
            $this->campaignCache->put($campaign->id, $campaign);

            foreach ($roles as $role) {
                $campaignRole = SFOpportunityRole::createFromCampaign($campaign, $role);
                $opportunityRole = $all->getByOpportunityIdAndRoleName($campaign->sf_id, $role)->first();

                if ($campaignRole && ! $opportunityRole) {
                    $this->verbose('Opportunity Role insert: '.$campaignRole->OpportunityId.' '.$campaignRole->Role.' '.$campaignRole->ContactId);
                    $this->toSave->push($campaignRole);
                }

                if ($campaignRole && $opportunityRole) {
                    if (! $campaignRole->isEqual($opportunityRole, SFModel::FIELDS_WRITEABLE)) {
                        $this->verbose('Opportunity Role update: '.$opportunityRole->OpportunityId.' '.$opportunityRole->Role.' '.$opportunityRole->ContactId);
                        $this->toSave->push($opportunityRole->setData($campaignRole->getData(SFModel::FIELDS_WRITEABLE)));
                    }
                }
            }

            $count++;
        }

        $this->verboseEnd($this->toSave->count());
    }

    /**
     * Processes opportunities to save on Salesforce
     */
    private function processToDelete()
    {
        $this->verboseStart('Processing Opportunity role to delete from Salesforce...');

        $roles = ['Campus Manager', 'Decision Maker', 'Designer', 'Printer', 'Customer', 'Campus Ambassador'];
        $campaigns = campaign_repository()->getCreatedAfter('2017-10-01');//config('services.salesforce.cutout_date'));
        $all = $this->getValid();
        $count = 0;
        foreach ($campaigns as $campaign) {
            if ($count % 100 == 0) {
                $this->verbose('Processing Campaigns: '.$count.'/'.count($campaigns));
            }
            $this->campaignCache->put($campaign->id, $campaign);

            foreach ($roles as $role) {
                $campaignRole = SFOpportunityRole::createFromCampaign($campaign, $role);
                $opportunityRoleList = $all->getByOpportunityIdAndRoleName($campaign->sf_id, $role);

                if ($opportunityRoleList->first() && ! $campaignRole) {
                    $this->verbose('Opportunity Role delete: '.$opportunityRoleList->first()->OpportunityId.' '.$opportunityRoleList->first()->Role.' '.$opportunityRoleList->first()->ContactId);
                    $this->toDelete->push($opportunityRoleList->first());
                }

                if ($opportunityRoleList->count() > 1) {
                    $list = $opportunityRoleList->slice(1, $opportunityRoleList->count() - 1);
                    foreach ($list as $opportunityRole) {
                        $this->verbose('Opportunity Role delete duplicate: '.$opportunityRole->OpportunityId.' '.$opportunityRole->Role.' '.$opportunityRole->ContactId);
                        $this->toDelete->push($opportunityRole);
                    }
                }
            }

            $count++;
        }

        $this->verboseEnd($this->toSave->count());
    }

    /**
     * List of all valid Opportunities
     *
     * @return SFOpportunityRoleCollection
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * List of Invalid Opportunities
     * These will not be processed
     *
     * @return SFOpportunityRoleCollection
     */
    public function getInvalid()
    {
        return $this->invalid;
    }

    /**
     * List of Opportunities to be saved on Salesforce
     *
     * @return SFOpportunityRoleCollection
     */
    public function getToSave()
    {
        return $this->toSave;
    }

    /**
     * List of Opportunities to be deleted from Salesforce
     *
     * @return SFOpportunityRoleCollection
     */
    public function getToDelete()
    {
        return $this->toDelete;
    }
}