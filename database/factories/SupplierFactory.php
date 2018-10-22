<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\Supplier::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->company,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ];
});


