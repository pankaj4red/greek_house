<?php

namespace App\Helpers\FakeProviders;

class AddressNameFakeProvider extends \Faker\Provider\Base
{
    private $list = [
        'Home',
        'School',
        'Retreat',
        'Home Address',
        'House',
        'Sables',
        'Apartment',
        'My House',
        'Office',
        'LA office',
        'Shipping address',
        'Shipping',
        'Address',
        'College',
        'Chapter',
        'Dormitory',
    ];

    public function address_name()
    {
        return $this->list[rand(0, count($this->list) - 1)];
    }
}