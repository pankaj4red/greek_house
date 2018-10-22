<?php

namespace App\Helpers\AccessToken;

use Session;

class SessionIO
{
    /**
     * SessionIO constructor.
     */
    public function __construct()
    {
        $this->createStructure();
    }

    /**
     * Creates the structure in session
     */
    protected function createStructure()
    {
        if (! Session::has('access_tokens')) {
            Session::put('access_tokens', []);
        }
    }

    /**
     * @param string $token
     * @return bool
     */
    public function has($token)
    {
        return array_key_exists($token, Session::get('access_tokens'));
    }

    /**
     * @param string $token
     * @return bool
     */
    public function get($token)
    {
        if (! $this->has($token)) {
            return null;
        }

        return Session::get('access_tokens')[$token];
    }

    /**
     * @param string $token
     * @param mixed  $value
     */
    public function add($token, $value)
    {
        Session::put('access_tokens', array_merge($this->all(), [$token => $value]));
    }

    /**
     * @return array
     */
    public function all()
    {
        return Session::get('access_tokens');
    }

    /**
     * Clears all the tokens
     */
    public function clear()
    {
        Session::forget('access_tokens');
        $this->createStructure();
    }
}