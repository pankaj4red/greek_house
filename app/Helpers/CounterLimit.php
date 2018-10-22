<?php

namespace App\Helpers;

use RuntimeException;

class CounterLimit
{
    protected $object;

    protected $count = 0;

    protected $limit = 0;

    /**
     * Constructor.
     *
     * @param $object
     * @param $limit
     */
    public function __construct($object, $limit)
    {
        $this->object = $object;
        $this->limit = $limit;
    }

    public function count()
    {
        return $this->count;
    }

    public function limit()
    {
        return $this->limit;
    }

    public function increment($increment = 1)
    {
        $this->count += $increment;

        if ($this->count > $this->limit) {
            throw new RuntimeException('Limit has been hit: '.$this->limit);
        }
    }

    function __call($name, $arguments)
    {
        $this->increment();

        return call_user_func_array([$this->object, $name], $arguments);
    }
}