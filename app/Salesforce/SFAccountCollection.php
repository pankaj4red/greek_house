<?php

namespace App\Salesforce;

use Illuminate\Support\Collection;

class SFAccountCollection extends Collection
{
    /**
     * Returns all chapters from a college.
     *
     * @param string $id
     * @return SFAccount[]
     */
    public function getChildren($id)
    {
        $children = [];
        foreach ($this as $account) {
            /** @var SFAccount $account */
            if ($account->ParentId == $id) {
                $children[] = $account;
            }
        }

        return $children;
    }

    /**
     * @param string $fromId
     * @param string $toId
     */
    public function updateReferences($fromId, $toId)
    {
        foreach ($this as $account) {
            /** @var SFAccount $account */
            if ($account->Id == $fromId && $account->hasPendingIdRefactoring()) {
                $account->Id = $toId;
            }
            if ($account->ParentId == $fromId && $account->hasPendingParentIdRefactoring()) {
                $account->ParentId = $toId;
            }
        }
    }

    public function getByName($name)
    {
        foreach ($this as $account) {
            /** @var SFAccount $account */
            if ($account->Name == $name) {
                return $account;
            }
        }

        return null;
    }

    public function getBySchoolName($school)
    {
        foreach ($this as $account) {
            /** @var SFAccount $account */
            if ($account->ParentId === null && $account->Name == $school) {
                return $account;
            }
        }

        return null;
    }

    public function getBySchoolAndChapter($school, $chapter)
    {
        foreach ($this as $account) {
            /** @var SFAccount $account */
            if ($account->College_University__c == $school && $account->Chapter__c == $chapter) {
                return $account;
            }
        }

        return null;
    }

    public function sortAccounts()
    {
        $parents = [];
        $children = [];
        foreach ($this as $account) {
            /** @var SFAccount $account */
            if ($account->ParentId === null) {
                $parents[] = $account;
            } else {
                $children[] = $account;
            }
        }
        $newList = array_merge($parents, $children);
        // Remove All
        $this->forget($this->keys()->toArray());
        foreach ($newList as $key => $value) {
            $this->put($key, $value);
        }
    }
}