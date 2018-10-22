<?php

namespace App\Salesforce;

use Illuminate\Support\Collection;

class SFModelCollection extends Collection
{
    /**
     * SFModelList constructor.
     *
     * @param SFModel[] $items
     */
    public function __construct($items = [])
    {
        parent::__construct($items);
    }

    /**
     * Gets an object by Id
     *
     * @param string $id
     * @return SFModel|null
     */
    public function find($id)
    {
        /** @var SFModel $model */
        foreach ($this as $model) {
            if ($model->Id == $id) {
                return $model;
            }
        }

        return null;
    }

    /**
     * gets an object by a field value
     *
     * @param string[] $fields
     * @return SFModel|mixed|null
     */
    public function findBy($fields)
    {
        /** @var SFModel $model */
        foreach ($this as $model) {
            $valid = true;

            foreach ($fields as $fieldKey => $fieldValue) {
                if ($model->$fieldKey != $fieldValue) {
                    $valid = false;
                    break;
                }
            }

            if ($valid) {
                return $model;
            }
        }

        return null;
    }
}