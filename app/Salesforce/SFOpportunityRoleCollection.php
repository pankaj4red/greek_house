<?php

namespace App\Salesforce;

use Illuminate\Support\Collection;

class SFOpportunityRoleCollection extends SFModelCollection
{
    /**
     * Find opportunity role based on Opportunity Id and Role Name
     *
     * @param string $opportunityId
     * @param string $roleName
     * @return Collection|SFOpportunityRole[]
     */
    public function getByOpportunityIdAndRoleName($opportunityId, $roleName)
    {
        $list = [];
        foreach ($this as $role) {
            /** @var SFOpportunityRole $role */
            if ($role->OpportunityId == $opportunityId && $role->Role == $roleName) {
                $list[] = $role;
            }
        }

        return collect($list);
    }

    /**
     * Get all roles of a specific opportunity
     *
     * @param string $opportunityId
     * @return SFOpportunityRoleCollection|null
     */
    public function getByOpportunityId($opportunityId)
    {
        $list = [];

        foreach ($this as $role) {
            /** @var SFOpportunityRole $role */
            if ($role->OpportunityId == $opportunityId) {
                $list[] = $role;
            }
        }

        return new SFOpportunityRoleCollection($list);
    }
}