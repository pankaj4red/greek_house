<?php

namespace App\Salesforce;

use App\Helpers\ModelCache;
use App\Models\Chapter;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Class SFContact
 *
 * @property $Id
 * @property $FirstName
 * @property $LastName
 * @property $Email
 * @property $Phone
 * @property $Status__c
 * @property $Sales_Rep_Customer__c
 * @property $Campus_Manager__c
 * @property $Year_In_College__c
 * @property $CM_Customer_Sign_Up_Link__c
 * @property $CM_Sign_Up_Link__c
 * @property $CM_SR_Share_Link__c
 * @property $Referral_Link__c
 * @property $AccountId
 * @property $College_University_c_1__c
 * @property $Chapter__c
 * @property $X1st_Time_Apparel_Chair__c
 * @property $Title
 * @property $Number_of_Members__c
 * @property $OwnerId
 * @property $Referred_By__c
 * @property $Contact_Source__c
 * @property $Referred_Id__c
 * @property $of_Campaigns_Placed__c
 * @property $f_Cancelled_Campaigns__c
 * @property $of_Referrals_Submitted__c
 * @property $of_Referrals_w_Successful_Campaigns__c
 * @property $of_Successful_Campaigns__c
 * @property $Avg_Revenue_Campaign__c
 * @property $Avg_Design_Hours_Campaign__c
 * @property $Avg_Quantity_Campaign__c
 * @property $Avg_Revisions_Campaign__c
 * @property $Total_Design_Hours__c
 * @property $Total_Quantity_Ordered__c
 * @property $Total_Revenue__c
 */
class SFContact extends SFModel
{
    /**
     * Salesforce Object Name
     *
     * @var string
     */
    protected static $object = 'Contact';

    /**
     * Salesforce Object Id
     *
     * @var string
     */
    protected static $objectId = 'Id';

    /**
     * Salesforce Object Synchronization Id
     *
     * @var string
     */
    protected static $synchronizationField = 'Email';

    /**
     * List of relevant Salesforce fields
     *
     * @var string[]
     */
    protected static $fields = [
        'FirstName',
        'LastName',
        'Email',
        'Phone',
        'Status__c',
        'Sales_Rep_Customer__c',
        'Campus_Manager__c',
        'Year_In_College__c',
        'CM_Customer_Sign_Up_Link__c',
        'CM_Sign_Up_Link__c',
        'CM_SR_Share_Link__c',
        'Referral_Link__c',
        'AccountId',
        'X1st_Time_Apparel_Chair__c',
        'Number_of_Members__c',
        'Title',
        'Chapter__c',
        'College_University_c_1__c',
        'Referred_By__c',
        'Contact_Source__c',
        'Referred_Id__c',
        'of_Campaigns_Placed__c',
        'of_Cancelled_Campaigns__c',
        'of_Referrals_Submitted__c',
        'of_Referrals_w_Successful_Campaigns__c',
        'of_Successful_Campaigns__c',
        'Avg_Revenue_Campaign__c',
        'Avg_Design_Hours_Campaign__c',
        'Avg_Quantity_Campaign__c',
        'Avg_Revisions_Campaign__c',
        'Total_Design_Hours__c',
        'Total_Quantity_Ordered__c',
        'Total_Revenue__c',
    ];

    /**
     * List of read only Salesforce fields
     *
     * @var string[]
     */
    protected static $fieldsRead = [
        'Id',
        'CreatedDate',
    ];

    /**
     * Associates this Salesforce Object to an User
     *
     * @param ModelCache $modelCache
     */
    public function associateInDatabase($modelCache = null)
    {
        $user = $modelCache ? $modelCache->getOrFetch($this->Email, 'findByEmail') : user_repository()->findByEmail($this->Email);

        if ($user && $user->sf_id != $this->Id) {
            $user->update(['sf_id' => $this->Id]);
        }
    }

