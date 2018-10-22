<?php

namespace App\Dashboards;

use App\Contracts\Dashboard\Dashboard;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class DecoratorAwaitingGarmentsDashboard extends Dashboard
{
    /**
     * @return array|string[]
     */
    public function getOptions()
    {
        return [
            [
                'type'         => 'option',
                'value'        => 'today_awaiting_garments',
                'caption'      => 'Awaiting Garment',
                'showFilters'  => false,
                'forceCaption' => false,
                'caption_text' => 'These should all be in by today',
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
        if (isset($query['page'])) {
            unset($query['page']);
        }
        $results = $results->whereRaw('date(garment_arrival_date) >= \''.date('Y-m-d', time() - 24 * 60 * 60).'\'')->whereRaw('date(garment_arrival_date) <= \''.date('Y-m-d').'\'');

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
            ['reference' => 'garment_arrival_date', 'caption' => 'Garment Arrival', 'type' => 'date'],
            ['reference' => 'updated_at', 'caption' => 'Updated date', 'type' => 'date'],
            ['reference' => 'state', 'caption' => 'Status', 'type' => 'state', 'link' => 'dashboard::details'],
        ];

        return $header;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return 'today_awaiting_garments';
    }
}
