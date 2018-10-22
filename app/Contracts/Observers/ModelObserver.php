<?php

namespace App\Contracts\Observers;

use Illuminate\Database\Eloquent\Model;

abstract class ModelObserver
{
    /**
     * @param Model $model
     */
    public function created(Model $model)
    {

    }

    /**
     * @param Model $model
     */

    public function saved(Model $model)
    {

    }

    /**
     * @param Model $model
     */
    public function saving(Model $model)
    {

    }

    /**
     * @param Model $model
     */
    public function deleted(Model $model)
    {

    }

    /**
     * @param Model $model
     */
    public function deleting(Model $model)
    {

    }
}
