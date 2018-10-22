<?php

namespace App\Helpers;

class FileHandler
{
    public function getContent($url)
    {
        return file_get_contents($url);
    }

    public function getRemoteSize($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        curl_close($ch);
        if (preg_match('/Content-Length: (\d+)/', $data, $matches)) {
            return (int) $matches[1];
        }

        return 0;
    }
}