<?php

namespace App\Repositories\Salesforce;

use App\Console\ConsoleOutput;
use App\Exceptions\SalesforceException;
use App\Logging\Logger;
use App\Repositories\Salesforce\ObjectRepository\AccountRepository;
use App\Repositories\Salesforce\ObjectRepository\ContactRepository;
use App\Repositories\Salesforce\ObjectRepository\LeadRepository;
use App\Repositories\Salesforce\ObjectRepository\OpportunityRepository;
use App\Repositories\Salesforce\ObjectRepository\OpportunityRoleRepository;
use DateTime;
use RuntimeException;

class SalesforceRepository
{
    /**
     * The Salesforce API Client Wrapper
     *
     * @var SalesforceApi
     */
    protected $api;

    /**
     * Opportunity Repository handles all the calls related with opportunities
     *
     * @var OpportunityRepository
     */
    protected $opportunity;

    /**
     * Account Repository handles all the calls related with accounts
     *
     * @var AccountRepository
     */
    protected $account;

    /**
     * Contact Repository handles all the calls related with contacts
     *
     * @var ContactRepository
     */
    protected $contact;

    /**
     * Lead Repository handles all the calls related with leads
     *
     * @var LeadRepository
     */
    protected $lead;

    /**
     * Roles Repository handles all the calls related with opportunity roles
     *
     * @var OpportunityRoleRepository
     */
    protected $opportunityRole;

    /**
     * List of errors that are to be ignored.
     *
     * @var string[]
     */
    protected $ignoreErrors = ['entity is deleted', 'cannot reference converted lead'];

    /**
     * SalesforceRepository constructor.
     *
     * @param SalesforceApi $api
     */
    public function __construct(SalesforceApi $api)
    {
        $this->api = $api;

        $this->opportunity = new OpportunityRepository($this);
        $this->opportunityRole = new OpportunityRoleRepository($this);
        $this->account = new AccountRepository($this);
        $this->contact = new ContactRepository($this);
        $this->lead = new LeadRepository($this);
    }

    /**
     * Get the Salesforce API Wrapper
     *
     * @return SalesforceApi
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * Get the Salesforce API Client
     *
     * @return \Crunch\Salesforce\Client
     */
    public function getClient()
    {
        return $this->api->getClient();
    }

    /**
     * Get the Opportunity repository
     *
     * @return OpportunityRepository
     */
    public function opportunity()
    {
        return $this->opportunity;
    }

    /**
     * Get the Account repository
     *
     * @return AccountRepository
     */
    public function account()
    {
        return $this->account;
    }

    /**
     * Get the Contact repository
     *
     * @return ContactRepository
     */
    public function contact()
    {
        return $this->contact;
    }

    /**
     * Get the Lead repository
     *
     * @return LeadRepository
     */
    public function lead()
    {
        return $this->lead;
    }

    /**
     * Get the Role repository
     *
     * @return OpportunityRoleRepository
     */
    public function opportunityRole()
    {
        return $this->opportunityRole;
    }

    /**
     * Lists records
     *
     * @param string   $object
     * @param string[] $fields
     * @param string   $lastId
     * @return array
     */
    public function list($object, $fields, $lastId = '')
    {
        $list = collect();

        $fields = $this->cleanFieldsName($fields);

        foreach ($fields as $key => $field) {
            $fields[$key] = preg_replace("/[^a-z0-9_]+/i", '', $field);
        }

        do {
            $results = $this->api->search("SELECT ".implode(",", $fields)." FROM ".$object." WHERE Id > '".$lastId."' ORDER BY Id ASC LIMIT 2000");

            foreach ($results as $row) {
                $list->push($row);
            }
            $lastId = last($results)['Id'];
        } while (count($results) == 2000);

        return $list;
    }

    /**
     * Reads a record
     *
     * @param string   $object
     * @param string   $objectId
     * @param string[] $fields
     * @return mixed
     */
    public function read($object, $objectId, $fields)
    {
        return $this->api->getRecord($object, $objectId, $fields);
    }

    private function value($value)
    {
        // is date
        if (DateTime::createFromFormat(DateTime::ISO8601, $value) !== false) {
            return $value;
        }

        if (is_numeric($value)) {
            return $value;
        }

        return '\''.addslashes($value).'\'';
    }

    /**
     * Finds records based on fields
     *
     * @param string   $object
     * @param string[] $fields
     * @param string[] $parameters
     * @return mixed
     */
    public function find($object, $fields, $parameters)
    {
        $fields = $this->cleanFieldsName($fields);
        $parameters = $this->cleanParameters($parameters);
        $parameterList = [];
        foreach ($parameters as $key => $value) {
            if (is_numeric($value)) {
                $parameterList[] = $key.' = '.$this->value($value);
            } elseif (is_array($value)) {
                $parameterList[] = $key.' '.$value[0].' '.$this->value($value[1]);
            } else {
                $parameterList[] = $key.' = '.$this->value($value);
            }
        }

        $list = collect();
        $lastId = '';

        do {
            $results = $this->api->search("SELECT ".implode(', ', $fields)." FROM ".$object." WHERE ".implode(' AND ', $parameterList)." AND Id > '".$lastId."' ORDER BY Id ASC LIMIT 2000");

            foreach ($results as $row) {
                $list->push($row);
            }
            $lastId = last($results)['Id'];
        } while (count($results) == 2000);

        return $list;
    }

