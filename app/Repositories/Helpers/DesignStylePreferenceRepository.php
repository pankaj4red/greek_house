<?php

namespace App\Repositories\Helpers;

class DesignStylePreferenceRepository extends HelperRepository
{
    protected $data = [
        ['code' => 'cartoon', 'caption' => 'Cartoon'],
        ['code' => 'realistic_sketch', 'caption' => 'Realistic Sketch'],
        ['code' => 'mixed_graphic', 'caption' => 'Mixed Graphic'],
        ['code' => 'line_art', 'caption' => 'Line Art'],
        ['code' => 'typographical', 'caption' => 'Typographical'],
        ['code' => 'graphic_stamp', 'caption' => 'Graphic/Stamp'],
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

        return 'None';
    }
}