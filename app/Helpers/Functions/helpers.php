<?php

function campaign_state_caption(
    $state,
    $includeHtml = false,
    \App\Models\Campaign $campaign = null,
    \App\Models\User $user = null
) {
    return campaign_state_repository()->caption($state, $includeHtml, $campaign, $user);
}

function budget_caption($state)
{
    return budget_repository()->caption($state);
}

function shipping_option_caption($state)
{
    return shipping_options_repository()->caption($state);
}

function budget_range($state)
{
    return budget_repository()->range($state);
}

function color_cost($estimatedQuantity, $colorCount, $enable = true)
{
    if ($enable == false) {
        return 0;
    }
    $colorCosts = [
        ['from' => 0, 'to' => 0, 'colors' => [0, 0, 0, 0, 0, 0, 0, 0]],
        ['from' => 1, 'to' => 23, 'colors' => [2.00, 2.70, 3.45, 4.10, 4.75, 5.40, 6.00, 6.60]],
        ['from' => 24, 'to' => 47, 'colors' => [1.60, 2.10, 2.60, 3.10, 3.50, 3.90, 4.30, 4.70]],
        ['from' => 48, 'to' => 71, 'colors' => [1.20, 1.45, 1.70, 1.95, 2.15, 2.35, 2.55, 2.75]],
        ['from' => 72, 'to' => 143, 'colors' => [0.85, 1.10, 1.35, 1.60, 1.80, 2.00, 2.20, 2.40]],
        ['from' => 144, 'to' => 215, 'colors' => [0.69, 0.87, 1.03, 1.19, 1.35, 1.51, 1.67, 1.83]],
        ['from' => 216, 'to' => 287, 'colors' => [0.60, 0.75, 0.90, 1.05, 1.18, 1.33, 1.48, 1.63]],
        ['from' => 288, 'to' => 359, 'colors' => [0.52, 0.62, 0.72, 0.82, 0.90, 0.98, 1.06, 1.14]],
        ['from' => 360, 'to' => 603, 'colors' => [0.48, 0.58, 0.68, 0.78, 0.86, 0.94, 1.02, 1.10]],
        ['from' => 605, 'to' => 1007, 'colors' => [0.38, 0.48, 0.58, 0.68, 0.76, 0.84, 0.92, 1.00]],
        ['from' => 1008, 'to' => 2015, 'colors' => [0.27, 0.37, 0.47, 0.57, 0.65, 0.73, 0.81, 0.89]],
        ['from' => 2016, 'to' => 2147483647, 'colors' => [0.25, 0.35, 0.45, 0.55, 0.63, 0.61, 0.69, 0.77]],
    ];
    foreach ($colorCosts as $entry) {
        if ($entry['from'] >= $estimatedQuantity && $entry['to'] <= $estimatedQuantity) {
            if ($colorCount >= count($entry['colors'])) {
                return $entry['colors'][count($entry['colors']) - 1];
            } else {
                return $entry['colors'][$colorCount - 1];
            }
        }
    }
    throw new Exception('Invalid Estimated Quantity');
}

function extra_size_charge($size)
{
    if (in_array($size, [
        '2XL',
        '3XL',
        '4XL',
    ])) {
        return 2;
    }

    return 0;
}

function add_comment($campaignId, $body, $userId = null, $fileId = null)
{
    $comment = App::make(App\Repositories\Models\CommentRepository::class)->make();
    $comment->campaign_id = $campaignId;
    $comment->body = $body;
    $comment->user_id = $userId;
    $comment->file_id = $fileId;
    $comment->save();

    return $comment->id;
}

function add_comment_fulfillment($campaignId, $body, $userId = null, $fileId = null)
{
    $comment = App::make(App\Repositories\Models\CommentRepository::class)->make();
    $comment->campaign_id = $campaignId;
    $comment->body = $body;
    $comment->user_id = $userId;
    $comment->file_id = $fileId;
    $comment->channel = 'fulfillment';
    $comment->save();

    return $comment->id;
}

