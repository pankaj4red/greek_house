<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string  $image
 * @property string  $url
 * @property string  $page
 * @property integer $priority
 */
class SliderImages extends Model
{
    protected $table = 'slider_images';

    protected $guarded = [];

    protected $dates = [];

    protected $hidden = [];
}
