<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\Address::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->address_name,
        'line1'      => $faker->streetName,
        'line2'      => $faker->buildingNumber,
        'city'       => $faker->city,
        'state'      => $faker->us_state['short'],
        'zip_code'   => rand(10000, 99999),
        'country'    => 'usa',
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ];
});


