<?php

namespace App\Helpers\FakeProviders;

class GarmentBrandFakeProvider extends \Faker\Provider\Base
{
    private $list = [
        'American Apparel',
        'Bella+ Canvas',
        'Comfort Colors',
        'Gildan',
        'Anvil',
        'Next Level',
        'Hanes',
        'Jerzees',
        'Nike',
        'Spirit Jerseys',
        'Port & Company',
        'No Brand',
        'Columbia',
        'Augusta',
        'UltraClub',
        'Alternative Apparel',
        'District',
        'Soffe',
        'Bayside',
        'Yupoong',
        'Adam\'s',
        'Charles River Apparel',
        'Patagonia',
        'Dyenomite',
        'BOA',
        'Sport-Tek',
        'A4',
        'BAGedge',
        'Jansport',
        'Button Pins',
        'Promo Managers',
        'Eco-Hybrid',
        'Flexfit',
        'MV Sport',
        'Backpacker',
        'Alternative',
        'Harriton',
        'Phasemark',
        'Ash City',
        'Authentic Pigment',
        'econscious',
        'Custom Product',
        'KC Caps',
        'Champion',
    ];

    public function garment_brand()
    {
        return $this->list[rand(0, count($this->list) - 1)];
    }
}