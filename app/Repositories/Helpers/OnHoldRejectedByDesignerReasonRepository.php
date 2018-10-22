<?php

namespace App\Repositories\Helpers;

class OnHoldRejectedByDesignerReasonRepository extends HelperRepository
{
    protected $data = [
        ['code' => 'generic', 'caption' => 'Generic Reason'],
        ['code' => 'not_enough_information', 'caption' => 'Not enough information'],
        ['code' => 'inappropriate_design', 'caption' => 'Inappropriate Design'],
        ['code' => 'copyright_infringement', 'caption' => 'Copyright Infringement'],
        ['code' => 'impossible', 'caption' => 'Impossible'],
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