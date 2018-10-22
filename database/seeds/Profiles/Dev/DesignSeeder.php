<?php

class DesignSeeder extends BaseSeeder
{
    public $tags = [
        'general'      => ['Ball', 'Ski', 'Party'],
        'event'        => ['Mountain Weekend', 'Formal', 'Parents Weekend'],
        'themes'       => ['Beach', 'Holiday', 'Winter'],
        'college'      => ['Massachusetts Institute of Technology', 'University of Illinois', 'University of California'],
        'chapter'      => ['Alpha Chi Omega', 'Phi Alpha Delta', 'Beta Phi Omega'],
        'product_type' => ['Long Sleeves', 'Sweatshirts', 'Accessories'],
    ];

    /**
     * Run the database seeds.
     *
     * @param bool $addImages
     * @return void
     */
    public function run($addImages = false)
    {
        $designTemplate = include(database_path('seeds/Data/Seed/designs.php'));
        $designTemplate['thumbnail'] = $addImages ? $this->getImageFromSVG($designTemplate['thumbnail'], 600, 600) : 1;
        foreach ($designTemplate['images'] as $key => $imageTemplate) {
            $designTemplate['images'][$key]['image'] = $addImages ? $this->createFileFromSVG($imageTemplate['image'], 600, 600)->id : 1;
        }

        $i = 1;
        foreach ($this->tags['event'] as $event) {
            foreach ($this->tags['themes'] as $theme) {
                foreach ($this->tags['college'] as $college) {
                    foreach ($this->tags['chapter'] as $chapter) {
                        foreach ($this->tags['product_type'] as $productType) {
                            if ($addImages) {
                                $image = clone $designTemplate['thumbnail'];
                                $fontCallback = function ($font) {
                                    $font->file(public_path('fonts/rockwell.ttf'));
                                    $font->size(30);
                                    $font->color('#FF003F');
                                    $font->align('left');
                                    $font->valign('top');
                                };

                                $image->text('#'.$i, 30, 500, function ($font) {
                                    $font->file(public_path('fonts/rockwell.ttf'));
                                    $font->size(100);
                                    $font->color('#FF003F');
                                    $font->align('left');
                                    $font->valign('top');
                                });
                                $image->text('Event: '.$event, 40, 40, $fontCallback);
                                $image->text('Theme: '.$theme, 40, 80, $fontCallback);
                                $image->text('College: '.$college, 40, 120, $fontCallback);
                                $image->text('Chapter: '.$chapter, 40, 160, $fontCallback);
                                $image->text('Product Type: '.$productType, 40, 200, $fontCallback);
                                $image->text('General: '.$this->tags['general'][$i % 3], 40, 240, $fontCallback);
                                $thumbnailId = $this->createFileFromImage($image)->id;
                            }
                            $model = factory(\App\Models\Design::class)->create([
                                'name'         => $event.' '.$theme.' '.$chapter.' '.$i,
                                'code'         => 10000 + $i,
                                'trending'     => $i % 9 == 0 ? true : false,
                                'status'       => $i % 28 == 0 ? 'search' : ($i % 7 ? 'enabled' : 'disabled'),
                                'sort'         => $i,
                                'thumbnail_id' => $addImages ? $thumbnailId : 1,
                            ]);

                            // Tags
                            factory(\App\Models\DesignTag::class)->create([
                                'design_id' => $model->id,
                                'group'     => 'event',
                                'name'      => $event,
                            ]);
                            factory(\App\Models\DesignTag::class)->create([
                                'design_id' => $model->id,
                                'group'     => 'themes',
                                'name'      => $theme,
                            ]);
                            factory(\App\Models\DesignTag::class)->create([
                                'design_id' => $model->id,
                                'group'     => 'college',
                                'name'      => $college,
                            ]);
                            factory(\App\Models\DesignTag::class)->create([
                                'design_id' => $model->id,
                                'group'     => 'chapter',
                                'name'      => $chapter,
                            ]);
                            factory(\App\Models\DesignTag::class)->create([
                                'design_id' => $model->id,
                                'group'     => 'product_type',
                                'name'      => $productType,
                            ]);
                            factory(\App\Models\DesignTag::class)->create([
                                'design_id' => $model->id,
                                'group'     => 'general',
                                'name'      => $this->tags['general'][$i % 3],
                            ]);

                            // Images
                            foreach ($designTemplate['images'] as $key => $imageTemplate) {
                                factory(\App\Models\DesignFile::class)->create([
                                    'type'      => 'image',
                                    'design_id' => $model->id,
                                    'file_id'   => $addImages ? $imageTemplate['image'] : 1,
                                    'enabled'   => $imageTemplate['enabled'],
                                    'sort'      => $key,
                                ]);
                            }

                            $i++;
                        }
                    }
                }
            }
        }
    }
}