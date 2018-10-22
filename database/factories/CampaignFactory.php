<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\Campaign::class, function (Faker\Generator $faker) {
    return [
        'name'               => $faker->chapter,
        'flexible'           => 'yes',
        'contact_first_name' => $faker->firstName,
        'contact_last_name'  => $faker->lastName,
        'contact_email'      => $faker->email,
        'contact_phone'      => '(555) 555-5555',
        'contact_school'     => 'Generic State College',
        'contact_chapter'    => $faker->chapter,
        'address_name'       => $faker->company,
        'address_line1'      => $faker->streetName,
        'address_line2'      => $faker->buildingNumber,
        'address_city'       => $faker->city,
        'address_state'      => $faker->us_state['short'],
        'address_zip_code'   => rand(10000, 99999),
        'address_country'    => 'usa',
        'estimated_quantity' => '48-71',
        'promo_code'         => $faker->word,
        'state'              => 'awaiting_design',
        'quote_low'          => null,
        'quote_high'         => null,
        'quote_final'        => null,
        'scheduled_date'     => null,
        'on_hold_category'   => null,
        'on_hold_rule'       => null,
        'budget'             => 'no',
        'budget_range'       => null,
        'created_at'         => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at'         => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
    ];
});

$factory->state(App\Models\Campaign::class, 'flexible', function (Faker\Generator $faker) {
    return [
        'flexible' => 'yes',
        'date'     => null,
        'rush'     => false,
    ];
});

$factory->state(App\Models\Campaign::class, 'non_flexible', function (Faker\Generator $faker) {
    return [
        'flexible' => 'no',
        'date'     => \Carbon\Carbon::parse('+20 weekdays'),
        'rush'     => false,
    ];
});

$factory->state(App\Models\Campaign::class, 'rush', function (Faker\Generator $faker) {
    return [
        'flexible' => 'no',
        'date'     => \Carbon\Carbon::parse('+12 weekdays'),
        'rush'     => true,
    ];
});


