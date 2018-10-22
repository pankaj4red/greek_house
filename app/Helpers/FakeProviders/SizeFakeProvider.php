<?php

namespace App\Helpers\FakeProviders;

class SizeFakeProvider extends \Faker\Provider\Base
{
    private $list = [
        ['name' => 'XXS', 'short' => '2XS'],
        ['name' => 'Extra Small', 'short' => 'XS'],
        ['name' => 'Small', 'short' => 'S'],
        ['name' => 'Medium', 'short' => 'M'],
        ['name' => 'Large', 'short' => 'L'],
        ['name' => 'Extra Large', 'short' => 'XL'],
        ['name' => 'XXL', 'short' => '2XL'],
        ['name' => 'XXXL', 'short' => '3XL'],
        ['name' => 'One Size', 'short' => 'OneSize'],
    ];

    public function size()
    {
        return $this->list[rand(0, count($this->list) - 1)];
    }
}