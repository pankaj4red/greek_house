<?php

namespace App\Exceptions;

use Exception;

class RedirectException extends Exception
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string|null
     */
    protected $errorMessage;

    /**
     * RedirectException constructor.
     *
     * @param string      $url
     * @param string|null $errorMessage
     */
    public function __construct($url, $errorMessage = null)
    {
        parent::__construct('');

        $this->url = $url;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