function get_email($email)
{
    return config('notifications.mail.override') ? config('notifications.mail.override') : $email;
}

function garment_size_to_salesforce_size($size)
{
    switch ($size) {
        case '2XS':
            return 'XXS';
        case 'XS':
            return 'XS';
        case 'S':
            return 'Small';
        case 'M':
            return 'Medium';
        case 'L':
            return 'Large';
        case 'XL':
            return 'XL';
        case '2XL':
            return 'XXL';
        case '3XL':
            return '3XL';
        case '4XL':
            return '4XL';
        case 'OneSize':
            return 'One Size';
    }

    return $size;
}

/**
 * @param string                    $state
 * @param \App\Models\Campaign|null $campaign
 * @return string
 */
function campaign_state_to_salesforce_stage($state, $campaign = null)
{
    switch ($state) {
        case 'campus_approval':
            return 'Awaiting Proof';
        case 'on_hold':
            if ($campaign) {
                switch ($campaign->on_hold_category) {
                    case 'new_customer':
                        return 'On Hold - New Customer';
                    case 'high_risk':
                        return 'On Hold - High Risk Customer';
                    case 'design':
                        return 'On Hold - Design';
                    case 'product':
                        return 'On Hold - Product';
                    case 'duplicate':
                        return 'On Hold - Duplicate';
                    case 'action_needed':
                        return 'On Hold - Action Needed';
                    case 'budget':
                        return 'On Hold - Budget';
                }

                return 'On Hold';
            }
        case 'awaiting_design':
            return 'Awaiting Proof';
        case 'awaiting_approval':
            return 'Awaiting Approval';
        case 'revision_requested':
            return 'Revision Requested';
        case 'awaiting_quote':
            return 'Awaiting Quote';
        case 'collecting_payment':
            return 'Collecting Payment';
        case 'processing_payment':
            return 'Collecting Payment';
        case 'printing':
            return 'Printing';
        case 'fulfillment_ready':
            return 'Ready For Fulfillment';
        case 'fulfillment_validation':
            if ($campaign == null) {
                return 'Artwork';
            } elseif ($campaign->fulfillment_valid) {
                return 'Artwork';
            } elseif ($campaign->fulfillment_invalid_reason == 'Artwork') {
                return 'Artwork - Bad';
            } else {
                return 'Garments - Bad';
            }
        case 'shipped':
            return 'Shipped';
        case 'delivered':
            return 'Invoiced';
        case 'cancelled':
            return 'Dead - Lost (Cancelled)';
    }

    return $state;
}

function campaign_design_gallery_status_to_salesforce($campaign)
{
    /** @var \App\Models\Design $designGallery */
    $designGallery = $campaign->designs->first();
    if ($designGallery) {
        switch ($designGallery->status) {
            case 'new':
                return 'New';
            case 'disabled':
                return 'Disabled';
            case 'enabled':
                return 'Enabled';
        }
    }

    return 'New';
}

function campaign_design_gallery_trending_to_salesforce($campaign)
{
    /** @var \App\Models\Design $designGallery */
    $designGallery = $campaign->designs->first();
    if ($designGallery) {
        return $designGallery->trending ? 'Enabled' : 'Disabled';
    }

    return 'Disabled';
}

function school_year_text($value)
{
    switch ($value) {
        case 'freshman':
            return 'Freshman';
        case 'sophomore':
            return 'Sophomore';
        case 'junior':
            return 'Junior';
        case 'senior':
            return 'Senior';
        case 'senior_5th':
            return '5th Year Senior';
    }

    return null;
}

function school_year_value($value)
{
    switch ($value) {
        case 'Freshman':
            return 'freshman';
        case 'Sophomore':
            return 'sophomore';
        case 'Junior':
            return 'junior';
        case 'Senior':
            return 'senior';
        case '5th Year Senior':
            return 'senior_5th';
    }

    return null;
}

