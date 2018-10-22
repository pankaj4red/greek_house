<?php

namespace App\Helpers\FakeProviders;

class GarmentCategoryFakeProvider extends \Faker\Provider\Base
{
    private $list = [
        'Short Sleeves',
        'V-Necks',
        'Tanks',
        'Long Sleeves',
        'Sweatshirts',
        'Polo',
        'Athletic Wear',
        'Jersey',
        'Bottoms',
        'No Category',
        'Accessories',
        'Dresses',
        'Jackets',
        'Outdoors',
        'Top Sellers',
        'Flowy',
        'Hats',
    ];

    public function garment_category()
    {
        return $this->list[rand(0, count($this->list) - 1)];
    }
}