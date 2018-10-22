<?php

namespace App\Models;

use Approached\LaravelImageOptimizer\ImageOptimizer;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Image;
use Storage;

/**
 * @property integer $id
 * @property string  $name
 * @property string  $internal_filename
 * @property integer $size
 * @property string  $type
 * @property string  $sub_type
 * @property integer $image_id
 * @property string  $mime_type
 * @property integer $content_id
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 * @mixin \Eloquent
 */
class File extends Model
{
    use SoftDeletes;

    protected $table = 'files';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['content'];

    /**
     * @return object
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getContent($watermark = false)
    {

        $extension = strtolower(pathinfo($this->name, PATHINFO_EXTENSION));
        if (in_array($extension, ['jpg', 'png', '.gif']) == 'image') {

            $imageName = $this->id;
            if ($watermark) {
                $imageName = $this->id.'_wm';
            }

            if (! Storage::disk('public_images')->exists($imageName.'.png')) {
                $content = get_file_contents($this->internal_filename);
                cache_image($imageName, $content);
            }

            if ($watermark) {
                $img = Image::make(Storage::disk('public_images')->get($imageName.'.png'));

                //Create watermark, resize watermark to original image size
                $watermark = Image::make(Storage::disk('images')->get('watermark.png'));
                $watermark->resize($img->width(), $img->height());

                $imageText = '';

                $designId = design_repository()->getRelatedDesignId($this->id);

                if ($designId->count() > 0) {
                    $imageText = $designId->first()->id;
                }

                //Create id number, lower right corner
                $img->text($imageText, $img->width() - 30, $img->height() - 10, function ($font) {
                    $font->size(12);
                    $font->color([255, 255, 255, 0.3]);
                    $font->align('right');
                });
                //Insert watermark, only after text
                $img->insert($watermark);

                cache_image($imageName, (string) $img->encode('png'));
            }

            return (object) [
                'content' => Storage::disk('public_images')->get($imageName.'.png'),
            ];
        }

        if (! Storage::disk('local')->exists(files_path($this->internal_filename))) {
            Storage::disk('local')->put(files_path($this->internal_filename), Storage::disk('files')->get(files_path($this->internal_filename)));
        }

        return (object) [
            'content' => Storage::disk('local')->get(files_path($this->internal_filename)),
        ];
    }

    public function cacheContent()
    {
        $extension = strtolower(pathinfo($this->name, PATHINFO_EXTENSION));
        if (in_array($extension, ['jpg', 'png', '.gif']) == 'image') {
            if (! Storage::disk('public_images')->exists($this->id.'.png')) {
                Storage::disk('public_images')->put($this->id.'.png', Storage::disk('files')->get(files_path($this->internal_filename)));
                try {
                    \App::make(ImageOptimizer::class)->optimizeImage(config('filesystems.disks.public_images.root').'/'.$this->id.'.png');
                } catch (Exception $ex) {
                    // ignore
                }
            }

            return;
        }

        if (! Storage::disk('local')->exists(files_path($this->internal_filename))) {
            Storage::disk('local')->put(files_path($this->internal_filename), Storage::disk('files')->get(files_path($this->internal_filename)));
        }
    }
}
