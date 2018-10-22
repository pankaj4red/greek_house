<?php

namespace App\Repositories\Helpers;

class ShippingOptionRepository extends HelperRepository
{
    protected $data = [
        ['code' => 'fedex_ground', 'caption' => 'FEDEX GROUND'],
        ['code' => 'fedex_standard_overnight', 'caption' => 'FEDEX STANDARD OVERNIGHT'],
        ['code' => 'fedex_standard_first_overnight', 'caption' => 'FEDEX PRIORITY FIRST OVERNIGHT'],
        ['code' => 'fedex_2_day', 'caption' => 'FEDEX 2 DAY'],
        ['code' => 'fedex_2_day_am', 'caption' => 'FEDEX 2 DAY AM'],
        ['code' => 'fedex_express_saver', 'caption' => 'FEDEX EXPRESS SAVER'],
    ];

    public function options($nullOption = ['' => 'Please select an option'])
    {
        $options = $nullOption;
        foreach ($this->data as $entry) {
            $options[$entry->code] = $entry->caption;
        }

        return $options;
    }

    public function caption($code)
    {
        foreach ($this->data as $entry) {
            if ($entry->code == $code) {
                return $entry->caption;
            }
        }

        return 'N/A';
    }
}