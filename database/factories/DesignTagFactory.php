<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\DesignTag::class, function (Faker\Generator $faker) {
    return [
        'group' => 'themes',
        'name'  => $faker->tag,
    ];
});

$factory->state(App\Models\DesignTag::class, 'general', function (Faker\Generator $faker) {
    return [
        'group' => 'general',
        'name'  => $faker->design_tag_general,
    ];
});

$factory->state(App\Models\DesignTag::class, 'themes', function (Faker\Generator $faker) {
    return [
        'group' => 'themes',
        'name'  => $faker->design_tag_themes,
    ];
});

$factory->state(App\Models\DesignTag::class, 'event', function (Faker\Generator $faker) {
    return [
        'group' => 'event',
        'name'  => $faker->design_tag_event,
    ];
});

$factory->state(App\Models\DesignTag::class, 'college', function (Faker\Generator $faker) {
    return [
        'group' => 'college',
        'name'  => $faker->design_tag_college,
    ];
});

$factory->state(App\Models\DesignTag::class, 'chapter', function (Faker\Generator $faker) {
    return [
        'group' => 'chapter',
        'name'  => $faker->design_tag_chapter,
    ];
});

$factory->state(App\Models\DesignTag::class, 'product_type', function (Faker\Generator $faker) {
    return [
        'group' => 'product_type',
        'name'  => $faker->design_tag_product_type,
    ];
});
