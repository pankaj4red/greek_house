<?php

namespace App\Repositories\Helpers;

class FlexibleRepository extends HelperRepository
{
    protected $data = [
        ['code' => 'no', 'caption' => 'I need this Order Delivered by a specific date'],
        ['code' => 'yes', 'caption' => 'I\'m okay with 10 business days'],
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