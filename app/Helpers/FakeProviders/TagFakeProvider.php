<?php

namespace App\Helpers\FakeProviders;

class TagFakeProvider extends \Faker\Provider\Base
{
    private $list = [
        'Theme',
        'Apparel',
        'College',
        'Chapter',
        'Screen',
        'Embroidery',
        'Featured',
        'Popular',
    ];

    public function tag()
    {
        return $this->list[rand(0, count($this->list) - 1)];
    }
}