<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\File::class, function (Faker\Generator $faker) {
    return [
        'name'              => $faker->image_filename,
        'content_id'        => time(),
        'internal_filename' => uniqid(),
        'size'              => $faker->numberBetween(10000, 1000000),
        'type'              => 'image',
        'sub_type'          => 'image',
        'image_id'          => null,
        'mime_type'         => 'image/png',
        'created_at'        => \Carbon\Carbon::now(),
        'updated_at'        => \Carbon\Carbon::now(),
    ];
});

$factory->state(App\Models\File::class, 'image', function (Faker\Generator $faker) {
    return [

    ];
});

$factory->state(App\Models\File::class, 'file', function (Faker\Generator $faker) {
    return [
        'name'      => $faker->file_filename,
        'type'      => 'file',
        'sub_type'  => 'file',
        'image_id'  => null,
        'mime_type' => 'text',
    ];
});
