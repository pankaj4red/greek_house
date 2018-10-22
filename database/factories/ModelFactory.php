<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\GarmentGender::class, function (Faker\Generator $faker) {
    return [
        'name'     => $faker->gender,
        'image_id' => null,
    ];
});

$factory->define(App\Models\GarmentCategory::class, function (Faker\Generator $faker) {
    return [
        'name'     => $faker->unique()->garment_category,
        'image_id' => null,
        'active'   => true,
    ];
});

$factory->define(App\Models\GarmentBrand::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->garment_brand,
    ];
});

$factory->define(App\Models\ProductColor::class, function (Faker\Generator $faker) {
    return [
        'product_id'   => null,
        'name'         => $faker->color,
        'thumbnail_id' => null,
        'image_id'     => null,
    ];
});

$factory->define(App\Models\GarmentSize::class, function (Faker\Generator $faker) {
    $size = $faker->size;

    return [
        'name'  => $size['name'],
        'short' => $size['short'],
    ];
});

$factory->define(App\Models\ProductSize::class, function (Faker\Generator $faker) {
    return [
        'product_id'      => null,
        'garment_size_id' => null,
    ];
});

$factory->define(App\Models\PasswordReset::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->email,
        'token' => $faker->randomNumber(10),
    ];
});
