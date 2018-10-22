<?php

namespace App\Repositories\Helpers;

class EnabledDisabledRepository extends HelperRepository
{
    protected $data = [
        ['code' => 'disabled', 'caption' => 'Disabled'],
        ['code' => 'enabled', 'caption' => 'Enabled'],
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