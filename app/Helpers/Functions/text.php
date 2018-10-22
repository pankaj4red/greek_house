<?php

function commafy_tags($tags)
{
    $text = '';
    foreach ($tags as $tag) {
        $text .= $tag->name.',';
    }

    return mb_substr($text, 0, mb_strlen($text) - 1);
}

function decommify($text)
{
    $tags = explode(',', $text);
    foreach ($tags as $key => $value) {
        $tags[$key] = trim($value);
        if (empty($tags[$key])) {
            unset($tags[$key]);
        }
    }

    return array_values($tags);
}

function bbcode($text)
{
    $text = linkify($text);
    $xml = \s9e\TextFormatter\Bundles\Forum::parse($text);
    $html = \s9e\TextFormatter\Bundles\Forum::render($xml);

    return $html;
}

function money($number)
{
    return '$'.number_format($number, 2);
}

function human_bytes($bytes)
{
    $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

    for ($i = 0; $bytes > 1024; $i++) {
        $bytes /= 1024;
    }

    return round($bytes, 2).' '.$units[$i];
}

function alphanumeric_random($length = 20)
{
    $string = '';
    do {
        $string .= md5(microtime());
    } while (mb_strlen($string) < $length);

    return mb_substr($string, 0, $length);
}

function sanitize_zip_code($zipCode)
{
    if ($zipCode === null) {
        return '00000';
    }
    $zipCode = (string) $zipCode;
    $zipCode = str_replace('_', '0', $zipCode);
    if (str_contains($zipCode, '-')) {
        $zipCode = explode('-', $zipCode)[0];
    }
    if (! is_numeric($zipCode)) {
        return '00000';
    }
    if (str_contains($zipCode, '.')) {
        $zipCode = explode('.', $zipCode)[0];
    }
    if (mb_strlen($zipCode) < 5) {
        $zipCode = str_pad($zipCode, 5, '0', STR_PAD_LEFT);
    }
    if (mb_strlen($zipCode) > 5) {
        $zipCode = mb_substr($zipCode, 0, 5);
    }

    return $zipCode;
}

function str_clean($text)
{
    while (str_contains($text, '  ')) {
        $text = str_replace('  ', ' ', $text);
    }

    return trim($text);
}

function school_keywords($name)
{
    $name = strtolower($name);
    $name = str_replace([',', ' of ', ' at ', ' in ', ' on '], ['', ' ', ' ', ' ', ' '], $name);
    $name = str_replace('  ', ' ', $name);

    return explode(' ', $name);
}

function get_phone_digits($phone, $alwaysReturn = false)
{
    $result = preg_match_all('!\d+!', $phone, $matches);
    if ($result) {
        return implode('', $matches[0]);
    }

    return $alwaysReturn ? $phone : false;
}

function get_phone($phone, $alwaysReturn = false)
{
    $phoneDigits = get_phone_digits($phone);
    if ($phoneDigits == false || strlen($phoneDigits) != 10) {
        return $alwaysReturn ? $phone : false;
    }

    return '('.substr($phoneDigits, 0, 3).') '.substr($phoneDigits, 3, 3).'-'.substr($phoneDigits, 6, 4);
}

function short_message($message, $length = 100, $replacement = '...')
{
    if (mb_strlen($message) > $length) {
        return mb_substr($message, 0, $length - mb_strlen($replacement)).$replacement;
    } else {
        return $message;
    }
}

function bb_links($text)
{
    /** @noinspection HtmlUnknownTarget */
    return preg_replace('@\[url=([^]]*)\]([^[]*)\[/url\]@', '<a href="$1" target="_blank">$2</a>', $text);
}

function process_text($text)
{
    return nl2br(bb_links(linkify(htmlentities($text))));
}

function alphafy($text)
{
    return preg_replace('/[^a-zA-Z0-9]+/', ' ', $text);
}

function linkify($text)
{
    /** @noinspection HtmlUnknownTarget */
    //$text = preg_replace('/([a-zA-Z0-9\.\:\-_]+\.(org|com|info|me|net)[a-zA-Z0-9\&\.\/\?\:@\-_=#]*)/', 'http://$1', $text);
    //$text = preg_replace('/:\/\/([a-zA-Z0-9]+):\/\//', '://', $text);

    return $text;
}

function getFullName($firstName, $lastName, $fallback = null)
{
    if (empty(trim(trim($firstName).' '.trim($lastName)))) {
        return $fallback ? $fallback : '';
    }

    return trim(trim($firstName).' '.trim($lastName));
}

function to_camel($name)
{
    $parts = explode('_', $name);
    $final = '';
    foreach ($parts as $part) {
        $final .= ucfirst($part);
    }

    return $final;
}

function number($number)
{
    return number_format($number, 0, '.', ',');
}

function first_last_name($name)
{
    $names = explode(' ', $name);
    $firstName = $names[0];
    $lastName = '-';
    if (count($names) > 1) {
        $lastName = implode(' ', array_splice($names, 1, count($names) - 1));
    }

    return (object) [
        'first' => $firstName,
        'last'  => $lastName,
    ];
}

function escape_entities($text)
{
    $text = htmlentities($text, ENT_QUOTES | ENT_IGNORE);
    $text = mb_str_replace(['&rsquo;', '&reg;', '&trade;'], ['’', '®', '™'], $text);
    $text = preg_replace('/&amp;([a-z]+);/', '&$1;', $text);

    return $text;
}

function format_json($json)
{
    $result = '';
    $pos = 0;
    $strLen = strlen($json);
    $indentStr = '  ';
    $newLine = "\n";
    $prevChar = '';
    $outOfQuotes = true;

    for ($i = 0; $i <= $strLen; $i++) {

        // Grab the next character in the string.
        $char = substr($json, $i, 1);

        // Are we inside a quoted string?
        if ($char == '"' && $prevChar != '\\') {
            $outOfQuotes = ! $outOfQuotes;

            // If this character is the end of an element,
            // output a new line and indent the next line.
        } else {
            if (($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos--;
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
        }

        // Add the character to the result string.
        $result .= $char;

        // If the last character was the beginning of an element,
        // output a new line and indent the next line.
        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos++;
            }

            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }

        $prevChar = $char;
    }

    return $result;
}

function add_url_scheme($link)
{
    $scheme = parse_url($link, PHP_URL_SCHEME);
    if (empty($scheme)) {
        $link = 'http://'.ltrim($link, '/');
    }

    return $link;
}