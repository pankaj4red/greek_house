<?php

$registerCssList = [];
function register_css($src)
{
    global $registerCssList;
    if (is_null($registerCssList)) {
        $registerCssList = [];
    }
    if (! in_array($src, $registerCssList)) {
        $registerCssList[] = $src;
    }
}

function output_css()
{
    global $registerCssList;
    if (is_null($registerCssList)) {
        $registerCssList = [];
    }
    $text = '';
    foreach ($registerCssList as $file) {
        $text .= '<link rel="stylesheet" href="'.$file.'" type="text/css" />';
    }

    return $text;
}

$registerJsList = [];
function register_js($src)
{
    global $registerJsList;
    if (is_null($registerJsList)) {
        $registerJsList = [];
    }
    if (! in_array($src, $registerJsList)) {
        $registerJsList[] = $src;
    }
}

function output_js()
{
    global $registerJsList;
    if (is_null($registerJsList)) {
        $registerJsList = [];
    }
    $text = '';
    foreach ($registerJsList as $file) {
        /** @noinspection HtmlUnknownTarget */
        $text .= str_replace('%1', $file, '<script src="%1"></script>');
    }

    return $text;
}

