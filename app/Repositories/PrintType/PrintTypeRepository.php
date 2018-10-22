<?php

namespace App\Repositories\PrintType;

use App\Contracts\PrintTypes\PrintType;
use App\PrintTypes\EmbroideryPrintType;
use App\PrintTypes\ScreenPrintType;

class PrintTypeRepository
{
    /**
     * @param string $name
     * @return PrintType
     */
    public static function getPrintType($name)
    {
        switch ($name) {
            case 'embroidery':
                return new EmbroideryPrintType();
            case 'screen':
            default:
                return new ScreenPrintType();
        }
    }
}
