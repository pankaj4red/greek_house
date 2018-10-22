<?php

class GarmentSizeSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = include(database_path('seeds/Data/Seed/garment_sizes.php'));
        foreach ($sizes as $size) {
            factory(\App\Models\GarmentSize::class)->create($size);
        }
    }
}
