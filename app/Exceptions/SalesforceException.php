<?php

namespace App\Exceptions;

use Crunch\Salesforce\Exceptions\RequestException;
use Exception;
use RuntimeException;

class SalesforceException extends RuntimeException
{
    /**
     * @param Exception $ex
     * @return SalesforceException
     */
    public static function create(Exception $ex)
    {
        if ($ex instanceof RequestException) {
            $body = $ex->getRequestBody();
            $title = 'Salesforce Exception';
            if (preg_match('/<h2[^>]*>(.*?)<\/h2>/ism', $body, $matches)) {
                $title = strip_tags($matches[1]);
            }
            $message = '';
            if (preg_match('/<p[^>]*>(.*?)<\/p>/ism', $body, $matches)) {
                $message = strip_tags($matches[1]);
            }

            return new SalesforceException(trim($title.' '.$message.' '.$ex->getMessage()), $ex->getCode(), $ex);
        }

        return new SalesforceException($ex->getMessage(), $ex->getCode(), $ex);
    }
}
