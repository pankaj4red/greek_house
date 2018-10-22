<?php

namespace App\Helpers;

use Image;
use Intervention\Image\Constraint;

class ImageHandler
{
    public function getContent($url, $width, $height)
    {
        return (string) (Image::make($url)->resize($width, $height, function (Constraint $constraint) {
            $constraint->aspectRatio();
        })->encode('png'));
    }

    public function getLocalContent($filename, $width, $height)
    {
        return (string) (Image::make(get_file_contents($filename))->resize($width, $height, function (Constraint $constraint) {
            $constraint->aspectRatio();
        })->encode('png'));
    }
}