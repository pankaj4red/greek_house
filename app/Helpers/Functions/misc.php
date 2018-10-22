<?php

function reference($reference, $index)
{
    $indexes = explode('.', $index);
    for ($i = 0; $i < count($indexes); $i++) {
        $index = $indexes[$i];
        if ($i < count($indexes) - 1) {
            if ($index == 'first()') {
                /** @noinspection PhpUndefinedMethodInspection */
                $reference = $reference->first();
                continue;
            }
            $reference = $reference->$index;
            continue;
        }
        $reference = $reference[$index];
    }

    return $reference;
}

function range_to_number($range)
{
    if (is_numeric($range)) {
        return $range;
    }

    if ($range === null) {
        return null;
    }

    if (preg_match('/^(\d+)-(\d+)$/', $range, $matches)) {
        return $matches[1];
    }

    if (preg_match('/^(\d+)\+$/', $range, $matches)) {
        return $matches[1];
    }

    return $range;
}

function equals($value1, $value2)
{
    if (is_string($value1)) {
        $value1 = strtolower(trim($value1));
    }

    if (is_string($value2)) {
        $value2 = strtolower(trim($value2));
    }

    if (empty($value1) && empty($value2)) {
        return true;
    }

    if (is_double($value1) && is_double($value2)) {
        if ((string) $value1 === (string) $value2) {
            return true;
        }

        return false;
    }

    return $value1 == $value2;
}

function seconds_to_days($seconds)
{
    if ($seconds === null) {
        return 0;
    }

    return floor(100 * $seconds / 60 / 60 / 24) / 100;
}

function to_hours($minutes)
{
    $hours = floor($minutes / 60);
    $minutes = floor($minutes % 60);

    return $hours.':'.str_pad($minutes, 2, '0', STR_PAD_LEFT);
}

function to_minutes($hours)
{
    if (preg_match('/^([0-9]+):([0-9]{1,2})$/', $hours, $matches)) {
        return ($matches[1] * 60) + $matches[2];
    } else {
        return intval($hours) * 60;
    }
}

function product_to_description($id, $name = null)
{
    if ($name == null) {
        $campaign = App::make(App\Repositories\Models\CampaignRepository::class)->find($id);
        if ($campaign == null) {
            abort(404);
        }
        $name = $campaign->name;
    }
    $description = str_replace([' ', '/', '#', '?'], ['-', '-', '', ''], $name);
    $description .= '-'.$id;

    return $description;
}

function get_cart_counter()
{
    $cart = null;
    if (Session::has('cart_id')) {
        $cart = cart_repository()->find(Session::get('cart_id'));
    }

    if (! $cart) {
        return 0;
    }

    $counter = 0;
    foreach ($cart->orders as $order) {
        if ($order->state == 'new') {
            foreach ($order->entries as $entry) {
                $counter += $entry->quantity;
            }
        }
    }

    return $counter;
}

function get_product_id_from_description($description)
{
    preg_match('/-(\d+)$/', $description, $matches);
    if (isset($matches[1])) {
        return intval($matches[1]);
    }
    if (is_numeric($description)) {
        return (int) $description;
    }

    return null;
}

function get_category_id_from_description($description)
{
    return get_product_id_from_description($description);
}

function get_image_id($id, $watermark = false)
{
    return $id;
}

function category_to_url($id, $name)
{

    $return = str_replace([' ', '/', '#'], ['-', '-', ''], $name);
    $return .= '-'.$id;

    return $return;
}

