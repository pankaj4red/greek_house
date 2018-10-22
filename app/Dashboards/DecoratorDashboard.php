<?php

namespace App\Dashboards;

use App\Contracts\Dashboard\Dashboard;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class DecoratorDashboard extends Dashboard
{
    /**
     * @return array|string[]
     */
    public function getOptions()
    {
        return [
            [
                'type'         => 'option',
                'value'        => 'today',
                'caption'      => 'Today',
                'showFilters'  => false,
                'forceCaption' => 'New Campaigns',
                'caption_text' => 'Need to Set Print Date',
            ],
            [
                'type'         => 'option',
                'value'        => 'open',
                'caption'      => 'Open',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
            [
                'type'         => 'option',
                'value'        => 'fulfillment_validation',
                'caption'      => 'Artwork & Garments',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
            [
                'type'         => 'option',
                'value'        => 'printing',
                'caption'      => 'Printing',
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
        $results = campaign_repository()->newQuery()->with('artwork_request.designer', 'user')->where('decorator_id', Auth::user()->id);
        if (is_query_empty($query)) {
            switch ($option) {
                case 'today':
                    $results = $results->where('assigned_decorator_date', '>=', date('Y-m-d H:i:s', time() - 24 * 60 * 60));
                    break;
                case 'open':
                    $results->where('decorator_id', Auth::user()->id)->whereIn('state', [
                        'fulfillment_validation',
                        'printing',
                    ]);
                    break;
                case 'fulfillment_validation':
                    $results->where('decorator_id', Auth::user()->id)->whereIn('state', [
                        'fulfillment_validation',
                    ]);
                    break;
                case 'printing':
                    $results->whereIn('state', [
                        'printing',
                    ]);
                    break;
                case 'closed':
                    $results->whereIn('state', [
                        'shipped',
                        'delivered',
                        'cancelled',
                    ]);
                    break;
            }
        } else {
            $results->where('decorator_id', Auth::user()->id);
        }
        $results = $this->applyFilters($results, $query);
        $results = $this->applySorting($results);
        $count = $results->count();

        return new LengthAwarePaginator($results->take($itemsPerPage)->skip($itemsPerPage * ($page - 1))->get(), $count, $itemsPerPage, $page, [
            'path'  => $url,
            'query' => $query,
        ]);
    }

    /**
     * @param string $option
     * @return array|mixed[]
     */
    public function getHeader($option)
    {
        $header = [
            ['reference' => 'id', 'caption' => 'Campaign', 'type' => 'campaign_name', 'link' => 'dashboard::details'],
            ['reference' => 'product_colors.first().product.name', 'caption' => 'Garment Name', 'type' => 'text', 'link' => 'dashboard::details'],
            ['reference' => 'id', 'caption' => 'Print Type', 'type' => 'embellishment', 'link' => 'dashboard::details'],
            ['reference' => '-', 'caption' => 'Quantity', 'type' => 'quantity'],
            [
                'reference' => ['designer_colors_front', 'designer_colors_back'],
                'caption'   => 'Colors',
                'type'      => 'colors',
            ],
            ['reference' => 'printing_date', 'caption' => 'Print Date', 'type' => 'date_week'],
            ['reference' => 'days_in_transit', 'caption' => 'Days in Transit', 'type' => 'text', 'link' => 'dashboard::details'],
            ['reference' => 'date', 'caption' => 'Due Date', 'type' => 'date_only'],
            ['reference' => 'rush', 'caption' => 'Rush', 'type' => 'rush'],
            ['reference' => 'flexible', 'caption' => 'Flexible', 'type' => 'flexible', 'link' => 'dashboard::details'],
            ['reference' => 'garment_arrival_date', 'caption' => 'Garments Arrival Date', 'type' => 'date_only', 'link' => 'dashboard::details'],
            ['reference' => 'age', 'caption' => 'Age', 'type' => 'age'],
        ];

        return $header;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return 'today';
    }
}
