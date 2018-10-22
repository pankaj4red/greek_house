<?php

namespace App\Repositories\Helpers;

class ChapterPositionRepository extends HelperRepository
{
    protected $data = [
        ['code' => 'none', 'caption' => 'None'],
        ['code' => 'tshirt_chair', 'caption' => 'T-Shirt Chair'],
        ['code' => 'social_chair', 'caption' => 'Social Chair'],
        ['code' => 'philanthropy_chair', 'caption' => 'Philanthropy Chair'],
        ['code' => 'treasurer', 'caption' => 'Treasurer'],
        ['code' => 'chapter_officer', 'caption' => 'Chapter Officer'],
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