function chapter_position_text($value)
{
    switch ($value) {
        case 'none':
            return 'None';
        case 'tshirt_chair':
            return 'T-Shirt Chair';
        case 'social_chair':
            return 'Social Chair';
        case 'philanthropy_chair':
            return 'Philanthropy Chair';
        case 'treasurer':
            return 'Treasurer';
        case 'chapter_officer':
            return 'Chapter Officer';
    }

    return null;
}

function chapter_member_count_text($value)
{
    if ($value >= 151) {
        return '151+';
    }
    if ($value >= 121) {
        return '121-150';
    }
    if ($value >= 81) {
        return '81-120';
    }
    if ($value >= 51) {
        return '51-80';
    }
    if ($value >= 24) {
        return '24-50';
    }
    if ($value >= 1) {
        return '1-23';
    }

    return null;
}

function school_chapter_match($school, $chapter, $object = 'school')
{
    $chapterRepository = \App::make(App\Repositories\Models\ChapterRepository::class);
    $chapter = $chapterRepository->findBySchoolAndChapter($school, $chapter);
    if (! $chapter) {
        return null;
    }
    if ($object == 'school') {
        $chapter->load('school');

        return $chapter->school;
    } else {
        return $chapter;
    }
}

function without_query_string($url)
{
    if (mb_strpos($url, '?') !== false) {
        return mb_substr($url, 0, mb_strpos($url, '?'));
    }

    return $url;
}

function country_name($code)
{
    switch ($code) {
        case 'usa':
            return 'United States';
        case 'ca':
            return 'Canada';
        case 'tw':
            return 'Taiwan';
        default:
            return $code;
    }
}

function design_style_preference_text($value)
{
    switch ($value) {
        case 'none':
            return 'None';
        case 'cartoon':
            return 'Cartoon';
        case 'realistic_sketch':
            return 'Realistic Sketch';
        case 'mixed_graphic':
            return 'Mixed Graphic';
        case 'line_art':
            return 'Line Art';
        case 'typographical':
            return 'Typographical';
        case 'graphic_stamp':
            return 'Graphic/Stamp';
    }

    return null;
}

function design_style_preference_image_id($value)
{
    switch ($value) {
        case 'cartoon':
            return 8153;
        case 'realistic_sketch':
            return 8528;
        case 'mixed_graphic':
            return 8568;
        case 'line_art':
            return 8656;
        case 'typographical':
            return 8680;
        case 'graphic_stamp':
            return 8706;
    }

    return null;
}

function print_type_caption($code)
{
    return design_type_options()[$code];
}

function estimated_quantity_by_code($printType, $code)
{
    return \App\Repositories\PrintType\PrintTypeRepository::getPrintType($printType)->getEstimatedRange($code);
}

function estimated_quantity_by_quantity($printType, $quantity)
{
    return \App\Repositories\PrintType\PrintTypeRepository::getPrintType($printType)->getEstimatedRangeByQuantity($quantity);
}

function quote_range($quoteLow, $quoteHigh, $quoteFinal = null, $addBrackets = true)
{
    if ($quoteFinal != null && $quoteFinal != 0) {
        return '$'.number_format($quoteFinal, 2);
    }
    if ($quoteLow != $quoteHigh) {
        return ($addBrackets ? '[' : '').'$'.number_format($quoteLow, 2).' - $'.number_format($quoteHigh, 2).($addBrackets ? ']' : '');
    }

    return '$'.number_format($quoteHigh, 2);
}

function get_args($args)
{
    if (is_object($args)) {
        $args = (array) $args;
    }
    if (is_array($args)) {
        foreach ($args as $key => $arg) {
            if ($arg instanceof \Illuminate\Http\Request) {
                unset($args[$key]);
            }
            if ($arg instanceof \Exception) {
                $args[$key] = get_class($arg);
            }
        }

        return $args;
    }

    return (string) $args;
}

