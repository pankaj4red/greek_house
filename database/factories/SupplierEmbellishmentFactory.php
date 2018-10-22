<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\SupplierEmbellishment::class, function (Faker\Generator $faker) {
    return [
        'supplier_id'   => null,
        'embellishment' => rand(0, 1) ? 'screen' : 'embroidery',
        'created_at'    => \Carbon\Carbon::now(),
        'updated_at'    => \Carbon\Carbon::now(),
    ];
});


