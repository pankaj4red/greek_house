<?php

namespace App\Dashboards;

use App\Contracts\Dashboard\Dashboard;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class AccountManagerDashboard extends Dashboard
{
    /**
     * @return array|string[]
     */
    public function getOptions()
    {
        return [
            [
                'type'         => 'option',
                'value'        => 'open',
                'caption'      => 'Open',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
            [
                'type'         => 'option',
                'value'        => 'closed',
                'caption'      => 'Closed',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
            [
                'type'         => 'option',
                'value'        => 'cancelled',
                'caption'      => 'Cancelled',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
        ];
    }

    /**
     * @param string $option
     * @param int    $page
     * @param string $url
     * @param array  $query
     * @return LengthAwarePaginator|mixed[]
     * @throws \Exception
     */
    public function getResults($option, $page = 0, $url = '/', $query = [])
    {
        $this->setOption($option);
        $itemsPerPage = 15;
        $results = campaign_repository()->newQuery()->with('artwork_request.designer', 'user');
        if (is_query_empty($query)) {
            switch ($option) {
                case 'open':
                    $results = $results->whereIn('state', [
                        'on_hold',
                        'campus_approval',
                        'awaiting_design',
                        'revision_requested',
                        'awaiting_approval',
                        'awaiting_quote',
                        'collecting_payment',
                        'processing_payment',
                        'fulfillment_ready',
                        'fulfillment_validation',
                        'printing',
                    ]);
                    /** @var Builder $results */
                    $results = $results->where(function ($query) {
                        /** @var Builder $query */
                        $query->where('user_id', Auth::user()->id)->orWhereHas('user', function ($queryResult) {
                            /** @var Builder $queryResult */
                            $queryResult->where('account_manager_id', Auth::user()->id);
                        });
                    });
                    break;
                case 'closed':
                    $results = $results->whereIn('state', [
                        'shipped',
                        'delivered',
                    ]);
                    /** @var Builder $results */
                    $results = $results->where(function ($query) {
                        /** @var Builder $query */
                        $query->where('user_id', Auth::user()->id)->orWhereHas('user', function ($queryResult) {
                            /** @var Builder $queryResult */
                            $queryResult->where('account_manager_id', Auth::user()->id);
                        });
                    });
                    break;
                case 'cancelled':
                    $results = $results->whereIn('state', [
                        'cancelled',
                    ]);
                    /** @var Builder $results */
                    $results = $results->where(function ($query) {
                        /** @var Builder $query */
                        $query->where('user_id', Auth::user()->id)->orWhereHas('user', function ($queryResult) {
                            /** @var Builder $queryResult */
                            $queryResult->where('account_manager_id', Auth::user()->id);
                        });
                    });
                    break;
            }
        }

        $results = $this->applyFilters($results->orderBy('date', 'desc'), $query);
        $count = $results->count();

        return new LengthAwarePaginator($results->take($itemsPerPage)->skip($itemsPerPage * ($page - 1))->get(), $count, $itemsPerPage, $page, [
            'path'  => $url,
            'query' => $query,
        ]);
    }

    /**
     * @param string $option
     * @return array|string[][]
     */
    public function getHeader($option)
    {
        $header = [];
        $header[] = [
            'reference' => 'id',
            'caption'   => 'Campaign',
            'type'      => 'campaign_name',
            'link'      => 'dashboard::details',
        ];
        $header[] = ['reference' => 'user', 'caption' => 'Campaign Owner', 'type' => 'user'];
        $header[] = ['reference' => 'date', 'caption' => 'Due Date', 'type' => 'date_only'];
        $header[] = ['reference' => 'state', 'caption' => 'Status', 'type' => 'state', 'link' => 'dashboard::details'];
        $header[] = ['reference' => '', 'caption' => 'Days in Status', 'type' => 'days_in_state'];

        return $header;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return 'open';
    }
}
