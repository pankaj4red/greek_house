<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'name'                => $faker->product,
        'sku'                 => $faker->sku,
        'image_id'            => null,
        'active'              => true,
        'garment_brand_id'    => null,
        'garment_category_id' => null,
        'garment_gender_id'   => null,
        'description'         => $faker->lorem_ipsum(3),
        'sizes_text'          => $faker->lorem_ipsum(3),
        'style_number'        => $faker->word,
        'features'            => $faker->text(200),
        'price'               => $faker->randomFloat(2, 5, 15),
    ];
});