function print_r_reverse($in)
{
    $lines = explode("\n", trim($in));
    if (trim($lines[0]) != 'Array') {
        // bottomed out to something that isn't an array
        return $in;
    } else {
        // this is an array, lets parse it
        if (preg_match("/(\s{5,})\(/", $lines[1], $match)) {
            // this is a tested array/recursive call to this function
            // take a set of spaces off the beginning
            $spaces = $match[1];
            $spacesLength = strlen($spaces);
            $linesTotal = count($lines);
            for ($i = 0; $i < $linesTotal; $i++) {
                if (substr($lines[$i], 0, $spacesLength) == $spaces) {
                    $lines[$i] = substr($lines[$i], $spacesLength);
                }
            }
        }
        array_shift($lines); // Array
        array_shift($lines); // (
        array_pop($lines); // )
        $in = implode("\n", $lines);
        // make sure we only match stuff with 4 preceding spaces (stuff for this array and not a nested one)
        preg_match_all("/^\s{4}\[(.+?)\] \=\> /m", $in, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
        $pos = [];
        $previousKey = '';
        $inLength = strlen($in);
        // store the following in $pos:
        // array with key = key of the parsed array's item
        // value = array(start position in $in, $end position in $in)
        foreach ($matches as $match) {
            $key = $match[1][0];
            $start = $match[0][1] + strlen($match[0][0]);
            $pos[$key] = [$start, $inLength];
            if ($previousKey != '') {
                $pos[$previousKey][1] = $match[0][1] - 1;
            }
            $previousKey = $key;
        }
        $ret = [];
        foreach ($pos as $key => $where) {
            // recursively see if the parsed out value is an array too
            $ret[$key] = print_r_reverse(substr($in, $where[0], $where[1] - $where[0]));
        }

        return $ret;
    }
}

function size_list($productSizes)
{
    $sizes = [];
    foreach ($productSizes as $size) {
        $sizes[] = $size->size->short;
    }

    return implode(', ', $sizes);
}

function color_list($productColors)
{
    $colors = [];
    foreach ($productColors as $color) {
        $colors[] = [
            'id'        => $color->id,
            'name'      => $color->name,
            'thumbnail' => route('system::image', [$color->thumbnail_id]),
            'image'     => route('system::image', [$color->image_id]),
        ];
    }

    return $colors;
}

function loosely_equal($value1, $value2)
{
    // Compare floats
    if (is_float($value1) || is_float($value2)) {
        $value1 = ! is_null($value1) ? $value1 : 0;
        $value2 = ! is_null($value2) ? $value2 : 0;

        if (round($value1, 2) != round($value2, 2)) {
            return false;
        }

        return true;
    }

    // Compare strings
    if (is_string($value1) || is_string($value2)) {
        $value1 = ! is_null($value1) ? $value1 : '';
        $value2 = ! is_null($value2) ? $value2 : '';

        if (trim(mb_strtolower($value1)) != trim(mb_strtolower($value2))) {
            return false;
        }

        return true;
    }

    // Fallback
    return $value1 == $value2;
}

function query_build($parameters)
{
    $query = '';
    foreach ($parameters as $key => $value) {
        if (is_bool($value)) {
            if ($value) {
                if (! empty($query)) {
                    $query .= '&';
                }
                $query .= $key;
            }
        } elseif (! is_null($value)) {
            if (! empty($query)) {
                $query .= '&';
            }
            $query .= $key.'='.urlencode($value);
        }
    }

    return $query;
}

function product_color_products($productColors)
{
    $products = [];
    foreach ($productColors as $productColor) {
        if (! array_key_exists($productColor->product_id, $products)) {
            $products[$productColor->product_id] = $productColor->product;
            $products[$productColor->product_id]->campaign_colors = collect();
        }

        $products[$productColor->product_id]->campaign_colors->push($productColor);
    }

    return collect(array_values($products));
}

function wizard_url($baseUrl, $search = null, $gender = null)
{
    $queryString = [];
    if ($search) {
        $queryString[] = 'q='.urlencode($search);
    }
    if ($gender) {
        $queryString[] = 'g='.urlencode($gender);
    }

    return $baseUrl.(count($queryString) > 0 ? ('?'.implode('&', $queryString)) : '');
}

function is_search_match($text, $search)
{
    return search_strength($text, $search) > 0;
}

function search_strength($text, $search)
{
    $words = preg_split("/(?<=\w)\b\s*/", $search, -1, PREG_SPLIT_NO_EMPTY);
    $strength = 0;
    foreach ($words as $word) {
        if ((stripos($text, clean($word)) !== false) && strlen(clean($word)) > 1) {
            $strength++;
        }
    }

    return $strength;
}

function is_exact_match($text, $search)
{
    return ($text == $search);
}

function clean($string)
{
    // $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function add_business_days_to_date($date, $days)
{
    $d = new DateTime($date);
    $t = $d->getTimestamp();

    // loop for X days
    for ($i = 0; $i < $days; $i++) {

        // add 1 day to timestamp
        $addDay = 86400;

        // get what day it is next day
        $nextDay = date('w', ($t + $addDay));

        // if it's Saturday or Sunday get $i-1
        if ($nextDay == 0 || $nextDay == 6) {
            $i--;
        }

        // modify timestamp, add 1 day
        $t = $t + $addDay;
    }
    $d->setTimestamp($t);

    return $d->format('m/d/Y');
}

function subtract_business_days_from_date($date, $days)
{
    $d = new DateTime($date);
    $t = $d->getTimestamp();

    // loop for X days
    for ($i = 0; $i < $days; $i++) {

        // add 1 day to timestamp
        $addDay = 86400;

        // get what day it is next day
        $previousDay = date('w', ($t - $addDay));

        // if it's Saturday or Sunday get $i-1
        if ($previousDay == 0 || $previousDay == 6) {
            $i--;
        }

        // modify timestamp, add 1 day
        $t = $t - $addDay;
    }
    $d->setTimestamp($t);

    return $d->format('m/d/Y');
}

function campaign_product_proof_information(App\Models\Campaign $campaign, $productId = null)
{
    $campaignProductInformation = [];
    foreach (product_color_products($campaign->product_colors) as $product) {
        if ($productId && $product->id != $productId) {
            continue;
        }

        $productInformation = (object) [
            'id'     => $product->id,
            'name'   => $product->name,
            'colors' => [],
        ];

        foreach ($product->campaign_colors as $productColor) {
            $colorInformation = (object) [
                'id'     => $productColor->id,
                'name'   => $productColor->name,
                'image'  => route('system::image', [$productColor->thumbnail_id]),
                'proofs' => [],
            ];

            foreach ($campaign->artwork_request->getProofsFromProductColor($productColor->id) as $proof) {
                $colorInformation->proofs[] = (object) [
                    'id'    => $proof->id,
                    'image' => route('system::image', [$proof->file_id]),
                ];
            }

            $productInformation->colors[] = $colorInformation;
        }

        $campaignProductInformation[] = $productInformation;
    }

    return $campaignProductInformation;
}

function campaign_product_prices_information(App\Models\Campaign $campaign, $productId = null)
{
    $campaignProductInformation = [];
    foreach (product_color_products($campaign->product_colors) as $product) {
        if ($productId && $product->id != $productId) {
            continue;
        }

        $productInformation = (object) [
            'id'     => $product->id,
            'name'   => $product->name,
            'colors' => [],
            'price'  => round($campaign->quotes->where('product_id', $product->id)->first()->quote_high * 1.07, 2),
            'sizes'  => [],
        ];

        foreach ($product->campaign_colors as $productColor) {
            $colorInformation = (object) [
                'id'    => $productColor->id,
                'name'  => $productColor->name,
                'image' => route('system::image', [$campaign->artwork_request->getProofsFromProductColor($productColor->id)->first()->file_id]),
            ];

            $productInformation->colors[] = $colorInformation;
        }

        foreach ($product->sizes as $productSize) {
            $sizeInformation = (object) [
                'id'    => $productSize->id,
                'name'  => $productSize->size->short,
                'extra' => extra_size_charge($productSize->size->short),
            ];

            $productInformation->sizes[] = $sizeInformation;
        }

        $campaignProductInformation[] = $productInformation;
    }

    return $campaignProductInformation;
}