function call_stack_reduce($trace)
{
    $fromIndex = 0;
    $toIndex = count($trace) - 1;
    for ($i = 0; $i < count($trace); $i++) {
        if (isset($trace[$i]['class']) && isset($trace[$i]['function']) && in_array(basename(str_replace('\\', '/', $trace[$i]['class'])).'::'.$trace[$i]['function'], [
                'Log::debug',
                'Log::info',
                'Log::notice',
                'Log::warning',
                'Log::error',
                'Log::alert',
                'Log::critical',
                'Log::emergency',
            ])) {
            $fromIndex = $i;
        }
        if (isset($trace[$i]['class']) && isset($trace[$i]['function']) && basename(str_replace('\\', '/', $trace[$i]['class'])) == 'Controller' && $trace[$i]['function'] == 'callAction') {
            $toIndex = $i - 2;
            break;
        }
    }

    return array_slice($trace, $fromIndex, $toIndex - $fromIndex + 1);
}

function call_stack_args($trace, $reduced = false)
{
    if ($reduced) {
        $trace = call_stack_reduce($trace);
    }
    $index = 0;
    if (isset($trace[0]['class']) && in_array($trace[0]['class'], ['Illuminate\Support\Facades\Log', 'Illuminate\Foundation\Bootstrap\HandleExceptions']) && count($trace) > 1) {
        $index++;
    }
    if (isset($trace[$index]['args'])) {
        return get_args($trace[$index]['args']);
    }

    return null;
}

function call_stack_method($trace, $reduced = false)
{
    if ($reduced) {
        $trace = call_stack_reduce($trace);
    }
    $index = 0;
    if (isset($trace[0]['class']) && in_array($trace[0]['class'], ['Illuminate\Support\Facades\Log', 'Illuminate\Foundation\Bootstrap\HandleExceptions']) && count($trace) > 1) {
        $index++;
    }
    if (isset($trace[$index]['class']) && isset($trace[$index]['function'])) {
        return basename(str_replace('\\', '/', $trace[$index]['class'])).'::'.$trace[$index]['function'];
    }

    return null;
}

function call_stack_print($trace, $reduced = false)
{
    $output = str_repeat("=", 50)."\n";
    $i = 1;
    if ($reduced == true) {
        $trace = call_stack_reduce($trace);
    }
    foreach ($trace as $node) {
        $output .= "$i. ".basename(isset($node['class']) ? str_replace('\\', '/', $node['class']) : (isset($node['file']) ? $node['file'] : '')).":".(isset($node['function']) ? $node['function'] : '-').(isset($node['line']) ? "(".$node['line'].')' : '')."\n";
        $i++;
    }

    return $output;
}

function call_stack_normalize_trace($trace)
{
    $normalizedTrace = [];
    foreach ($trace as $entry) {
        $normalizedTraceEntry = [];
        if (isset($entry['class'])) {
            $normalizedTraceEntry['class'] = $entry['class'];
        }
        if (isset($entry['method'])) {
            $normalizedTraceEntry['method'] = $entry['method'];
        }
        if (isset($entry['function'])) {
            $normalizedTraceEntry['function'] = $entry['function'];
        }
        if (isset($entry['file'])) {
            if (mb_strpos($entry['file'], '/vendor/') !== false) {
                continue;
            }
            $normalizedTraceEntry['file'] = $entry['file'];
        }
        if (isset($entry['line'])) {
            $normalizedTraceEntry['line'] = $entry['line'];
        }
        if (isset($entry['args'])) {
            $normalizedTraceEntry['args'] = $entry['args'];
            foreach ($normalizedTraceEntry['args'] as $key => $value) {
                if (is_object($value) && $value instanceof Closure) {
                    $normalizeTraceEntry['args'][$key] = 'Closure() {}';
                }
                if (is_object($value)) {
                    $normalizedTraceEntry['args'][$key] = get_class($value);
                }
                if (is_array($value)) {
                    $normalizedTraceEntry['args'][$key] = 'array';
                }
            }
        }
        $normalizedTrace[] = $normalizedTraceEntry;
    }

    return $normalizedTrace;
}

