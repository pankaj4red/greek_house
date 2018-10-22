<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\OrderEntry::class, function (Faker\Generator $faker) {
    $price = rand(1000, 2000) / 100;
    $quantity = rand(1, 20);
    $subtotal = $price * $quantity;

    return [
        'order_id'        => 0,
        'garment_size_id' => 0,
        'quantity'        => $quantity,
        'price'           => $price,
        'subtotal'        => $subtotal,
        'created_at'      => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at'      => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
    ];
});



