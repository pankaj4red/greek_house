<?php

namespace App\Helpers\FakeProviders;

class FilenameFakeProvider extends \Faker\Provider\Base
{
    public function image_filename($suffix = '')
    {
        return md5(rand(0, 1000)).$suffix.'.png';
    }

    public function file_filename($suffix = '')
    {
        return md5(rand(0, 1000)).$suffix.'.txt';
    }
}