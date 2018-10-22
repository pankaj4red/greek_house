<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\DesignFile::class, function (Faker\Generator $faker) {

    return [
        'type'    => 'image',
        'file_id' => null,
    ];
});

