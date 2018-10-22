<?php

namespace App\Validators;

use Carbon\Carbon;

//TODO: Use DateYear in every date validation.
class DateYear
{
    public static $rule = 'date_year';

    public function validate($key, $value)
    {
        $validator = \Validator::make([$key => $value], [$key => 'date']);

        if ($validator->fails()) {
            return false;
        }

        $carbon = Carbon::parse($value);

        if ($carbon->year < 1970) {
            return false;
        }

        return true;
    }
}