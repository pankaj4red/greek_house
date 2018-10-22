<?php

function collection_to_array($collection)
{
    $array = [];
    foreach ($collection as $entry) {
        $array[] = $entry;
    }

    return $array;
}

function sort_array($array, $sortingArray)
{
    $sortedArray = [];
    foreach ($sortingArray as $sortingEntry) {
        if (in_array($sortingEntry, $array)) {
            $sortedArray[] = $sortingEntry;
        }
    }
    foreach ($array as $arrayEntry) {
        if (! in_array($arrayEntry, $sortingArray)) {
            $sortedArray[] = $arrayEntry;
        }
    }

    return $sortedArray;
}

function is_array_assoc($array)
{
    if ($array == []) {
        return false;
    }

    return array_keys($array) !== range(0, count($array) - 1);
}

function array_less($new, $old)
{
    $result = [];
    foreach ($new as $key => $value) {
        if (! isset($old[$key]) || $old[$key] != $value) {
            $result[$key] = $value;
        }
    }

    return $result;
}

function to_array($mixed)
{
    if ($mixed !== null) {
        if (is_object($mixed)) {
            if (method_exists($mixed, 'toArray')) {
                $mixed = $mixed->toArray();
            } else {
                $mixed = (array) $mixed;
            }
        } elseif (is_array($mixed) == false) {
            $mixed = [$mixed];
        }
    }

    return $mixed;
}

function order_by($list, $path)
{
    $pathParts = explode('.', $path);
    $sorted = [];
    while (count($list) > 0) {
        $firstIndex = 0;
        for ($i = 1; $i < count($list); $i++) {
            $current = $list[$i];
            $first = $list[$firstIndex];
            for ($j = 0; $j < count($pathParts); $j++) {
                if (is_array($current)) {
                    $current = $current[$pathParts[$j]];
                    $first = $first[$pathParts[$j]];
                } else {
                    $current = $current->{$pathParts[$j]};
                    $first = $first->{$pathParts[$j]};
                }
            }
            if ($current < $first) {
                $firstIndex = $i;
            }
        }
        $sorted[] = array_splice($list, $firstIndex, 1)[0];
    }

    return $sorted;
}

function array_filter_by_keys($array, $keys)
{
    $result = [];

    foreach ($array as $key => $value) {
        if (in_array($key, $keys)) {
            $result[$key] = $value;
        }
    }

    return $result;
}

function sortOrderGroups($orderGroups)
{
    usort($orderGroups, function ($a, $b) {
        return strcmp($a['name'], $b['name']);
    });

    return $orderGroups;
}

function array_random_indexes($length, $count)
{
    $randomIndexes = [];

    $allIndexes = [];
    for ($i = 0; $i < $length; $i++) {
        $allIndexes[$i] = $i;
    }

    while (count($randomIndexes) < $count) {
        $indexEntry = array_values(array_splice($allIndexes, rand(0, count($allIndexes) - 1), 1));
        $randomIndexes[] = $indexEntry[0];
    }

    return $randomIndexes;
}

function array_equal($array1, $array2)
{
    if (count($array1) != count($array2)) {
        return false;
    }

    foreach ($array1 as $key => $value) {
        if (! isset($array2[$key])) {
            return false;
        }
        if ($array2[$key] != $value) {
            return false;
        }
    }

    return true;
}

function sort_sizes($sizes)
{
    $sizeList = [
        '2XS',
        'XS',
        'S',
        'M',
        'L',
        'XL',
        '2XL',
        '3XL',
        '4XL',
        'OneSize',
    ];

    usort($sizes, function ($a, $b) use ($sizeList) {
        if (array_search($b, $sizeList) === false) {
            return -1;
        }

        if (array_search($a, $sizeList) === false) {
            return 1;
        }

        return array_search($a, $sizeList) - array_search($b, $sizeList);
    });

    return $sizes;
}
