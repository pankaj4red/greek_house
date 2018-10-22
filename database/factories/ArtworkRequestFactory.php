<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\ArtworkRequest::class, function (Faker\Generator $faker) {
    return [
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ];
});
