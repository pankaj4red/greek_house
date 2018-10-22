<?php

namespace App\Repositories\Salesforce\ObjectRepository;

use App\Console\ConsoleOutput;
use App\Repositories\Salesforce\SalesforceRepository;
use App\Salesforce\SFAccount;
use App\Salesforce\SFAccountCollection;

class AccountRepository
{
    /**
     * The Repository for Salesforce
     *
     * @var SalesforceRepository
     */
    protected $repository;

    /**
     * AccountRepository constructor.
     *
     * @param SalesforceRepository $repository
     */
    public function __construct(SalesforceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Gets a list of Accounts
     *
     * @return SFAccountCollection
     * @throws \Exception
     */
    public function getAccounts()
    {
        ConsoleOutput::subtitle('Fetching Account Information');

        $list = $this->repository->list(SFAccount::objectName(), SFAccount::getFields());

        $accounts = [];
        foreach ($list as $row) {
            $accounts[] = new SFAccount($row);
        }

        return new SFAccountCollection($accounts);
    }
}