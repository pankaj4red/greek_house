<?php

namespace App\Salesforce;

/**
 * Class SFLead
 *
 * @property string $Id
 * @property string $Chapter__c
 * @property string $Chapter_Size__c
 * @property string $College__c
 * @property string $Position__c
 * @property string $Phone
 * @property string $Name
 * @property string $FirstName
 * @property string $LastName
 * @property string $Email
 * @property string $Company
 * @property string $Status
 * @property string $Campus_Manager_ID__c
 * @property string $Campus_Manager__c
 * @property string $Referred_By__c
 * @property string $Lead_Source__c
 * @property string $Contact__c
 * @property string $X1st_Time_Apparel_Chair__c
 * @property string $OwnerId
 * @property string $No_of_Employees_Chapter_Members__c
 * @property string $Lead_Type__c
 * @property string $Instagram__c
 * @property string $LeadSource
 * @property string $Sign_Up_Link__c
 * @property string $Lead_Source_Raw__c
 * @property string $Referred_Id__c
 * @property string $UTM_Campaign_Medium__c
 * @property string $UTM_Campaign_Content__c
 * @property string $UTM_Campaign_Name__c
 * @property string $UTM_Campaign_Term__c
 * @property string $Ready_to_place_a_design_request__c
 * @property string $GCLID__c
 * @property string $Year_in_College__c
 * @property string $College_Major__c
 * @property string $Involvement_On_Campus__c
 * @property string $Why_do_you_think_you_d_be_a_good_fit_for__c
 * @proeprty string $What_are_the_top_5_brands__c
 * @property string $Follow_Up_Date__c
 * @property string $Notes__c
 */
class SFLead extends SFModel
{
    /**
     * Salesforce Object Name
     *
     * @var string
     */
    protected static $object = 'Lead';

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
        'Chapter__c',
        'Chapter_Size__c',
        'College__c',
        'Position__c',
        'Phone',
        'FirstName',
        'LastName',
        'Email',
        'Company',
        'Status',
        'Campus_Manager_ID__c',
        'Campus_Manager__c',
        'Referred_By__c',
        'LeadSource',
        'Contact__c',
        'X1st_Time_Apparel_Chair__c',
        'No_of_Employees_Chapter_Members__c',
        'Lead_Type__c',
        'Instagram__c',
        'CM_Signup_Link__c',
        'Sign_Up_Link__c',
        'Lead_Source_Raw__c',
        'Referred_Id__c',
        'UTM_Campaign_Medium__c',
        'UTM_Campaign_Content__c',
        'UTM_Campaign_Name__c',
        'UTM_Campaign_Term__c',
        'Ready_to_place_a_design_request__c',
        'GCLID__c',
        'Year_in_College__c',
        'College_Major__c',
        'Involvement_On_Campus__c',
        'Why_do_you_think_you_d_be_a_good_fit_for__c',
        'What_are_the_top_5_brands__c',
        'Follow_Up_Date__c',
        'Notes__c',
    ];
}