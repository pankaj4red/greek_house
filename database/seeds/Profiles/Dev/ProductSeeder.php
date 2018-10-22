<?php

class ProductSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @param bool $addImages
     * @return void
     */
    public function run($addImages = false)
    {
        $colors = collect(include(database_path('seeds/Data/Seed/colors.php')));
        $garmentSizes = collect(include(database_path('seeds/Data/Seed/garment_sizes.php')));

        $products = include(database_path('seeds/Data/Seed/products.php'));
        foreach ($products as $product) {
            $productImagePath = $product['image'];
            $product['image_id'] = $addImages ? $this->createFileFromSVG($productImagePath)->id : 1;
            unset($product['image']);

            $sizes = $product['sizes'];
            unset($product['sizes']);

            $model = factory(\App\Models\Product::class)->create($product);

            foreach ($sizes as $size) {
                factory(\App\Models\ProductSize::class)->create([
                    'product_id'      => $model->id,
                    'garment_size_id' => $garmentSizes->where('short', $size)->first()['id'],
                ]);
            }

            foreach ($colors as $color) {
                if ($addImages) {
                    $thumbnail = Image::canvas(24, 24);
                    $thumbnail->fill($color['color']);
                    $thumbnailFile = $this->createFileFromImage($thumbnail);

                    $imageFile = $this->createFileFromSVGAndColor($productImagePath, $color['color'], 600, 600);
                }

                factory(\App\Models\ProductColor::class)->create([
                    'product_id'   => $model->id,
                    'name'         => $color['name'],
                    'image_id'     => $addImages ? $imageFile->id : 1,
                    'thumbnail_id' => $addImages ? $thumbnailFile->id : 1,
                ]);
            }
        }
    }
}