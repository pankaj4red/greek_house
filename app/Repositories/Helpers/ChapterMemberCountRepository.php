<?php

namespace App\Repositories\Helpers;

class ChapterMemberCountRepository extends HelperRepository
{
    protected $data = [
        ['code' => 1, 'caption' => '1-23'],
        ['code' => 24, 'caption' => '24-50'],
        ['code' => 51, 'caption' => '51-80'],
        ['code' => 81, 'caption' => '81-120'],
        ['code' => 121, 'caption' => '121-150'],
        ['code' => 151, 'caption' => '151+'],
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