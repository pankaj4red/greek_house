<?php

namespace App\Dashboards;

use App\Contracts\Dashboard\Dashboard;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerClosedDashboard extends Dashboard
{
    /**
     * @var bool
     */
    protected $navigation = true;

    /**
     * @return array|string[]
     */
    public function getOptions()
    {
        return [
            [
                'type'         => 'option',
                'value'        => 'closed',
                'caption'      => 'Closed Orders',
                'showFilters'  => false,
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
     */
    public function getResults($option, $page = 0, $url = '/', $query = [])
    {
        $this->setOption($option);
        $itemsPerPage = 5;
        $results = campaign_repository()->newQuery()->with('artwork_request.designer', 'user')->where('user_id', Auth::user()->id)->whereIn('state', [
            'shipped',
            'delivered',
            'cancelled',
        ])->orderBy('updated_at', 'desc');
        $count = $results->count();

        return new LengthAwarePaginator($results->take($itemsPerPage)->skip($itemsPerPage * ($page - 1))->get(), $count, $itemsPerPage, $page, [
            'path'     => $url,
            'query'    => $query,
            'pageName' => 'page2',
        ]);
    }

    /**
     * @param string $option
     * @return array|mixed[]
     */
    public function getHeader($option)
    {
        return [
            ['reference' => 'id', 'caption' => 'Campaign', 'type' => 'campaign_name', 'link' => 'dashboard::details'],
            ['reference' => 'updated_at', 'caption' => 'Updated date', 'type' => 'date'],
            ['reference' => 'views', 'caption' => 'View total', 'type' => 'views', 'link' => 'dashboard::details'],
            ['reference' => 'scheduled_date', 'caption' => 'Delivery date', 'type' => 'delivery_date'],
        ];
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return 'closed';
    }
}
