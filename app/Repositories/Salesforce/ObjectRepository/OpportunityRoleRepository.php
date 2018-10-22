<?php

namespace App\Repositories\Salesforce\ObjectRepository;

use App\Console\ConsoleOutput;
use App\Repositories\Salesforce\SalesforceRepository;
use App\Salesforce\SFModel;
use App\Salesforce\SFOpportunityRole;
use App\Salesforce\SFOpportunityRoleCollection;

class OpportunityRoleRepository
{
    /**
     * The Repository for Salesforce
     *
     * @var SalesforceRepository
     */
    protected $repository;

    /**
     * RolesRepository constructor.
     *
     * @param SalesforceRepository $repository
     */
    public function __construct(SalesforceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Gets a list of opportunity roles
     *
     * @return SFOpportunityRoleCollection
     */
    public function getRoles()
    {
        ConsoleOutput::subtitle('Fetching Opportunity Role Information');

        $list = $this->repository->list(SFOpportunityRole::objectName(), SFOpportunityRole::getFields());

        $roles = [];
        foreach ($list as $row) {
            $roles[] = new SFOpportunityRole($row);
        }

        return new SFOpportunityRoleCollection($roles);
    }

    /**
     * Upserts a opportunity role list on Salesforce
     *
     * @param SFOpportunityRoleCollection $roles
     * @return SFOpportunityRoleCollection
     */
    public function putRoles($roles)
    {
        ConsoleOutput::subtitle('Pushing Opportunity Role Information');

        foreach ($roles as $role) {
            $this->putRole($role);
        }

        return $roles;
    }

    /**
     * Upserts a single opportunity role on Salesforce
     *
     * @param SFOpportunityRole $role
     * @return SFOpportunityRole
     */
    public function putRole($role)
    {
        if ($role->Id) {
            $this->repository->update(SFOpportunityRole::objectName(), $role->Id, $role->getData(SFModel::FIELDS_UPDATE));
        } else {
            $role->Id = $this->repository->create(SFOpportunityRole::objectName(), $role->getData(SFModel::FIELDS_INSERT));
        }

        return $role;
    }

    /**
     * Deletes a opportunity role list from Salesforce
     *
     * @param SFOpportunityRoleCollection $roles
     */
    public function deleteRoles($roles)
    {
        ConsoleOutput::subtitle('Removing role Information');

        foreach ($roles as $role) {
            $this->deleteRole($role);
        }
    }

    /**
     * Deletes a single opportunity role from Salesforce
     *
     * @param SFOpportunityRole $role
     */
    public function deleteRole($role)
    {
        $this->repository->delete(SFOpportunityRole::objectName(), $role->Id);
    }
}