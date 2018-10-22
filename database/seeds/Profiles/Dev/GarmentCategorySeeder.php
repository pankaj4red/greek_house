<?php

class GarmentCategorySeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @param bool $addImages
     * @return void
     */
    public function run($addImages = false)
    {
        $categories = include(database_path('seeds/Data/Seed/garment_categories.php'));
        foreach ($categories as $category) {
            $category['image_id'] = $addImages ? $this->createFileFromSVG($category['image'])->id : 1;
            unset($category['image']);

            factory(\App\Models\GarmentCategory::class)->create($category);
        }
    }
}