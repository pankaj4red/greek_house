<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\CampaignSupply::class, function (Faker\Generator $faker) {
    return [
        'quantity'   => rand(1, 100),
        'total'      => rand(100, 100000) / 100,
        'ship_from'  => $faker->city,
        'eta'        => $faker->date('Y-m-d'),
        'state'      => 'new',
        'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
    ];
});
