<?php

namespace App\Contracts\Dashboard;

use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Request;

abstract class Dashboard
{
    /**
     * Selected tab
     *
     * @var string
     */
    private $option;

    /**
     * @var bool
     */
    protected $fluid = false;

    /**
     * @var bool
     */
    protected $navigation = false;

    /**
     * Set selected tab
     *
     * @param string $option
     */
    public function setOption($option)
    {
        $this->option = $option;
    }

    /**
     * @param bool $fluid
     * @return bool
     */
    public function setFluid($fluid)
    {
        return $this->fluid = $fluid;
    }

    /**
     * @return bool
     */
    public function getFluid()
    {
        return $this->fluid;
    }

    /**
     * @return bool
     */
    public function showsNavigation()
    {
        return $this->navigation;
    }

    /**
     * @param string $navigation
     */
    public function setNavigation($navigation)
    {
        $this->navigation = $navigation;
    }

    /**
     * @return string[]
     */
    public abstract function getOptions();

    /**
     * @param string $option
     * @param int    $page
     * @param string $url
     * @param array  $query
     * @return mixed[]
     */
    public abstract function getResults($option, $page = 0, $url = '/', $query = []);

    /**
     * @param string $option
     * @return mixed[]
     */
    public abstract function getHeader($option);

    /**
     * Get default tab
     *
     * @return mixed
     */
    public abstract function getDefault();

    /**
     * @param string $optionName
     * @return string|null
     */
    public function getActiveOption($optionName)
    {
        if ($optionName == null) {
            $optionName = $this->getDefault();
        }
        foreach ($this->getOptions() as $option) {
            if ($option['value'] == $optionName) {
                return $option;
            }
        }

        return null;
    }

    /**
     * @param Builder $results
     * @return Builder
     * @throws Exception
     */
    public function applySorting($results)
    {
        if (! Request::has('sort')) {
            return $results->orderBy('campaigns.updated_at', 'desc');
        }
        $header = $this->getHeader($this->option);
        $index = (int) Request::get('sort');
        $direction = (Request::has('sort_direction') && in_array(Request::has('sort_direction'), ['asc', 'desc'])) ? Request::get('sort_direction') : 'desc';
        if (! array_key_exists($index, $header)) {
            throw new Exception('Invalid Sorting');
        }
        switch ($header[$index]['type']) {
            case 'user':
                $direction = sort_direction_toggle($direction);
                if ($header[$index]['reference'] == 'user') {
                    /** @noinspection PhpMethodParametersCountMismatchInspection */
                    return $results->select('campaigns.*', 'user_names4.name')->join(\DB::raw("(select users.id, concat(first_name, ' ', last_name) as name"." from users where deleted_at is null) as user_names4"), function (JoinClause $join
                    ) {
                        $join->on('user_names4.id', '=', 'campaigns.user_id');
                    })->orderBy('user_names4.name', $direction);
                }
                if ($header[$index]['reference'] == 'artwork_request.designer') {
                    /** @noinspection PhpMethodParametersCountMismatchInspection */
                    return $results->select('campaigns.*', 'user_names5.name')->join(\DB::raw("(select artwork_requests.id, artwork_requests.designer_id"." from artwork_requests where deleted_at is null) as artwork_requests1"), function (
                        JoinClause $join
                    ) {
                        $join->on('artwork_requests1.id', '=', 'campaigns.artwork_request_id');
                    })->join(\DB::raw("(select users.id, concat(first_name, ' ', last_name) as name"." from users where deleted_at is null) as user_names5"), function (JoinClause $join) {
                        $join->on('user_names5.id', '=', 'artwork_requests1.designer_id');
                    })->orderBy('user_names5.name', $direction);
                }
                break;
            case 'colors':
                return $results->orderBy('campaigns.'.$header[$index]['reference'][0], $direction)->orderBy('campaigns.'.$header[$index]['reference'][1], $direction);
            case 'state':
                return $results->orderByRaw("FIELD(campaigns.state,
                    'on_hold',
                    'campus_approval',
                    'awaiting_design',
                    'awaiting_approval',
                    'revision_requested',
                    'awaiting_quote',
                    'collecting_payment',
                    'fulfillment_ready',
                    'fulfillment_validation',
                    'printing',
                    'shipped',
                    'delivered',
                    'cancelled'
                    ) $direction");
            case 'quantity':
                return $results->select('campaigns.*', 'order_quantities.quantity')->leftJoin(\DB::raw("(select campaign_id, sum(quantity) as quantity"." from orders where state = 'success' and deleted_at is null"." group by campaign_id) as order_quantities"), function (
                    JoinClause $join
                ) {
                    $join->on('order_quantities.campaign_id', '=', 'campaigns.id');
                })->orderBy('order_quantities.quantity', $direction);
            case 'age':
                $results = $results->orderByRaw('5 * (DATEDIFF(NOW(), campaigns.assigned_decorator_date) DIV 7) +'.' MID(\'0123444401233334012222340111123400001234000123440\','.' 7 * WEEKDAY(campaigns.assigned_decorator_date) + WEEKDAY(NOW()) + 1, 1) '.$direction);

                return $results;
            case 'countdown':
                return $results->orderBy('campaigns.updated_at', 'desc');
            default:
                return $results->orderBy('campaigns.'.$header[$index]['reference'], $direction);
        }
        throw new Exception('Unknown Type');
    }

