<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\CampaignSupplyEntry::class, function (Faker\Generator $faker) {
    $quantity = rand(1, 100);
    $price = rand(100, 10000) / 100;
    $total = $quantity * $price;

    return [
        'quantity'   => $quantity,
        'subtotal'   => $total,
        'price'      => $price,
        'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
    ];
});
