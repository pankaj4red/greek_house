<?php

namespace App\Exceptions;

class BillingFailedException extends BillingErrorException
{
    /**
     * @var array|string[]
     */
    private $data = [];

    /**
     * BillingFailedException constructor.
     *
     * @param string         $message
     * @param array|string[] $data
     * @param int            $code
     * @param null           $exception
     */
    function __construct($message = '', $data = [], $code = 0, $exception = null)
    {
        parent::__construct($message, $code, $exception);
        $this->data = $data;
    }

    /**
     * @return array|string[]
     */
    public function getData()
    {
        return $this->data;
    }
}
