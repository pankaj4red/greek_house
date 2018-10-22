<?php

namespace App\Helpers;

class Cache
{
    /**
     * List of cached items
     *
     * @var array
     */
    protected $cache = [];

    /**
     * Puts a item on cache
     *
     * @param $id
     * @param $item
     */
    public function put($id, $item)
    {
        $this->cache[$id] = $item;
    }

    /**
     * Checks if an item is being cached
     *
     * @param $id
     * @return bool
     */
    public function has($id)
    {
        return array_key_exists($id, $this->cache);
    }

    /**
     * Gets an item from cache
     *
     * @param $id
     * @return mixed|null
     */
    public function get($id)
    {
        return $this->has($id) ? $this->cache[$id] : null;
    }
}