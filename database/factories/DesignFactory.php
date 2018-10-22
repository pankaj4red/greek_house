<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\Design::class, function (Faker\Generator $faker) {

    return [
        'name'         => $faker->image_filename,
        'status'       => 'enabled',
        'thumbnail_id' => null,
        'created_at'   => \Carbon\Carbon::now(),
        'updated_at'   => \Carbon\Carbon::now(),
    ];
});

$factory->state(App\Models\Design::class, 'fake', function (Faker\Generator $faker) {

    return [
        'name'         => $faker->chapter,
        'thumbnail_id' => null,
    ];
});