    /**
     * @param Builder $results
     * @param array   $query
     * @return Builder
     * @throws Exception
     */
    public function applyFilters($results, array $query)
    {
        $filters = Request::all();
        $header = $this->getHeader($this->option);
        foreach ($filters as $filter => $value) {
            if (! starts_with($filter, 'filter_')) {
                continue;
            }
            if (! $value) {
                continue;
            }
            if (in_array($filter, ['filter_campaign_name', 'filter_campaign_id'])) {
                if (isset($query['filter_campaign_name']) && $query['filter_campaign_name']) {
                    $results = $results->where('campaigns.name', 'like', '%'.$query['filter_campaign_name'].'%');
                    continue;
                }
                if (isset($query['filter_campaign_id']) && $query['filter_campaign_id']) {
                    $results = $results->where('campaigns.id', $query['filter_campaign_id']);
                    continue;
                }
            }
            $originalFilter = $filter;
            $filter = str_replace('filter_', '', $filter);
            $sufix = '';
            if (! is_numeric($filter)) {
                $sufix = explode('_', $filter)[1];
                $filter = str_replace('_'.$sufix, '', $filter);
                if (! is_numeric($filter)) {
                    // Error
                    throw new Exception('Invalid Filter Selected: '.$originalFilter);
                }
            }
            $field = $header[$filter];
            switch ($field['type']) {
                case 'user':
                    if ($sufix == 'id') {
                        continue;
                    }
                    switch ($field['reference']) {
                        case 'user':
                            $results = $results->select('campaigns.*')->join(\DB::raw("(select users.id, concat(first_name, ' ', last_name) as name"." from users where deleted_at is null) as user_names1"), function (JoinClause $join) {
                                $join->on('user_names1.id', '=', 'campaigns.user_id');
                            })->where('user_names1.name', 'like', '%'.$value.'%');
                            break;
                        case 'designer':
                            $results = $results->select('campaigns.*')->join(\DB::raw("(select artwork_requests.id, artwork_requests.designer_id"." from artwork_requests where deleted_at is null) as artwork_requests1"), function (
                                JoinClause $join
                            ) {
                                $join->on('artwork_requests1.id', '=', 'campaigns.artwork_request_id');
                            })->join(\DB::raw("(select users.id, concat(first_name, ' ', last_name) as name"." from users where deleted_at is null) as user_names2"), function (JoinClause $join) {
                                $join->on('user_names2.id', '=', 'artwork_requests.designer_id');
                            })->where('user_names2.name', 'like', '%'.$value.'%');
                            break;
                        case 'decorator':
                            $results = $results->select('campaigns.*')->join(\DB::raw("(select users.id, concat(first_name, ' ', last_name) as name"." from users where deleted_at is null) as user_names3"), function (JoinClause $join) {
                                $join->on('user_names3.id', '=', 'campaigns.decorator_id');
                            })->where('user_names3.name', 'like', '%'.$value.'%');
                            break;
                    }
                    break;
                case 'colors':
                    if (strlen($value) != 3 && strpos($value, '/') == false) {
                        continue;
                    }
                    $values = explode('/', $value);
                    $results = $results->where($field['reference'][0], '=', $values[0]);
                    /** @var \Illuminate\Database\Eloquent\Builder $results */
                    $results = $results->where($field['reference'][1], '=', $values[1]);
                    break;
                case 'quantity':
                    $results = $results->whereExists(function (Builder $query) use ($value, $sufix) {
                        $query->select(\DB::raw(1))->from('orders')->where('state', 'success')->whereRaw('orders.campaign_id = campaigns.id');
                        if ($sufix == 'from') {
                            $query->havingRaw('sum(quantity) >= '.(int) $value);
                        } elseif ($sufix == 'to') {
                            $query->havingRaw('sum(quantity) <= '.(int) $value);
                        } else {
                            $query->havingRaw('sum(quantity) = '.(int) $value);
                        }
                    });
                    break;
                default:
                    if (in_array($field['type'], ['date', 'date_only', 'delivery_date'])) {
                        $value = date('Y-m-d', strtotime($value));
                    }
                    if ($sufix == 'from') {
                        $results = $results->where($field['reference'], '>=', $value);
                    } elseif ($sufix == 'to') {
                        $results = $results->where($field['reference'], '<=', $value.' 23:59:59');
                    } else {
                        $results = $results->where($field['reference'], $value);
                    }
                    break;
            }
        }
        if (isset($query['filter_decorator_id']) && $query['filter_decorator_id']) {
            $results = $results->where('decorator_id', $query['filter_decorator_id']);
        }

        return $results;
    }
}
