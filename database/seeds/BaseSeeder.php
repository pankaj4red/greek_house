<?php

use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{
    public function clearFiles()
    {
        if (config('filesystems.disks.local.driver') == 'local') {
            echo "Deleting Files in local driver\r\n";
            $files = Storage::drive('public_images')->allFiles();
            foreach ($files as $file) {
                Storage::drive('public_images')->delete($file);
            }
        }

        if (config('filesystems.disks.files.driver') == 'local') {
            echo "Deleting Files in files driver\r\n";
            $files = Storage::drive('files')->allFiles('files');
            foreach ($files as $file) {
                Storage::drive('files')->delete($file);
            }
        }

        if (config('filesystems.disks.public.driver') == 'local') {
            echo "Deleting Files in public driver\r\n";
            $files = Storage::drive('public')->allFiles('image');
            foreach ($files as $file) {
                Storage::drive('public')->delete($file);
            }
        }
    }

    public function createFileFromSVG($path, $width = 600, $height = 600)
    {
        $image = $this->getImageFromSVG($path, $width, $height);

        return $this->createFileFromImage($image);
    }

    public function getImageFromSVG($path, $width = 600, $height = 600)
    {
        $image = Image::make($this->getSVGData(database_path('seeds/Data/Icons/'.$path)));
        $image->resize($width, $height);

        return $image;
    }

    public function createFileFromSVGAndColor($path, $color, $width = 600, $height = 600)
    {
        $image = $this->getImageFromSVG($path, $width, $height);
        $image->rectangle($width - $width / 3, $height - $height / 3, $width, $height, function ($draw) use ($color) {
            $draw->background($color);
        });

        return $this->createFileFromImage($image);
    }

    public function createFileFromImage($image)
    {
        $content = $image->encode('png');
        $image = file_repository()->make();
        $image->name = uniqid().'.png';
        $image->internal_filename = save_file($content);
        $image->type = 'image';
        $image->sub_type = 'png';
        $image->mime_type = 'image/png';
        $image->save();
        $imageId = $image->id;
        cache_image($imageId, $content);

        return $image;
    }

    public function getSVGData($path)
    {
        $data = mb_str_replace(["\r", "\n"], ['', ''], file_get_contents($path));
        $png = '';
        $descriptor = [0 => ["pipe", "r"], 1 => ["pipe", "w"]];
        $convert = proc_open("/usr/bin/convert svg:- png:-", $descriptor, $pipes);
        fwrite($pipes[0], $data);
        fclose($pipes[0]);
        while (! feof($pipes[1])) {
            $png .= fread($pipes[1], 1024);
        }
        fclose($pipes[1]);
        proc_close($convert);

        return $png;
    }
}