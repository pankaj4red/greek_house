<?php

namespace App\Quotes;

use App\Quotes\Data\QuoteGroup;

abstract class Quote
{
    protected $data = null;

    protected $success = false;

    protected $errors = [];

    public function isSuccess()
    {
        return $this->success;
    }

    protected function setSuccess($success)
    {
        $this->success = $success;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    protected $colorCosts = [
        ['from' => 0, 'to' => 0, 'colors' => [0, 0, 0, 0, 0, 0, 0, 0, 0]],
        ['from' => 1, 'to' => 23, 'colors' => [0, 2.00, 2.70, 3.45, 4.10, 4.75, 5.40, 6.00, 6.60]],
        ['from' => 24, 'to' => 47, 'colors' => [0, 1.60, 2.10, 2.60, 3.10, 3.50, 3.90, 4.30, 4.70]],
        ['from' => 48, 'to' => 71, 'colors' => [0, 1.20, 1.45, 1.70, 1.95, 2.15, 2.35, 2.55, 2.75]],
        ['from' => 72, 'to' => 143, 'colors' => [0, 0.85, 1.10, 1.35, 1.60, 1.80, 2.00, 2.20, 2.40]],
        ['from' => 144, 'to' => 215, 'colors' => [0, 0.69, 0.87, 1.03, 1.19, 1.35, 1.51, 1.67, 1.83]],
        ['from' => 216, 'to' => 287, 'colors' => [0, 0.60, 0.75, 0.90, 1.05, 1.18, 1.33, 1.48, 1.63]],
        ['from' => 288, 'to' => 359, 'colors' => [0, 0.52, 0.62, 0.72, 0.82, 0.90, 0.98, 1.06, 1.14]],
        ['from' => 360, 'to' => 603, 'colors' => [0, 0.48, 0.58, 0.68, 0.78, 0.86, 0.94, 1.02, 1.10]],
        ['from' => 605, 'to' => 1007, 'colors' => [0, 0.38, 0.48, 0.58, 0.68, 0.76, 0.84, 0.92, 1.00]],
        ['from' => 1008, 'to' => 2015, 'colors' => [0, 0.27, 0.37, 0.47, 0.57, 0.65, 0.73, 0.81, 0.89]],
        ['from' => 2016, 'to' => 2147483647, 'colors' => [0, 0.25, 0.35, 0.45, 0.55, 0.63, 0.61, 0.69, 0.77]],
    ];

    protected $flashCosts = [
        ['from' => 0, 'to' => 0, 'cost' => 0],
        ['from' => 1, 'to' => 71, 'cost' => 0.25],
        ['from' => 72, 'to' => 359, 'cost' => 0.15],
        ['from' => 360, 'to' => 1007, 'cost' => 0.1],
        ['from' => 1008, 'to' => 2147483647, 'cost' => 0.05],
    ];

    protected function getColorCost($estimatedQuantity, $colors)
    {
        foreach ($this->colorCosts as $cost) {
            if ($cost['from'] >= $estimatedQuantity && $estimatedQuantity <= $cost['to']) {
                if ($colors < count($cost['colors'])) {
                    return $cost['colors'][$colors];
                }

                return $cost['colors'][count($cost['colors']) - 1];
            }
        }

        return null;
    }

    protected function getFlashCost($estimatedQuantity)
    {
        foreach ($this->flashCosts as $cost) {
            if ($cost['from'] >= $estimatedQuantity && $estimatedQuantity <= $cost['to']) {
                return $cost['cost'];
            }
        }

        return null;
    }

    protected $groups = [];

    protected function addGroup(QuoteGroup $group)
    {
        $this->groups[] = $group;
    }

    /**
     * @param $key
     * @return QuoteGroup|null
     */
    protected function getGroup($key)
    {
        foreach ($this->groups as $group) {
            if ($group->getKey() == $key) {
                return $group;
            }
        }

        return null;
    }

    public function getGroups()
    {
        return $this->groups;
    }

    protected function validateData(&$data)
    {
        foreach ($this->getParameters() as $key => $value) {
            if (! isset($data[$key])) {
                $data[$key] = $value['default'];
            }
            switch ($value['type']) {
                case 'money':
                    $value = doubleval($data[$key]);
                    $data[$key] = $value;
                    if ($value < 0) {
                        $this->errors[] = $key.' is less than zero: '.$value;
                    }
                    break;
                case 'integer':
                    $value = intval($data[$key]);
                    $data[$key] = $value;
                    if ($value < 0) {
                        $this->errors[] = $key.' is less than zero: '.$value;
                    }
                    break;
                case 'select':
                    if (! in_array($data[$key], $value['values'])) {
                        $this->errors[] = $key.' value is not valid: '.$data[$key];
                    }
                    break;
                case 'hour':
                    $data[$key] = to_minutes($data[$key]);
                    break;
                case 'string':
                    break;
            }
        }
        if (count($this->errors) > 0) {
            return false;
        }

        return true;
    }

    public function toArray()
    {
        $array = [
            'groups'      => [],
            'cost_unit'   => [
                round($this->getCostPerUnitFrom(), 2),
                round($this->getCostPerUnitTo(), 2),
            ],
            'cost_total'  => [
                round($this->getCostTotalFrom(), 2),
                round($this->getCostTotalTo(), 2),
            ],
            'price_unit'  => [
                round($this->getPricePerUnitFrom(), 2),
                round($this->getPricePerUnitTo(), 2),
            ],
            'price_total' => [
                round($this->getPriceTotalFrom(), 2),
                round($this->getPriceTotalTo(), 2),
            ],
        ];
        foreach ($this->groups as $group) {
            $array['groups'][] = $group->toArray();
        }

        return $array;
    }

    abstract public function getParameters();

    /**
     * @param $data
     * @return $this
     */
    abstract public function quote($data);

    abstract public function getCostPerUnitFrom();

    abstract public function getCostPerUnitTo();

    abstract public function getPricePerUnitFrom();

    abstract public function getPricePerUnitTo();

    abstract public function getCostTotalFrom();

    abstract public function getCostTotalTo();

    abstract public function getPriceTotalFrom();

    abstract public function getPriceTotalTo();
}
