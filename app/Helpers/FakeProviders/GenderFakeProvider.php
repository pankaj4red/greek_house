<?php

namespace App\Helpers\FakeProviders;

class GenderFakeProvider extends \Faker\Provider\Base
{
    private $list = [
        'Men',
        'Women',
        'Unisex',
    ];

    public function gender()
    {
        return $this->list[rand(0, count($this->list) - 1)];
    }
}