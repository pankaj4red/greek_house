<?php

namespace App\Salesforce;

use App\Models\Campaign;
use RuntimeException;

/**
 * Class SFCOpportunityRole
 *
 * @property string  $Id
 * @property string  $OpportunityId
 * @property string  $ContactId
 * @property string  $Role
 * @property boolean $IsPrimary
 */
class SFOpportunityRole extends SFModel
{
    /**
     * Salesforce Object Name
     *
     * @var string
     */
    protected static $object = 'OpportunityContactRole';

    /**
     * Salesforce Object Id
     *
     * @var string
     */
    protected static $objectId = 'Id';

    /**
     * List of relevant Salesforce fields
     *
     * @var string[]
     */
    protected static $fields = [
        'OpportunityId',
        'ContactId',
        'Role',
        'IsPrimary',
    ];

    /**
     * List of relevant Salesforce fields
     *
     * @var string[]
     */
    protected static $fieldsInsert = [
        'OpportunityId',
        'ContactId',
    ];

    /**
     * Creates a Salesforce Object from a Campaign
     *
     * @param Campaign $campaign
     * @param string   $role
     * @return SFOpportunityRole
     */
    public static function createFromCampaign(Campaign $campaign, $role = '')
    {
        if (! $campaign->sf_id) {
            return null;
        }

        switch ($role) {
            case 'Campus Manager':
                if ($campaign->user && $campaign->user->account_manager_id && $campaign->user->account_manager->sf_id) {
                    return new SFOpportunityRole([
                        'OpportunityId' => $campaign->sf_id,
                        'ContactId'     => $campaign->user->account_manager->sf_id,
                        'Role'          => $role,
                        'IsPrimary'     => false,
                    ]);
                }

                return null;
            case 'Printer':
                if ($campaign->decorator && $campaign->decorator->sf_id) {
                    return new SFOpportunityRole([
                        'OpportunityId' => $campaign->sf_id,
                        'ContactId'     => $campaign->decorator->sf_id,
                        'Role'          => $role,
                        'IsPrimary'     => false,
                    ]);
                }
                break;
            case 'Designer':
                if ($campaign->artwork_request && $campaign->artwork_request->designer && $campaign->artwork_request->designer->sf_id) {
                    return new SFOpportunityRole([
                        'OpportunityId' => $campaign->sf_id,
                        'ContactId'     => $campaign->artwork_request->designer->sf_id,
                        'Role'          => $role,
                        'IsPrimary'     => false,
                    ]);
                }
                break;
            case 'Decision Maker':
                if ($campaign->user && $campaign->user->sf_id) {
                    return new SFOpportunityRole([
                        'OpportunityId' => $campaign->sf_id,
                        'ContactId'     => $campaign->user->sf_id,
                        'Role'          => $role,
                        'IsPrimary'     => true,
                    ]);
                }
                break;
            case 'Customer':
            case 'Campus Ambassador':
                return null;
            default:
                throw new RuntimeException('Invalid Opportunity Role: '.$role);
                break;
        }

        return null;
    }
}