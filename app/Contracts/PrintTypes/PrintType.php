<?php

namespace App\Contracts\PrintTypes;

use App\PrintTypes\Data\EstimatedRange;

abstract class PrintType
{
    /**
     * @return array
     */
    public function getEstimatedRangeOptions()
    {
        $options = [];
        foreach ($this->getEstimatedRanges() as $range) {
            $options[$range->code] = $range->code;
        }

        return $options;
    }

    /**
     * @return EstimatedRange[]
     */
    abstract public function getEstimatedRanges();

    /**
     * @param integer $quantity
     * @return \App\PrintTypes\Data\EstimatedRange
     */
    public function getEstimatedRangeByQuantity($quantity)
    {
        foreach ($this->getEstimatedRanges() as $rangeEntry) {
            if ($rangeEntry->from <= $quantity && $rangeEntry->to >= $quantity) {
                return $rangeEntry;
            }
        }

        return null;
    }

    /**
     * @param string $code
     * @return \App\PrintTypes\Data\EstimatedRange
     */
    public function getEstimatedRange($code)
    {
        foreach ($this->getEstimatedRanges() as $rangeEntry) {
            if ($rangeEntry->code == $code) {
                return $rangeEntry;
            }
        }

        return null;
    }

    /**
     * @param $quantity
     * @return float
     */
    public function getMarkup($quantity)
    {
        foreach ($this->getEstimatedRanges() as $rangeEntry) {
            if ($rangeEntry->from <= $quantity && $rangeEntry->to >= $quantity || $rangeEntry->code == $quantity) {
                return $rangeEntry->markup;
            }
        }

        return null;
    }
}
