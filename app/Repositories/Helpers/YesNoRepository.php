<?php

namespace App\Repositories\Helpers;

class YesNoRepository extends HelperRepository
{
    protected $data = [
        ['code' => 'no', 'caption' => 'No'],
        ['code' => 'yes', 'caption' => 'Yes'],
    ];

    public function options($nullOption = [])
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