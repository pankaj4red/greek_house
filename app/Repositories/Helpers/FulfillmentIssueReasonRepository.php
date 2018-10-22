<?php

namespace App\Repositories\Helpers;

class FulfillmentIssueReasonRepository extends HelperRepository
{
    protected $data = [
        ['code' => 'Artwork', 'caption' => 'Artwork Bad'],
        ['code' => 'Garment', 'caption' => 'Garments Bad'],
        ['code' => 'Other', 'caption' => 'Other Reason'],
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