<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\ArtworkRequestFile::class, function (Faker\Generator $faker) {
    return [
        'artwork_request_id' => 0,
        'file_id'            => rand(1, 6),
        'sort'               => rand(1, 6),
        'type'               => 'proof',
        'created_at'         => \Carbon\Carbon::now(),
        'updated_at'         => \Carbon\Carbon::now(),
    ];
});
