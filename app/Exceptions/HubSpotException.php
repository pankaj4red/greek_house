<?php

namespace App\Exceptions;

use GuzzleHttp\Exception\GuzzleException;
use Psy\Exception\RuntimeException;

class HubSpotException extends RuntimeException
{
    /**
     * @param GuzzleException $ex
     * @return HubSpotException
     */
    public static function fromGuzzleException(GuzzleException $ex)
    {
        return new HubSpotException(json_decode($ex->getResponse()->getBody()->getContents())->message);
    }
}