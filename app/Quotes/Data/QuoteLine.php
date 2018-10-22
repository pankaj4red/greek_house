<?php

namespace App\Quotes\Data;

class QuoteLine
{
    private $key = '';

    private $title = '';

    private $unit = [0, 0];

    private $total = [0, 0];

    function __construct($key, $title, $unitFrom, $unitTo, $totalFrom, $totalTo)
    {
        $this->key = $key;
        $this->title = $title;
        $this->unit = [round($unitFrom, 2), round($unitTo, 2)];
        $this->total = [round($totalFrom, 2), round($totalTo, 2)];
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getUnitFrom()
    {
        return $this->unit[0];
    }

    public function getUnitTo()
    {
        return $this->unit[1];
    }

    public function getTotalFrom()
    {
        return $this->total[0];
    }

    public function getTotalTo()
    {
        return $this->total[1];
    }

    public function toArray()
    {
        return ['key' => $this->key, 'title' => $this->title, 'unit' => $this->unit, 'total' => $this->total];
    }
}
