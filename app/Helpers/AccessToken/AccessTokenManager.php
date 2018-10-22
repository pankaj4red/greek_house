<?php

namespace App\Helpers\AccessToken;

use App;

class AccessTokenManager
{
    /** @var SessionIO $io */
    private $io;

    /**
     * AccessTokenManager constructor.
     */
    public function __construct()
    {
        $this->io = App::make(SessionIO::class);
    }

    /**
     * @param string      $prefix
     * @param string|null $token
     * @return bool
     */
    public function hasToken($prefix, $token = null)
    {
        $token = $token ? ('.'.$token) : '';

        return $this->io->has($prefix.$token);
    }

    /**
     * @param string      $prefix
     * @param string|null $token
     * @return bool
     */
    public function getToken($prefix, $token = null)
    {
        $token = $token ? ('.'.$token) : '';

        return $this->io->get($prefix.$token);
    }

    /**
     * @param string      $prefix
     * @param string|null $token
     * @param bool        $value
     * @return mixed
     */
    public function addToken($prefix, $token = null, $value = true)
    {
        $token = $token ? ('.'.$token) : '';

        return $this->io->add($prefix.$token, $value);
    }

    /**
     * Clears all tokens
     */
    public function clearAllTokens()
    {
        return $this->io->clear();
    }

    /**
     * @param string $prefix
     * @return string[]
     */
    public function getSubTokens($prefix)
    {
        $subTokens = [];
        $all = $this->io->all();
        foreach ($all as $token => $value) {
            if (starts_with($token, $prefix.'.')) {
                $subTokens[str_replace($prefix.'.', '', $token)] = $value;
            }
        }

        return $subTokens;
    }
}