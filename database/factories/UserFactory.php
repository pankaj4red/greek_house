<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'username'        => $faker->name,
        'first_name'      => $faker->firstName,
        'last_name'       => $faker->lastName,
        'email'           => $faker->email,
        'phone'           => '(555) 555-5555',
        'school'          => 'Generic State College',
        'chapter'         => 'Zhi Beta Gama',
        'password'        => '$2a$05$WP28hjrY9o2E4PdiZzLqveaRmFE4rrCrBGuIxWnGwQkgwQ7wqF6xm',
        'remember_token'  => str_random(10),
        'type_code'       => 'customer',
        'activation_code' => '',
        'created_at'      => \Carbon\Carbon::now(),
        'updated_at'      => \Carbon\Carbon::now(),
    ];
});

$factory->state(App\Models\User::class, 'customer', function (Faker\Generator $faker) {
    return [
        'type_code' => 'customer',
    ];
});

$factory->state(App\Models\User::class, 'account_manager', function (Faker\Generator $faker) {
    return [
        'type_code' => 'account_manager',
    ];
});

$factory->state(App\Models\User::class, 'sales_rep', function (Faker\Generator $faker) {
    return [
        'type_code'      => 'sales_rep',
        'school_year'    => 'sophomore',
        'venmo_username' => 'venmo',
    ];
});

$factory->state(App\Models\User::class, 'support', function (Faker\Generator $faker) {
    return [
        'type_code' => 'support',
    ];
});

$factory->state(App\Models\User::class, 'designer', function (Faker\Generator $faker) {
    return [
        'type_code'   => 'designer',
        'hourly_rate' => 15.00,
    ];
});

$factory->state(App\Models\User::class, 'junior_designer', function (Faker\Generator $faker) {
    return [
        'type_code'   => 'junior_designer',
        'hourly_rate' => 15.00,
    ];
});

$factory->state(App\Models\User::class, 'customer', function (Faker\Generator $faker) {
    return [
        'type_code' => 'customer',
    ];
});

$factory->state(App\Models\User::class, 'art_director', function (Faker\Generator $faker) {
    return [
        'type_code' => 'art_director',
    ];
});

$factory->state(App\Models\User::class, 'decorator', function (Faker\Generator $faker) {
    return [
        'type_code' => 'decorator',
    ];
});

$factory->state(App\Models\User::class, 'product_qa', function (Faker\Generator $faker) {
    return [
        'type_code' => 'product_qa',
    ];
});

$factory->state(App\Models\User::class, 'product_manager', function (Faker\Generator $faker) {
    return [
        'type_code' => 'product_manager',
    ];
});

$factory->state(App\Models\User::class, 'admin', function (Faker\Generator $faker) {
    return [
        'type_code' => 'admin',
    ];
});

