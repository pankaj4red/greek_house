<?php

namespace App\Helpers\FakeProviders;

class SkuFakeProvider extends \Faker\Provider\Base
{
    public function sku($suffix = '')
    {
        return str_random(8);
    }
}