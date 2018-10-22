<?php

namespace App\Salesforce;

use App\Models\Chapter;
use App\Models\School;

class SFAccountManager
{
    use Verbose;

    protected $accounts;

    protected $toSaveInDatabase;

    protected $toRemoveInDatabase;

    protected $invalid;

    /**
     * SFAccountManager constructor.
     *
     * @param SFAccountCollection $accounts
     * @param bool                $verbose
     */
    public function __construct($accounts, $verbose = false)
    {
        $this->setVerbose($verbose);
        $this->accounts = $accounts;
        $this->accounts->sortAccounts();

        $this->invalid = new SFAccountCollection();
        $this->toSaveInDatabase = new SFAccountCollection();
        $this->toRemoveInDatabase = collect();

        $this->processInvalid();
        $this->processRemoveInDatabase();
        $this->processSaveInDatabase();
    }

    private function processInvalid()
    {
        $this->verboseStart('Processing Invalid Accounts...');

        foreach ($this->accounts as $key => $account) {
            /** @var SFAccount $account */
            if ($account->Name === null || mb_strlen($account->Name) === 0) {
                $this->invalid->push($account);
                $this->accounts->forget($key);
            }
        }
        foreach ($this->accounts as $key => $account) {
            /** @var SFAccount $account */
            if ($account->ParentId === null && ($account->College_University__c === null || mb_strlen($account->College_University__c) === 0)) {
                $this->invalid->push($account);
                $this->accounts->forget($key);
            }
        }
        foreach ($this->accounts as $key => $account) {
            /** @var SFAccount $account */
            if ($account->ParentId !== null && ($account->Chapter__c === null || mb_strlen($account->Chapter__c) === 0)) {
                $this->invalid->push($account);
                $this->accounts->forget($key);
            }
        }
        foreach ($this->accounts as $key => $account) {
            /** @var SFAccount $account */
            if ($account->ParentId === null && count($this->accounts->getChildren($account->Id)) == 0) {
                $this->invalid->push($account);
                $this->accounts->forget($key);
            }
        }
        foreach ($this->accounts as $key => $account) {
            /** @var SFAccount $account */
            if ($account->ParentId !== null && $this->accounts->getById($account->ParentId) === null) {
                $this->invalid->push($account);
                $this->accounts->forget($key);
            }
        }
        $this->verboseStart($this->invalid->count());
    }

    private function processSaveInDatabase()
    {
        $this->verboseStart('Processing Accounts to save in Database...');

        // Deal with schools
        /** @var SFAccount $account */
        foreach ($this->accounts as $key => $account) {
            if ($account->ParentId !== null) {
                continue;
            }
            $school = School::query()->where('sf_id', $account->Id)->where('name', $account->Name)->first();
            if (! $school) {
                $this->verbose('School to database: '.$account->Id.' '.$account->Name);
                $this->toSaveInDatabase->push($account);
                $this->accounts->forget($key);
                continue;
            }
        }

        // Deal with chapters
        /** @var SFAccount $account */
        foreach ($this->accounts as $key => $account) {
            if ($account->ParentId === null) {
                continue;
            }
            $chapter = Chapter::query()->where('sf_id', $account->Id)->where('name', $account->Chapter__c)->first();
            if (! $chapter) {
                $this->toSaveInDatabase->push($account);
                $this->accounts->forget($key);
                continue;
            }
        }

        $this->verboseEnd($this->toSaveInDatabase->count());
    }

    private function processRemoveInDatabase()
    {
        $this->verboseStart('Processing Accounts to remove in Database...');

        $schools = School::query()->get();
        foreach ($schools as $key => $school) {
            if (! $this->accounts->getBySchoolName($school->name)) {
                $this->verbose('School remove database: '.$school->sf_id.' - '.$school->name);
                $this->toRemoveInDatabase->push($school);
                continue;
            }
        }

        $chapters = Chapter::query()->with('school')->get();
        foreach ($chapters as $key => $chapter) {
            if (! $chapter->school_id) {
                $this->verbose('Chapter remove database: '.$chapter->sf_id.' - N/A - '.$chapter->name);
                $this->toRemoveInDatabase->push($chapter);
                continue;
            }

            if (! $this->accounts->getBySchoolAndChapter($chapter->school->name, $chapter->name)) {
                $this->verbose('Chapter remove database: '.$chapter->sf_id.' - '.$chapter->school->name.' - '.$chapter->name);
                $this->toRemoveInDatabase->push($chapter);
                continue;
            }
        }

        // Remove duplication
        //TODO: Implement duplication check

        $this->verboseEnd($this->toRemoveInDatabase->count());
    }

    public function getInvalid()
    {
        return $this->invalid;
    }

    public function getToRemoveInDatabase()
    {
        return $this->toRemoveInDatabase;
    }

    public function getToSaveInDatabase()
    {
        return $this->toSaveInDatabase;
    }

    public function removeInDatabase()
    {
        $this->verboseStart('Removing Accounts in database...');

        foreach ($this->toRemoveInDatabase as $model) {
            $model->delete();
        }

        $this->verboseEnd($this->toRemoveInDatabase->count());
    }

    public function saveInDatabase()
    {
        $this->verboseStart('Saving Accounts in database...');

        /** @var SFAccount $account */
        foreach ($this->toSaveInDatabase as $account) {
            if (! $account->ParentId) {
                $school = School::query()->where('sf_id', $account->Id)->first();
                if ($school) {
                    $school->update([
                        'name' => $account->Name,
                    ]);
                } else {
                    school_repository()->create([
                        'sf_id' => $account->Id,
                        'name'  => $account->Name,
                    ]);
                }
                continue;
            }

            $school = School::query()->where('sf_id', $account->ParentId)->first();
            $chapter = Chapter::query()->where('sf_id', $account->Id)->first();
            if ($chapter) {
                $chapter->update([
                    'sf_id'     => $account->Id,
                    'name'      => $account->Chapter__c,
                    'school_id' => $school ? $school->id : null,
                ]);
            } else {
                chapter_repository()->create([
                    'sf_id'     => $account->Id,
                    'name'      => $account->Chapter__c,
                    'school_id' => $school ? $school->id : null,

                ]);
            }
        }

        $this->verboseEnd($this->toSaveInDatabase->count());
    }
}