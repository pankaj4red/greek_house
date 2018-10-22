<?php

namespace App\Repositories\Helpers;

class ColorRepository extends HelperRepository
{
    protected $data = [
        ['code' => 'front', 'limit' => 6],
        ['code' => 'back', 'limit' => 6],
        ['code' => 'sleeve', 'limit' => 1],
        ['code' => 'pocket', 'limit' => 2],
    ];

    public function options($code, $nullOption = [], $includeZero = true)
    {
        $limit = 0;
        foreach ($this->data as $entry) {
            if ($entry->code == $code) {
                $limit = $entry->limit;
            }
        }
        $options = $nullOption;
        for ($i = $includeZero ? 0 : 1; $i <= $limit; $i++) {
            $options[$i] = $i;
        }

        return $options;
    }
}