    /**
     * Updates a record
     *
     * @param string   $object
     * @param string[] $data
     * @return bool
     */
    public function create($object, $data)
    {
        if ($this->api->mode() == 'sandbox' && config('salesforce.mode') == 'live') {
            throw new RuntimeException('Can only create '.$object.' on Sandbox');
        }

        try {
            return $this->api->createRecord($object, $data);
        } catch (SalesforceException $ex) {
            // Check for error messages to ignore
            foreach ($this->ignoreErrors as $error) {
                if (str_contains($ex->getMessage(), $error)) {
                    ConsoleOutput::warning('(skipped) create '.$object.' || '.json_encode($data).' || '.$ex->getMessage(), \App\Console\CO_TIMESTAMP | \App\Console\CO_LINE_BREAK);

                    return null;
                }
            }

            // Notify and Continue
            ConsoleOutput::error('create '.$object.' || '.json_encode($data).' || '.$ex->getMessage(), \App\Console\CO_TIMESTAMP | \App\Console\CO_LINE_BREAK);
            Logger::logFallback($ex);

            return null;
        }
    }

    /**
     * Updates a record
     *
     * @param string   $object
     * @param string   $objectId
     * @param string[] $data
     * @return bool
     */
    public function update($object, $objectId, $data)
    {
        if ($this->api->mode() == 'sandbox' && config('salesforce.mode') == 'live') {
            throw new RuntimeException('Can only update '.$object.' on Sandbox');
        }

        try {
            return $this->api->updateRecord($object, $objectId, $data);
        } catch (SalesforceException $ex) {
            // Check for error messages to ignore
            foreach ($this->ignoreErrors as $error) {
                if (str_contains($ex->getMessage(), $error)) {
                    ConsoleOutput::warning('(skipped) update '.$object.' '.$objectId.' || '.json_encode($data).' || '.$ex->getMessage(), \App\Console\CO_TIMESTAMP | \App\Console\CO_LINE_BREAK);

                    return null;
                }
            }

            // Notify and Continue
            ConsoleOutput::error('update '.$object.' '.$objectId.' || '.json_encode($data).' || '.$ex->getMessage(), \App\Console\CO_TIMESTAMP | \App\Console\CO_LINE_BREAK);
            Logger::logFallback($ex);

            return null;
        }
    }

    /**
     * Deletes a record
     *
     * @param string $object
     * @param string $objectId
     * @return bool
     */
    public function delete($object, $objectId)
    {
        if ($this->api->mode() == 'sandbox' && config('salesforce.mode') == 'live') {
            throw new RuntimeException('Can only remove '.$object.' on Sandbox');
        }

        try {
            return $this->api->deleteRecord($object, $objectId);
        } catch (SalesforceException $ex) {
            // Check for error messages to ignore
            foreach ($this->ignoreErrors as $error) {
                if (str_contains($ex->getMessage(), $error)) {
                    ConsoleOutput::warning('(skipped) update '.$object.' '.$objectId.' || '.$ex->getMessage(), \App\Console\CO_TIMESTAMP | \App\Console\CO_LINE_BREAK);

                    return null;
                }
            }

            // Notify and Continue
            ConsoleOutput::error('update '.$object.' '.$objectId.' || '.$ex->getMessage(), \App\Console\CO_TIMESTAMP | \App\Console\CO_LINE_BREAK);
            Logger::logFallback($ex);

            return null;
        }
    }

    /**
     * Cleans a field list by removing any potentially invalid characters.
     * Filter out non alphanumeric characters (plus underscore)
     * This avoids any issues regarding Salesforce API usage.
     *
     * @param string[] $fields
     * @return string[]
     */
    private function cleanFieldsName($fields)
    {
        foreach ($fields as $key => $field) {
            $fields[$key] = preg_replace("/[^a-z0-9_]+/i", '', $field);
        }

        return $fields;
    }

    /**
     * Cleans a parameter array by removing any potentially invalid characters.
     * Filter out non alphanumeric characters (plus underscore)
     * This avoids any issues regarding Salesforce API usage.
     *
     * @param string[] $parameters
     * @return string[]
     */
    private function cleanParameters($parameters)
    {
        $cleanedParameters = [];
        foreach ($parameters as $key => $value) {
            $key = preg_replace("/[^a-z0-9_]+/i", '', $key);
            $cleanedParameters[$key] = $value;
        }

        return $cleanedParameters;
    }
}