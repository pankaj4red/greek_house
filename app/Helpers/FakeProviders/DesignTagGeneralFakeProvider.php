<?php

namespace App\Helpers\FakeProviders;

class DesignTagGeneralFakeProvider extends \Faker\Provider\Base
{
    private $list = [
        'General1',
        'General2',
        'General3',
    ];

    public function design_tag_general()
    {
        return $this->list[rand(0, count($this->list) - 1)];
    }
}