<?php

namespace App\Repositories\Salesforce;

use App\Console\ConsoleOutput;
use App\Exceptions\SalesforceException;
use App\Logging\Logger;
use Crunch\Salesforce\AccessTokenGenerator;
use Crunch\Salesforce\Client;

class SalesforceApi
{
    /**
     * API Service for Salesforce
     *
     * @var \Crunch\Salesforce\Client
     */
    protected $client;

    /**
     * A string describing the mode in which the API is running (Live/Sandbox)
     *
     * @var string
     */
    protected $mode;

    /**
     * Constructor.
     *
     * @param $mode
     * @param $loginUrl
     * @param $consumerKey
     * @param $consumerSecret
     * @param $tokenJson
     */
    public function __construct($mode, $loginUrl, $consumerKey, $consumerSecret, $tokenJson)
    {
        $this->mode = $mode;

        Logger::logApi('SF ('.$mode.') Connecting');
        $this->client = Client::create($loginUrl, $consumerKey, $consumerSecret);

        // The application is performing oauth.
        //TODO: Pull this code to a page specific controller
        if (! \Request::is('salesforce-oauth')) {
            $tokenGenerator = new AccessTokenGenerator();
            $accessToken = $tokenGenerator->createFromJson($tokenJson);
            $this->client->setAccessToken($accessToken);

            if ($accessToken->needsRefresh()) {
                $accessToken = $this->client->refreshToken();
            }
            $this->client->setAccessToken($accessToken);
        }
    }

    /**
     * The mode (Live/Sandbox) the API is running on.
     *
     * @return string
     */
    public function mode()
    {
        return $this->mode;
    }

    /**
     * Returns a list of objects
     *
     * @param $query
     * @return array
     */
    public function search($query)
    {
        ConsoleOutput::comment('('.$this->mode().') ', \App\Console\CO_TIMESTAMP);
        ConsoleOutput::info($query, \App\Console\CO_LINE_BREAK);

        Logger::logApi('SF ('.$this->mode().') '.$query);

        try {
            return $this->client->search($query);
        } catch (\Exception $ex) {
            Logger::logApiError($ex->getMessage(), $ex);
            ConsoleOutput::error($ex->getMessage());
            throw SalesforceException::create($ex);
        }
    }

    /**
     * Creates an object
     *
     * @param string   $object
     * @param string[] $data
     * @param string   $verboseText
     * @return bool
     */
    public function createRecord($object, $data, $verboseText = '')
    {
        ConsoleOutput::comment('('.$this->mode().') ', \App\Console\CO_TIMESTAMP);
        ConsoleOutput::info('createRecord '.$object.' '.$verboseText, \App\Console\CO_LINE_BREAK);

        Logger::logApi('SF ('.$this->mode().') createRecord '.$object, ['data' => $data]);

        try {
            return $this->client->createRecord($object, $data);
        } catch (\Exception $ex) {
            Logger::logApiError($ex->getMessage(), $ex);
            throw SalesforceException::create($ex);
        }
    }

    /**
     * Fetches a single object
     *
     * @param string   $object
     * @param string   $objectId
     * @param string[] $fields
     * @return string
     */
    public function getRecord($object, $objectId, $fields)
    {
        ConsoleOutput::comment('('.$this->mode().') ', \App\Console\CO_TIMESTAMP);
        ConsoleOutput::info('getRecord '.$object.' '.$objectId, \App\Console\CO_LINE_BREAK);

        Logger::logApi('SF ('.$this->mode().') getRecord '.$object.' '.$objectId);

        try {
            return $this->client->getRecord($object, $objectId, $fields);
        } catch (\Exception $ex) {
            Logger::logApiError($ex->getMessage(), $ex);
            throw SalesforceException::create($ex);
        }
    }

    /**
     * Updates a single object
     *
     * @param string   $object
     * @param string   $objectId
     * @param string[] $data
     * @param string   $verboseText
     * @return bool
     */
    public function updateRecord($object, $objectId, $data, $verboseText = '')
    {
        ConsoleOutput::comment('('.$this->mode().') ', \App\Console\CO_TIMESTAMP);
        ConsoleOutput::info('updateRecord '.$object.' '.$objectId, \App\Console\CO_LINE_BREAK);

        Logger::logApi('SF ('.$this->mode().') updateRecord '.$object.' '.$objectId, ['id' => $objectId, 'data' => $data]);

        try {
            return $this->client->updateRecord($object, $objectId, $data);
        } catch (\Exception $ex) {
            Logger::logApiError($ex->getMessage(), $ex);
            throw SalesforceException::create($ex);
        }
    }

    /**
     * @param string $object
     * @param        string {
     * @param string $verboseText
     * @return bool
     */
    public function deleteRecord($object, $objectId, $verboseText = '')
    {
        ConsoleOutput::comment('('.$this->mode().') ', \App\Console\CO_TIMESTAMP);
        ConsoleOutput::info('deleteRecord '.$object.' '.$objectId, \App\Console\CO_LINE_BREAK);

        Logger::logApi('SF ('.$this->mode().') deleteRecord '.$object.' '.$objectId, ['id' => $objectId]);

        try {
            return $this->client->deleteRecord($object, $objectId);
        } catch (\Exception $ex) {
            throw SalesforceException::create($ex);
        }
    }

    public function getClient()
    {
        return $this->client;
    }
}