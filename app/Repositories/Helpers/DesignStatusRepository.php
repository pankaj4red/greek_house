<?php

namespace App\Repositories\Helpers;

class DesignStatusRepository extends HelperRepository
{
    protected $data = [
        ['code' => 'new', 'caption' => 'New'],
        ['code' => 'disabled', 'caption' => 'Disabled'],
        ['code' => 'enabled', 'caption' => 'Enabled'],
        ['code' => 'search', 'caption' => 'Search Only'],
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