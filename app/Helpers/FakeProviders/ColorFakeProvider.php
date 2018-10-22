<?php

namespace App\Helpers\FakeProviders;

class ColorFakeProvider extends \Faker\Provider\Base
{
    private $list = [
        'Amber',
        'Amethyst',
        'Apricot',
        'Aqua',
        'Aquamarine',
        'Auburn',
        'Azure',
        'Beige',
        'Bistre',
        'Black',
        'Blue',
        'Brass',
        'Bronze',
        'Brown',
        'Burgundy',
        'Carmine',
        'Charcoal',
        'Chestnut',
        'Chocolate',
        'Cobalt',
        'Copper',
        'Coral',
        'Cream',
        'Crimson',
        'Cyan',
        'Dandelion',
        'Denim',
        'Emerald',
        'Gold',
        'Green',
        'Grey',
        'Indigo',
        'Ivory',
        'Jade',
        'Khaki',
        'Lavender',
        'Lemon',
        'Lilac',
        'Lime',
        'Magenta',
        'Magnolia',
        'Maroon',
        'Mustard',
        'Olive',
        'Orange',
        'Peach',
        'Pear',
        'Pink',
        'Platinum',
        'Purple',
        'Red',
        'Salmon',
        'Sapphire',
        'Scarlet',
        'Silver',
        'Teal',
        'Turquoise',
        'Violet',
        'White',
        'Yellow',
    ];

    public function color()
    {
        return $this->list[rand(0, count($this->list) - 1)];
    }
}