function get_ul_list($list)
{
    try {
        if (is_object($list) && method_exists($list, 'toArray')) {
            $list = $list->toArray();
        }
        if (is_object($list)) {
            $list = (array) $list;
        }
        if (is_array($list)) {
            if (count($list) > 0) {
                $output = '<ul>';
                foreach ($list as $key => $value) {
                    $output .= '<li>'.(is_integer($key) ? '' : $key.': ').get_ul_list($value).'</li>';
                }
                $output .= '</ul>';

                return $output;
            } else {
                return '[]';
            }
        }
        if (is_null($list)) {
            return 'NULL';
        }

        return (string) $list;
    } catch (\Exception $ex) {
        return '#'.$ex->getMessage().'#';
    }
}

function sort_direction_toggle($defaultDirection = null)
{
    return ($defaultDirection == null || $defaultDirection == 'asc') ? 'desc' : 'asc';
}

function get_bot($userAgent)
{
    try {
        if (mb_strpos(mb_strtolower($userAgent), 'compatible; ') !== false && mb_strpos(mb_strtolower($userAgent), 'bot') !== false) {
            $start = mb_substr($userAgent, mb_strpos($userAgent, '(compatible; ') + mb_strlen('(compatible; '));

            return mb_substr($start, 0, mb_strpos($start, ';'));
        }
    } catch (\Exception $ex) {
        Log::error($ex->getMessage(), ['exception' => $ex]);
    }

    return null;
}

if (! function_exists('mb_str_replace')) {
    function mb_str_replace($search, $replace, $subject, &$count = 0)
    {
        if (! is_array($subject)) {
            $searches = is_array($search) ? array_values($search) : [$search];
            $replacements = is_array($replace) ? array_values($replace) : [$replace];
            $replacements = array_pad($replacements, count($searches), '');
            foreach ($searches as $key => $search) {
                $parts = mb_split(preg_quote($search), $subject);
                $count += count($parts) - 1;
                $subject = implode($replacements[$key], $parts);
            }
        } else {
            foreach ($subject as $key => $value) {
                $subject[$key] = mb_str_replace($search, $replace, $value, $count);
            }
        }

        return $subject;
    }
}

function static_asset($asset)
{
    $assetUrl = asset($asset);
    $domain = parse_url($assetUrl, PHP_URL_HOST);

    return mb_str_replace($domain, config('app.domain.static'), $assetUrl);
}

function time_count($time)
{
    if ($time === null || $time == 'N/A') {
        return 0;
    }
    $negative = false;
    if ($time < 0) {
        $negative = true;
        $time = -$time;
    }
    $days = floor($time / (24 * 60 * 60));
    $time = $time - $days * 24 * 60 * 60;
    $hours = floor($time / (60 * 60));
    $time = $time - $hours * 60 * 60;
    $minutes = floor($time / 60);
    $output = '';
    if ($days) {
        $output .= $days.'d ';
    }
    $output .= $hours.'h '.$minutes.'m';
    if ($negative) {
        $output = '-'.$output;
    }

    return $output;
}

function countdown_class($time)
{
    if (! is_int($time)) {
        return 'countdown_gray';
    }
    if ($time >= 24 * 60 * 60) {
        return 'countdown_green';
    }
    if ($time >= 0) {
        return 'countdown_orange';
    }

    return 'countdown_red';
}

function garment_size_list()
{
    $garmentSize = garment_size_repository();

    return $garmentSize->all(['*'], null, ['id', 'asc']);
}

function get_event_properties($mainKey, $object)
{
    if (is_object($object)) {
        if (method_exists($object, 'toArray')) {
            $object = $object->toArray();
        } else {
            $object = (array) $object;
        }
    }
    if (is_null($object)) {
        return [$mainKey => 'N/A'];
    }
    $result = [];
    foreach ($object as $key => $value) {
        if (is_array($value) || is_object($value)) {
            $subResult = get_event_properties($mainKey.'.'.$key, $value);
            foreach ($subResult as $sKey => $sValue) {
                $result[$sKey] = $sValue;
            }
        } else {
            $result[$mainKey.'.'.$key] = (string) $value;
        }
    }

    return $result;
}

