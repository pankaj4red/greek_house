<?php

namespace App\Repositories\Helpers;

class CountryRepository extends HelperRepository
{
    protected $data = [
        ['code' => 'usa', 'caption' => 'United States'],
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