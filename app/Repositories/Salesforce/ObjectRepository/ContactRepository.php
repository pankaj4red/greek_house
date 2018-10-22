<?php

namespace App\Repositories\Salesforce\ObjectRepository;

use App\Console\ConsoleOutput;
use App\Repositories\Salesforce\SalesforceRepository;
use App\Salesforce\SFContact;
use App\Salesforce\SFContactCollection;
use App\Salesforce\SFModel;

class ContactRepository
{
    /**
     * The Repository for Salesforce
     *
     * @var SalesforceRepository
     */
    protected $repository;

    /**
     * ContactRepository constructor.
     *
     * @param SalesforceRepository $repository
     */
    public function __construct(SalesforceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Gets a list of contacts
     *
     * @return SFContactCollection
     */
    public function getContacts()
    {
        ConsoleOutput::subtitle('Fetching Contact Information');

        $list = $this->repository->list(SFContact::objectName(), SFContact::getFields());

        $accounts = [];
        foreach ($list as $row) {
            $accounts[] = new SFContact($row);
        }

        return new SFContactCollection($accounts);
    }

    /**
     * Upserts a contact list on Salesforce
     *
     * @param SFContactCollection $contacts
     * @return SFContactCollection
     * @throws \Exception
     */
    public function putContacts($contacts)
    {
        ConsoleOutput::subtitle('Pushing Contact Information');

        foreach ($contacts as $contact) {
            $this->putContact($contact);
        }

        return $contacts;
    }

    /**
     * Upserts a single contact on Salesforce
     *
     * @param SFContact $contact
     * @return SFContact
     * @throws \Exception
     */
    public function putContact(SFContact $contact)
    {
        if ($contact->Id) {
            $this->repository->update(SFContact::objectName(), $contact->Id, $contact->getData(SFModel::FIELDS_UPDATE));
        } else {
            $contact->Id = $this->repository->create(SFContact::objectName(), $contact->getData(SFModel::FIELDS_INSERT));
        }

        return $contact;
    }
}