function is_query_empty($query)
{
    if (empty($query)) {
        return true;
    }
    if (is_object($query)) {
        $query = (array) $query;
    }
    if (is_array($query)) {
        if (isset($query['filter'])) {
            unset($query['filter']);
        }
        foreach ($query as $queryKey => $queryValue) {
            if ($queryKey == 'page') {
                continue;
            }
            if (! empty($queryValue)) {
                return false;
            }
        }

        return true;
    }

    return false;
}

/**
 * @param \App\Models\Campaign $campaign
 * @return string
 */
function embellishment_code($campaign)
{
    if ($campaign->getCurrentArtwork()->design_type == 'embroidery') {
        return 'EMB';
    }
    if ($campaign->getCurrentArtwork()->design_type == 'screen' && ($campaign->getCurrentArtwork()->embellishment_names == 'yes' || $campaign->getCurrentArtwork()->embellishment_numbers == 'yes') && $campaign->getCurrentArtwork()->speciality_inks == 'yes') {
        return 'SPECNUM';
    }
    if ($campaign->getCurrentArtwork()->design_type == 'screen' && $campaign->getCurrentArtwork()->speciality_inks == 'yes') {
        return 'SPECL';
    }
    if ($campaign->getCurrentArtwork()->design_type == 'screen' && ($campaign->getCurrentArtwork()->embellishment_names == 'yes' || $campaign->getCurrentArtwork()->embellishment_numbers == 'yes')) {
        return 'NUMNAM';
    }
    if ($campaign->getCurrentArtwork()->design_type == 'screen') {
        return 'SCRN';
    }

    return 'N/A';
}

function number_to_range($number)
{
    if ($number === null || empty($number)) {
        return null;
    }
    if ($number <= 50) {
        return '1-50';
    }
    if ($number <= 80) {
        return '51-80';
    }
    if ($number <= 120) {
        return '81-120';
    }
    if ($number <= 150) {
        return '121-150';
    }

    return '151+';
}

function real_email($email)
{
    if (preg_match('/^([a-zA-Z0-9\._]+)(\+[a-zA-Z0-9]+){0,1}@([a-zA-Z0-9\._]+)$/', $email, $matches)) {
        return $matches[1].'@'.$matches[3];
    }

    return $email;
}

function user_type_to_salesforce_user_type(\App\Models\User $user)
{
    if ($user->type_code == 'account_manager') {
        return 'Campus Manager';
    }

    if ($user->type_code == 'sales_rep') {
        return 'Sales Rep';
    }

    if (in_array($user->type_code, ['designer', 'junior_designer'])) {
        return 'Designer';
    }

    if ($user->type_code == 'art_director') {
        return 'Art Director';
    }

    if ($user->type_code == 'decorator') {
        return 'Printer';
    }

    return 'Customer';
}

function is_unmapped_account($id)
{
    return $id == null || sf_id($id) == unmapped_account_id();
}

function is_invalid_account($id)
{
    return sf_id($id) == invalid_account_id();
}

function invalid_account_id()
{
    return '001f100001AkWxe';
}

function unmapped_account_id()
{
    return '001j0000015U9Tb';
}

function sf_id($id)
{
    if ($id === null) {
        return null;
    }

    return substr($id, 0, 15);
}

function spaced_camel_case($value)
{
    $values = explode('_', $value);
    $return = '';
    foreach ($values as $value) {
        if ($return) {
            $return .= ' ';
        }
        $return .= ucfirst($value);
    }

    return $return;
}

function tmp_path($filename = null)
{
    return sys_get_temp_dir().($filename ? (DIRECTORY_SEPARATOR.$filename) : '');
}

function slashes($text)
{
    $text = str_replace('\"', '[sub]', $text);
    $text = str_replace('"', '\"', $text);
    $text = str_replace('[sub]', '\\\\\"', $text);

    return $text;
}

