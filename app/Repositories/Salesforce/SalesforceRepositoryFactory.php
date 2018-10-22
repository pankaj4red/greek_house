<?php

namespace App\Repositories\Salesforce;

use App\Exceptions\SalesforceException;

class SalesforceRepositoryFactory
{
    protected static $live;

    protected static $sandbox;

    /**
     * @return SalesforceRepository|null
     * @throws \Exception
     */
    public static function get()
    {
        if (! config('services.salesforce.enabled')) {
            return null;
        }
        if (config('services.salesforce.mode') == 'live') {
            return static::getLive();
        }
        if (config('services.salesforce.mode') == 'sandbox') {
            return static::getSandbox();
        }
        throw new SalesforceException('Unknown salesforce mode: '.config('services.salesforce.mode'));
    }

    /**
     * @return SalesforceRepository|null
     */
    public static function getLive()
    {
        if (! config('services.salesforce.enabled')) {
            return null;
        }
        if (! static::$live) {
            static::$live = \App::make('salesforce.live');
        }

        return static::$live;
    }

    /**
     * @return SalesforceRepository|null
     */
    public static function getSandbox()
    {
        if (! config('services.salesforce.enabled')) {
            return null;
        }
        if (! static::$sandbox) {
            static::$sandbox = \App::make('salesforce.sandbox');
        }

        return static::$sandbox;
    }
}