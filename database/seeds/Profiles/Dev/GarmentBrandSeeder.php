<?php

class GarmentBrandSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @param bool $addImages
     * @return void
     */
    public function run()
    {
        $brands = include(database_path('seeds/Data/Seed/garment_brands.php'));
        foreach ($brands as $brand) {
            factory(\App\Models\GarmentBrand::class)->create($brand);
        }
    }
}