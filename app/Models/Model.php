<?php

namespace App\Models;

use App\Events\Model\ModelCreated;
use App\Events\Model\ModelUpdated;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $events = [
        'created' => ModelCreated::class,
        'updated' => ModelUpdated::class,
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    protected static $eventsEnabledStack = 0;

    public static function enableEvents()
    {
        static::$eventsEnabledStack++;
    }

    public static function disableEvents()
    {
        static::$eventsEnabledStack--;
    }

    public static function areEventsEnabled()
    {
        return static::$eventsEnabledStack >= 0;
    }
}
