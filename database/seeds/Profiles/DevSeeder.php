<?php

class DevSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = config('greekhouse.seeder.include_images');

        (new BasicSeeder())->run();

        if (! $images) {
            factory(App\Models\File::class)->create([
                'id'                => 1,
                'name'              => 'null.png',
                'size'              => 0,
                'type'              => 'image',
                'sub_type'          => 'image',
                'mime_type'         => 'image/png',
                'internal_filename' => null,
            ]);
        }

        (new SchoolChapterSeeder())->run();
        (new SupplierSeeder())->run();
        (new GarmentBrandSeeder())->run();
        (new GarmentGenderSeeder())->run($images);
        (new GarmentCategorySeeder())->run($images);
        (new GarmentSizeSeeder())->run();
        (new ProductSeeder())->run($images);
        (new UserSeeder())->run($images);
        (new DesignSeeder())->run($images);
        (new CampaignSeeder())->run($images);
        (new CartSeeder())->run($images);
    }
}
