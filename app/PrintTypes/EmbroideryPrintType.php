<?php

namespace App\PrintTypes;

use App\Contracts\PrintTypes\PrintType;
use App\PrintTypes\Data\EstimatedRange;

class EmbroideryPrintType extends PrintType
{
    /**
     * @return EstimatedRange[]
     */
    public function getEstimatedRanges()
    {
        return [
            new EstimatedRange('12-23', 12, 23, 60),
            new EstimatedRange('24-47', 24, 47, 60),
            new EstimatedRange('48-71', 48, 71, 70),
            new EstimatedRange('72-143', 72, 143, 75),
            new EstimatedRange('144+', 144, PHP_INT_MAX, 70),
        ];
    }
}
