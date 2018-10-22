<?php

namespace App\Repositories\Helpers;

class SchoolYearRepository extends HelperRepository
{
    protected $data = [
        ['code' => 'freshman', 'caption' => 'Freshman'],
        ['code' => 'sophomore', 'caption' => 'Sophomore'],
        ['code' => 'junior', 'caption' => 'Junior'],
        ['code' => 'senior', 'caption' => 'Senior'],
        ['code' => 'senior_5th', 'caption' => 'Senior 5th Year'],
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