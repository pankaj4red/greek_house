<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\CampaignLead::class, function (Faker\Generator $faker) {
    return [
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ];
});

$factory->state(App\Models\CampaignLead::class, 'step1', function (Faker\Generator $faker) {
    return [

    ];
});

$factory->state(App\Models\CampaignLead::class, 'step2', function (Faker\Generator $faker) {
    return [
        'gender_id' => garment_gender_repository()->first()->id,
    ];
});

$factory->state(App\Models\CampaignLead::class, 'step3', function (Faker\Generator $faker) {
    return array_merge(factory(\App\Models\CampaignLead::class)->states('step2')->raw(), [
        'category_id' => garment_category_repository()->first()->id,
    ]);
});

$factory->state(App\Models\CampaignLead::class, 'step4', function (Faker\Generator $faker) {
    return array_merge(factory(\App\Models\CampaignLead::class)->states('step3')->raw(), [
        'product_id' => product_repository()->getEligibleForFreeProduct()->first()->id,
    ]);
});

$factory->state(App\Models\CampaignLead::class, 'step5', function (Faker\Generator $faker) {
    return array_merge(factory(\App\Models\CampaignLead::class)->states('step4')->raw(), [
        'color_id' => product_repository()->getEligibleForFreeProduct()->first()->colors->first()->id,
    ]);
});

$factory->state(App\Models\CampaignLead::class, 'step6', function (Faker\Generator $faker) {
    return array_merge(factory(\App\Models\CampaignLead::class)->states('step5')->raw(), [
        'name'                    => $faker->chapter,
        'design_style_preference' => 'realistic_sketch',
        'print_front'             => true,
        'print_front_description' => $faker->text,
        'print_front_colors'      => rand(1, 6),
        'design_type'             => 'screen',
        'estimated_quantity'      => '48-71',
        'size_short'              => 'S',
        'image1_id'               => 1,
        'image2_id'               => 2,
        'image3_id'               => 3,
    ]);
});

$factory->state(App\Models\CampaignLead::class, 'step7', function (Faker\Generator $faker) {
    return array_merge(factory(\App\Models\CampaignLead::class)->states('step6')->raw(), [
        'flexible' => 'yes',
    ]);
});

$factory->state(App\Models\CampaignLead::class, 'step8', function (Faker\Generator $faker) {
    return array_merge(factory(\App\Models\CampaignLead::class)->states('step7')->raw(), [
        'contact_first_name' => $faker->firstName,
        'contact_last_name'  => $faker->lastName,
        'contact_email'      => $faker->email,
        'contact_phone'      => '(555) 555-5555',
        'contact_school'     => 'Generic State College',
        'contact_chapter'    => $faker->chapter,
        'promo_code'         => $faker->word,
    ]);
});

$factory->state(App\Models\CampaignLead::class, 'review', function (Faker\Generator $faker) {
    return array_merge(factory(\App\Models\CampaignLead::class)->states('step8')->raw(), [
        'address_save'     => true,
        'address_name'     => $faker->address_name,
        'address_line1'    => $faker->streetName,
        'address_line2'    => $faker->buildingNumber,
        'address_city'     => $faker->city,
        'address_state'    => $faker->us_state['short'],
        'address_zip_code' => rand(10000, 99999),
        'address_country'  => 'usa',
    ]);
});