/**
 * @param $productColorId
 * @return \App\Models\ProductColor|null
 */
function product_color($productColorId)
{
    $repository = App::make(\App\Repositories\Models\ProductColorRepository::class);

    return $repository->findWithTrashed($productColorId);
}

/**
 * @param $short
 * @return \App\Models\ProductColor|null
 */
function garment_size_by_short($short)
{
    $repository = App::make(\App\Repositories\Models\GarmentSizeRepository::class);

    return $repository->findByShort($short);
}

function garment_gender_list()
{
    return App::make(\App\Repositories\Models\GarmentGenderRepository::class)->getListing(['not_unisex' => true]);
}

function garment_category_list($genderId)
{
    return App::make(\App\Repositories\Models\GarmentCategoryRepository::class)->getByGenderId($genderId);
}

function product_list($genderId, $categoryId)
{
    return product_repository()->getByGenderIdAndCategoryId($genderId, $categoryId);
}

function product($productId)
{
    return product_repository()->find($productId);
}

function product_size_by_garment_size_id($productId, $garmentSizeId)
{
    return product_repository()->find($productId);
}

function comments_by_campaign_channel($campaignId, $channel)
{
    return App::make(\App\Repositories\Models\CommentRepository::class)->getByCampaignIdAndChannel($campaignId, $channel);
}

function clear_access_tokens()
{
    App::make(\App\Helpers\AccessToken\AccessTokenManager::class)->clearAllTokens();
}

function form($request = null)
{
    return new \App\Helpers\FormHandler($request);
}

function new_image_resize($fileId, $width, $height)
{
    $content = \App::make(\App\Helpers\ImageHandler::class)->getLocalContent(file_repository()->find($fileId)->internal_filename, $width, $height);

    return file_repository()->create([
        'name'              => time().'.png',
        'internal_filename' => save_file($content),
        'type'              => 'image',
        'sub_type'          => 'image',
        'mime_type'         => 'image/png',
    ]);
}

function global_counter()
{
    global $globalCounter;

    if (! $globalCounter) {
        $globalCounter = 0;
    }

    return ++$globalCounter;
}

function log_variables_from_model($log)
{
    $campaign = '';
    $order = '';
    foreach ($log->details as $key => $value) {
        if ($key == 'campaign.id') {
            $campaign = $value;
        }
        if ($key == 'order.id') {
            $campaign = $order;
        }
    }

    if (preg_match('/save-information\/([0-9]+)$/', $log->message, $matches)) {
        $order = $matches[1];
        try {
            $campaign = order_repository()->find($order)->campaign_id;
        } catch (\Exception $ex) {
        }
    }

    if (preg_match('/store\/[a-zA-Z\-_]*([0-9]+)$/', $log->message, $matches)) {
        $campaign = $matches[2];
    }

    if (preg_match('/store\/[a-zA-Z\-_]*([0-9]+)\/([0-9]+)$/', $log->message, $matches)) {
        $order = $matches[1];
        $campaign = $matches[2];
    }

    if (preg_match('/store\/[a-zA-Z\-_]*([0-9]+)\/([0-9]+)\/thank-you$/', $log->message, $matches)) {
        $order = $matches[1];
        $campaign = $matches[2];
    }

    if (preg_match('/store\/[a-zA-Z\-_]*([0-9]+)\/([0-9]+)\/authorize$/', $log->message, $matches)) {
        $order = $matches[1];
        $campaign = $matches[2];
    }

    if (preg_match('/store\/[a-zA-Z\-_]*([0-9]+)\/([0-9]+)\/manual$/', $log->message, $matches)) {
        $order = $matches[1];
        $campaign = $matches[2];
    }

    if (preg_match('/store\/[a-zA-Z\-_]*([0-9]+)\/([0-9]+)\/test$/', $log->message, $matches)) {
        $order = $matches[1];
        $campaign = $matches[2];
    }

    if (preg_match('/validate-information\/([0-9]+)$/', $log->message, $matches)) {
        $order = $matches[1];
        try {
            $campaign = order_repository()->find($order)->campaign_id;
        } catch (\Exception $ex) {
        }
    }

    if (preg_match('/save-information\/([0-9]+)$/', $log->message, $matches)) {
        $order = $matches[1];
        try {
            $campaign = order_repository()->find($order)->campaign_id;
        } catch (\Exception $ex) {
        }
    }

    if (preg_match('/dashboard\/[a-zA-Z\/\-_\-]+([0-9]+)[a-zA-Z\/\-_\-]*$/', $log->message, $matches)) {
        $campaign = $matches[1];
    }

    if (preg_match('/campaign\/([0-9]+)[a-zA-Z\/\-_\-]*$/', $log->message, $matches)) {
        $campaign = $matches[1];
    }

    return [
        'id'        => $log->id,
        'channel'   => $log->channel,
        'level'     => $log->level,
        'message'   => $log->message,
        'user_id'   => $log->user_id,
        'ip'        => $log->ip,
        'time_from' => $log->created_at,
        'time_to'   => $log->created_at,
        'campaign'  => $campaign,
        'order'     => $order,
        'key'       => null,
        'value'     => null,
    ];
}

