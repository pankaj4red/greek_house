<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {
    $price = rand(1000, 2000) / 100;
    $quantity = rand(1, 20);
    $subtotal = $price * $quantity;
    $tax = $subtotal * 0.065;

    return [
        'quantity'           => $quantity,
        'subtotal'           => $subtotal,
        'shipping'           => 0,
        'tax'                => $tax,
        'total'              => $subtotal + $tax,
        'state'              => 'new',
        'contact_first_name' => $faker->firstName,
        'contact_last_name'  => $faker->lastName,
        'contact_email'      => $faker->email,
        'contact_phone'      => '(555) 555-5555',
        'contact_school'     => 'Generic State College',
        'contact_chapter'    => $faker->chapter,
        'shipping_line1'     => $faker->streetName,
        'shipping_line2'     => $faker->buildingNumber,
        'shipping_city'      => $faker->city,
        'shipping_state'     => $faker->us_state['short'],
        'shipping_zip_code'  => rand(10000, 99999),
        'shipping_country'   => 'usa',
        'shipping_type'      => 'group',
        'payment_type'       => 'group',
        'billing_first_name' => $faker->firstName,
        'billing_last_name'  => $faker->lastName,
        'billing_line1'      => $faker->streetName,
        'billing_line2'      => $faker->buildingNumber,
        'billing_city'       => $faker->city,
        'billing_state'      => $faker->us_state['short'],
        'billing_zip_code'   => rand(10000, 99999),
        'billing_country'    => 'usa',
        'billing_provider'   => 'test',
        'created_at'         => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at'         => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
    ];
});

$factory->state(App\Models\Order::class, 'new', function (Faker\Generator $faker) {
    return [
        'state' => 'new',
    ];
});

$factory->state(App\Models\Order::class, 'success', function (Faker\Generator $faker) {
    return [
        'state' => 'success',
    ];
});

$factory->state(App\Models\Order::class, 'authorized', function (Faker\Generator $faker) {
    return [
        'state' => 'authorized',
    ];
});



