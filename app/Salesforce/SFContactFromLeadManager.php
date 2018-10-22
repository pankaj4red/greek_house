<?php

namespace App\Salesforce;

class SFContactFromLeadManager
{
    use Verbose;

    /**
     * Contacts yet to be analyzed
     *
     * @var SFContactCollection
     */
    protected $unanalyzed;

    /**
     * List of available Leads
     *
     * @var SFLeadCollection
     */
    protected $leads;

    /**
     * Contacts that need to be saved on salesforce
     *
     * @var SFContactCollection
     */
    protected $toSave;

    /**
     * SFContactFromLeadManager constructor.
     *
     * @param SFContactCollection $contacts
     */
    public function __construct($contacts)
    {
        $this->unanalyzed = clone $contacts;
        $this->toSave = new SFContactCollection();
    }

    /**
     * Set contacts with their respective lead's information
     *
     * @param SFLeadCollection $leads
     */
    public function setLeadFields($leads)
    {
        $this->verboseStart('Setting Lead Fields...');

        $this->leads = $leads;
        $toSaveInSalesforce = [];

        /** @var SFContact $contact */
        foreach ($this->unanalyzed as $contact) {
            /** @var SFLead $lead */
            foreach ($this->leads as $lead) {
                if ($contact->getRealEmail() == $lead->getRealEmail()) {
                    if ($contact->X1st_Time_Apparel_Chair__c != $lead->X1st_Time_Apparel_Chair__c || ($contact->Number_of_Members__c == null && $contact->Number_of_Members__c != number_to_range($lead->No_of_Employees_Chapter_Members__c)) || $contact->Title != $lead->Position__c || ($contact->Chapter__c == null && $contact->Chapter__c != $lead->Chapter__c) || ($contact->College_University_c_1__c == null && $contact->College_University_c_1__c != $lead->College__c)) {
                        if ($contact->Number_of_Members__c == null) {
                            $contact->Number_of_Members__c = number_to_range($lead->No_of_Employees_Chapter_Members__c);
                        }
                        $contact->X1st_Time_Apparel_Chair__c = $lead->X1st_Time_Apparel_Chair__c;
                        $contact->Title = $lead->Position__c;
                        if ($contact->Chapter__c == null) {
                            $contact->Chapter__c = $lead->Chapter__c;
                        }
                        if ($contact->College_University_c_1__c == null) {
                            $contact->College_University_c_1__c = $lead->College__c;
                        }
                        if ($lead->Referred_By__c) {
                            $contact->Referred_By__c = $lead->Referred_By__c;
                            $contact->Contact_Source__c = 'Referral';
                            $contact->Referred_Id__c = $lead->Referred_Id__c;
                        }
                        $toSaveInSalesforce[] = $contact;
                    }

                    break;
                }
            }
        }

        $this->toSave = new SFContactCollection($toSaveInSalesforce);
    }

    /**
     * List of Contacts to be saved on Salesforce
     *
     * @return SFContactCollection
     */
    public function toSave()
    {
        return $this->toSave;
    }
}