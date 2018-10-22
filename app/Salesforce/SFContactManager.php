<?php

namespace App\Salesforce;

use App\Helpers\ModelCache;

class SFContactManager
{
    use Verbose;

    /**
     * Contacts yet to be analyzed
     *
     * @var SFContactCollection
     */
    protected $unanalyzed;

    /**
     * Contacts yet to be analyzed
     *
     * @var SFContactCollection
     */
    protected $all;

    /**
     * Contacts with invalid critical data (such as no campaign id)
     * These are not processed at all.
     *
     * @var SFContactCollection
     */
    protected $invalid;

    /**
     * Contacts that need to be saved on salesforce
     *
     * @var SFContactCollection
     */
    protected $toSave;

    /**
     * Contacts that need to have information saved on database users
     *
     * @var SFContactCollection
     */
    protected $toSaveDatabase;

    /**
     * Collection of Contacts not needing action.
     *
     * @var SFContactCollection
     */
    protected $noAction;

    /**
     * A cache for users. Improves performance by avoiding constant database access.
     *
     * @var ModelCache
     */
    protected $userCache;

    /**
     * SFContactManager constructor.
     *
     * @param SFContactCollection $contacts
     */
    public function __construct($contacts)
    {
        $this->all = clone $contacts;
        $this->unanalyzed = clone $contacts;
        $this->invalid = new SFContactCollection();
        $this->toSave = new SFContactCollection();
        $this->toSaveDatabase = new SFContactCollection();
        $this->noAction = new SFContactCollection();

        $this->userCache = new ModelCache(user_repository());
    }

    /**
     * Processes Contacts into invalid, to be saved on salesforce and "no action"
     */
    public function process()
    {
        $this->processInvalid();
        $this->processToSaveDatabase();
        $this->processToSave();

        $this->noAction = $this->unanalyzed;
        $this->unanalyzed = new SFContactCollection();
    }

    /**
     * Processes invalid Contacts
     */
    private function processInvalid()
    {
        $this->verboseStart('Processing Invalid Contacts...');

        /** @var SFContact $contact */
        foreach ($this->unanalyzed as $key => $contact) {
            if (is_invalid_account($contact->AccountId)) {
                $this->unanalyzed->forget($key);
                continue;
            }

            if ($contact->Id === null) {
                $contact->AccountId = invalid_account_id();
                $this->invalid->push($contact);
                $this->unanalyzed->forget($key);
                continue;
            }

            if ($contact->Email === null) {
                $contact->AccountId = invalid_account_id();
                $this->invalid->push($contact);
                $this->unanalyzed->forget($key);
                continue;
            }

            $user = $this->userCache->getOrFetch($contact->Email, 'findByEmail');
            if ($user === null) {
                $contact->AccountId = invalid_account_id();
                $this->invalid->push($contact);
                $this->unanalyzed->forget($key);
                continue;
            }
        }

        $this->verboseEnd($this->invalid->count());
    }

    /**
     * Processes Contacts to save on Salesforce
     */
    private function processToSave()
    {
        $this->verboseStart('Processing Contacts to save in Salesforce...');

        // Check if differences happen on our database user since the last time we checked.
        // If there are differences, propagate them to salesforce.
        /** @var SFContact $contact */
        foreach ($this->unanalyzed as $key => $contact) {
            $user = $this->userCache->getOrFetch($contact->Email, 'findByEmail');
            if (! $user) {
                continue;
            }

            $userContact = SFContact::createFromUser($user);
            // Override User data to make sure these particular fields do not change on Salesforce side
            $userContact->AccountId = $contact->AccountId;
            $userContact->Status__c = $contact->Status__c;
            $userContact->Year_In_College__c = $contact->Year_In_College__c;
            $userContact->X1st_Time_Apparel_Chair__c = $contact->X1st_Time_Apparel_Chair__c;
            $userContact->Number_of_Members__c = $contact->Number_of_Members__c;
            $userContact->Title = $contact->Title;
            $userContact->Chapter__c = $contact->Chapter__c;
            $userContact->College_University_c_1__c = $contact->College_University_c_1__c;

            $differences = $userContact->getDifferentData($contact->getLogData(), SFModel::FIELDS_WRITEABLE);
            if ($differences->has('AccountId')) {
                $differences->forget('AccountId');
            }
            if ($differences->count() > 0) {
                $this->verbose('Contact update in salesforce: '.$contact->Email.' ('.json_encode($differences).')');
                $contact->setData($userContact->getData(SFModel::FIELDS_WRITEABLE));
                $this->toSave->push($contact);
                $this->unanalyzed->forget($key);
                continue;
            }
        }

        // Add new users on salesforce.
        $unexistingUsers = user_repository()->getNewUsers();
        foreach ($unexistingUsers as $user) {
            if ($this->all->findByEmail($user->email) === null) {
                $this->verbose('Contact inserted in salesforce: '.$user->email);
                $this->toSave->push(SFContact::createFromUser($user));
            }
        }

        $this->verboseEnd($this->toSave->count());
    }

    /**
     * Processes Contacts that have data needing to be saved on their users counterparts.
     */
    private function processToSaveDatabase()
    {
        $this->verboseStart('Processing Contacts to associate in Database...');

        /** @var SFContact $contact */
        foreach ($this->unanalyzed as $key => $contact) {
            $user = $this->userCache->getOrFetch($contact->Email, 'findByEmail');
            if (! $user) {
                continue;
            }

            $logData = $contact->getLogData();
            $differences = $contact->getDifferentData($contact->getLogData(), SFModel::FIELDS_WRITEABLE);
            if ($logData->count() > 0 && $differences->count() > 0) {
                $this->verbose('User update in database: '.$contact->Email.' ('.json_encode($differences).')');
                $this->toSaveDatabase->push($contact);
                $this->unanalyzed->forget($key);
                continue;
            }
        }

        $this->verboseEnd($this->toSaveDatabase->count());
    }

    /**
     * Save Contact information on the database
     */
    public function saveInDatabase()
    {
        $this->verboseStart('Saving Contacts in database...');

        /** @var SFContact $contact */
        foreach ($this->toSaveDatabase as $contact) {
            $contact->saveDataInDatabase();
        }

        $this->verboseEnd($this->toSaveDatabase->count());
    }

    /**
     * Associate new Contacts with users
     */
    public function associateInDatabase()
    {
        $this->verboseStart('Associating Contacts...');

        /** @var SFContact $contact */
        foreach ($this->all as $contact) {
            $contact->associateInDatabase($this->userCache);
        }

        $this->verboseEnd($this->all->count());
    }

    /**
     * Saves current contact data so that it can be compared next time.
     * This way we can detect whether the changes were made on the database or on salesforce.
     */
    public function saveLog()
    {
        $this->verboseStart('Saving Contact Log...');

        foreach ($this->all as $contact) {
            $contact->saveLog();
        }

        $this->verboseEnd($this->all->count());
    }

    /**
     * List of Invalid Contacts
     * These will not be processed
     *
     * @return SFContactCollection
     */
    public function getInvalid()
    {
        return $this->invalid;
    }

    /**
     * List of Contacts to be saved on Salesforce
     *
     * @return SFContactCollection
     */
    public function getToSave()
    {
        return $this->toSave;
    }

    /**
     * List of Contacts not needing any action
     *
     * @return SFContactCollection
     */
    public function getNoAction()
    {
        return $this->noAction;
    }

    /**
     * List of Contacts to be saved on Database
     *
     * @return SFContactCollection
     */
    public function toSaveDatabase()
    {
        return $this->toSaveDatabase;
    }
}