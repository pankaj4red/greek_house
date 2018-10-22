<?php

class GarmentGenderSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @param bool $addImages
     * @return void
     */
    public function run($addImages = false)
    {
        $genders = include(database_path('seeds/Data/Seed/garment_genders.php'));
        foreach ($genders as $gender) {
            $gender['image_id'] = $addImages ? $this->createFileFromSVG($gender['image'])->id : 1;
            unset($gender['image']);

            factory(\App\Models\GarmentGender::class)->create($gender);
        }
    }
}