<?php

function files_path($path)
{
    return 'files/'.$path;
}

function unique_filename($extension = '')
{
    return uniqid('', true).($extension ? ('.'.$extension) : '');
}

function save_file($content)
{
    $filename = unique_filename();
    \Storage::disk('files')->put(files_path($filename), $content);

    return $filename;
}

function cache_image($id, $content)
{
    try {
        Storage::disk('public_images')->put($id.'.png', $content);
        //Storage::disk('public_images')->put($id . '.png', (App::make(ImageOptimizer::class)->optimizeImage(config('filesystems.disks.public_images.root') . '/' . $id . '.png')));
    } catch (Exception $ex) {
        // ignore
    }
}

function get_file_contents($filename)
{
    if (Storage::disk('files')->exists(files_path($filename))) {
        $content = Storage::disk('files')->get(files_path($filename));
    } else {
        $content = Storage::disk('images')->get('not_available.png');
    }

    return $content;
}

function get_image($image)
{
    if ($image) {
        return $image;
    } else {
        return file_get_contents(getcwd().'/images/blank.png');
    }
}

function file_size($size)
{
    $units = ['B', 'KB', 'MB'];
    $unit = 0;
    for ($i = 0; $i < count($units) && $size >= 1024; $i++) {
        $size = $size / 1024;
        $unit++;
    }

    return round($size, 2).$units[$unit];
}

function is_image($filename)
{
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    return in_array($extension, ['gif', 'png', 'jpg', 'jpeg']);
}