    /**
     * Saves information from Salesforce Object to an User
     *
     * @param ModelCache $modelCache
     */
    public function saveDataInDatabase($modelCache = null)
    {
        $user = $modelCache ? $modelCache->getOrFetch($this->Email, 'findByEmail') : user_repository()->findByEmail($this->Email);

        if ($user) {
            $data = [
                'sf_id' => $this->Id,
                //                'first_name' => $this->FirstName,
                //                'last_name'  => $this->LastName,
                //                'phone'      => get_phone($this->Phone, true),
            ];

            if ($this->AccountId && ! is_unmapped_account($this->AccountId)) {
                /** @var Chapter $chapter */
                $chapter = chapter_repository()->findBySfId($this->AccountId);

                $data['chapter_id'] = $chapter ? $chapter->id : null;
                $data['school_id'] = $chapter ? $chapter->school_id : null;
            } else {
                $data['chapter_id'] = null;
                $data['school_id'] = null;
                $data['referred_by_id'] = $this->Referred_Id__c;
            }

            $user->update($data);
        }
    }

    /**
     * Saves a log of the current state so it can be compared next run.
     * This allows to detect on which side (database or salesforce) the data changed.
     */
    public function saveLog()
    {
        $log = sf_contact_repository()->findBySfId($this->Id);
        if (! $log) {
            $log = new \App\Models\SFContact([
                'sf_id'   => $this->Id,
                'content' => json_encode($this->getData()),
            ]);
        } else {
            $log->update([
                'content' => json_encode($this->getData()),
            ]);
        }
    }

    /**
     * Gets the last contact data from out logs.
     *
     * @return Collection|null
     */
    public function getLogData()
    {
        $log = sf_contact_repository()->findBySfId($this->Id);
        if (! $log) {
            return collect();
        }

        return collect(json_decode($log->content));
    }

    /**
     * Creates a Salesforce Object from an User
     *
     * @param User $user
     * @return SFContact
     */
    public static function createFromUser(User $user)
    {
        // Quick fix for unformatted phones.
        if ($user->phone != get_phone($user->phone)) {
            $user->update([
                'phone' => get_phone($user->phone, true),
            ]);
        }

        if ($user->chapter_account == null) {
            $user->assignChapter();
        }

        $accountManager = $user->account_manager;
        $chapter = $user->chapter_account;

        return new SFContact([
            'Id'                                     => $user->sf_id,
            'FirstName'                              => $user->first_name,
            'LastName'                               => $user->last_name,
            'Email'                                  => $user->email,
            'Phone'                                  => get_phone($user->phone, true),
            'Status__c'                              => 'Open',
            'Sales_Rep_Customer__c'                  => user_type_to_salesforce_user_type($user),
            'Campus_Manager__c'                      => $accountManager !== null ? $accountManager->getFullName(true) : 'None',
            'Year_In_College__c'                     => school_year_text($user->school_year),
            'CM_Customer_Sign_Up_Link__c'            => $user->isType('account_manager') ? route('signup_customer::step1', [$user->id], true) : '',
            'CM_Sign_Up_Link__c'                     => $user->isType('account_manager') ? route('signup_account_manager::step1', [$user->id], true) : '',
            'CM_SR_Share_Link__c'                    => $user->isType('account_manager') ? route('signup_sales_rep::step1', [$user->id], true) : '',
            'Referral_Link__c'                       => route('work_with_us::index', [$user->isType('account_manager') ? 'campus' : 'sales', $user->id], true),
            'AccountId'                              => $chapter !== null ? $chapter->sf_id : unmapped_account_id(),
            'Chapter__c'                             => $user->chapter,
            'College_University_c_1__c'              => $user->school,
            'OwnerId'                                => '005j000000CeI9c',
            'of_Campaigns_Placed__c'                 => $user->getPlacedCampaigns(),
            'of_Cancelled_Campaigns__c'              => $user->getCancelledCampaigns(),
            'of_Referrals_Submitted__c'              => $user->getReferralsSubmitted(),
            'of_Referrals_w_Successful_Campaigns__c' => $user->getReferralsSuccess(),
            'of_Successful_Campaigns__c'             => $user->getSuccessfulCampaigns(),
            'Avg_Revenue_Campaign__c'                => $user->getAverageRevenue(),
            'Avg_Design_Hours_Campaign__c'           => round(to_minutes($user->getAverageDesignHours()) / 60, 2),
            'Avg_Quantity_Campaign__c'               => $user->getAverageQuantityOrdered(),
            'Avg_Revisions_Campaign__c'              => $user->getAverageRevisions(),
            'Total_Design_Hours__c'                  => round(to_minutes($user->getTotalDesignHours()) / 60, 2),
            'Total_Quantity_Ordered__c'              => $user->getTotalQuantityOrdered(),
            'Total_Revenue__c'                       => $user->getTotalRevenue(),
        ]);
    }
}
