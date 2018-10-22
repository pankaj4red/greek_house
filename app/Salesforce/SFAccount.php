<?php

namespace App\Salesforce;

/**
 * Class SFAccount
 *
 * @property $Id
 * @property $Name
 * @property $Chapter__c
 * @property $College_University__c
 * @property $ParentId
 */
class SFAccount extends SFModel
{
    /**
     * Salesforce Object Name
     *
     * @var string
     */
    protected static $object = 'Account';

    /**
     * List of relevant Salesforce fields
     *
     * @var string[]
     */
    protected static $fields = [
        'Id',
        'Name',
        'Chapter__c',
        'College_University__c',
        'ParentId',
    ];

    /**
     * Flags Account as Refactoring
     *
     * @var bool
     */
    protected $hasPendingIdRefactoring = false;

    /**
     * Flags Account as Refactoring
     *
     * @var bool
     */
    protected $hasPendingParentIdRefactoring = false;

    /**
     * Returns whether or not the Account is flagged for any type of refactoring
     *
     * @return bool
     */
    public function hasPendingRefactoring()
    {
        return $this->hasPendingIdRefactoring() || $this->hasPendingParentIdRefactoring();
    }

    /**
     * Returns whether or not the Account is flagged Id Refactoring
     *
     * @return bool
     */
    public function hasPendingIdRefactoring()
    {
        return $this->hasPendingIdRefactoring;
    }

    /**
     * Returns whether or not the Account is flagged for Parent Id Refactoring
     *
     * @return bool
     */
    public function hasPendingParentIdRefactoring()
    {
        return $this->hasPendingParentIdRefactoring;
    }

    /**
     * Returns whether or not the Account is flagged Id Refactoring
     *
     * @param bool $refactoring
     * @return bool
     */
    public function setPendingIdRefactoring($refactoring)
    {
        $this->hasPendingIdRefactoring = $refactoring;
    }

    /**
     * Returns whether or not the Account is flagged for Parent Id Refactoring
     *
     * @param bool $refactoring
     * @return bool
     */
    public function setPendingParentIdRefactoring($refactoring)
    {
        $this->hasPendingParentIdRefactoring = $refactoring;
    }
}