function log_variables($parameterOverride = [])
{
    $current = [
        'id'        => Request::get('id'),
        'channel'   => Request::get('channel'),
        'level'     => Request::get('level'),
        'message'   => Request::get('message'),
        'user_id'   => Request::get('user_id'),
        'ip'        => Request::get('ip'),
        'time_from' => Request::get('time_from'),
        'time_to'   => Request::get('time_to'),
        'campaign'  => Request::get('campaign'),
        'order'     => Request::get('order'),
        'key'       => Request::get('key'),
        'value'     => Request::get('value'),
    ];

    $new = array_merge($current, $parameterOverride);

    return $new;
}

function log_parameters($parameterOverride = [])
{
    return http_build_query(log_variables($parameterOverride));
}

function log_time($from, $to, $period)
{
    $time = $from;
    if ($from != $to) {
        $difference = \Carbon\Carbon::parse($to)->getTimestamp() - \Carbon\Carbon::parse($from)->getTimestamp();
        $offsetMiddle = round($difference / 2, 0);
        $time = \Carbon\Carbon::parse($from)->addSecond($offsetMiddle)->format('Y-m-d H:i:s');
    }

    return ['time_from' => \Carbon\Carbon::parse($time)->subSecond($period)->format('Y-m-d H:i:s'), 'time_to' => \Carbon\Carbon::parse($time)->addSecond($period)->format('Y-m-d H:i:s')];
}

function get_user_success_rate($user)
{
    $success = 0;
    $fail = 0;
    foreach ($user->campaigns as $campaign) {
        if (in_array($campaign->state, [
            'processing_payment',
            'fulfillment_ready',
            'fulfillment_validation',
            'printing',
            'shipped',
            'delivered',
        ])) {
            $success++;
        }
        if ($campaign->state == 'cancelled') {
            $fail++;
        }
    }
    if ($success == 0) {
        return false;
    }

    return ($success / ($success + $fail) > 0.5);
}

function price_representation($price)
{
    $priceSymbol = "$";
    if ($price >= 2.26 && $price <= 5) {
        $priceSymbol = "$$";
    } else {
        if ($price >= 6 && $price <= 9) {
            $priceSymbol = "$$$";
        } else {
            if ($price > 9) {
                $priceSymbol = "$$$$";
            }
        }
    }

    return $priceSymbol;
}

function campaign_lead_product_tree($productColors)
{
    $products = [];
    foreach ($productColors as $productColor) {
        if (! array_key_exists($productColor->product_id, $products)) {
            $product = (object) $productColor->product->getAttributes();
            $product->colors = collect();
            $products[$productColor->product_id] = $product;
        }

        $products[$productColor->product_id]->colors->push((object) $productColor->getAttributes());
    }

    return collect($products);
}
