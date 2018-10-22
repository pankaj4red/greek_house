<?php

namespace App\Dashboards;

use App\Contracts\Dashboard\Dashboard;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class AccountManagerMembersDashboard extends Dashboard
{
    /**
     * @return array|string[]
     */
    public function getOptions()
    {
        return [
            ['type' => 'option', 'value' => 'list', 'caption' => '', 'showFilters' => true, 'forceCaption' => false],
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
        $results = user_repository()->newQuery()->where('account_manager_id', Auth::user()->id)->orderBy('first_name')->orderBy('last_name');
        if (isset($query['page'])) {
            unset($query['page']);
        }

        $results = $this->applyFilters($results, $query);
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
        $header = [];
        $header[] = [
            'reference' => ['first_name', 'last_name'],
            'caption'   => 'User',
            'type'      => 'user_name',
            'link'      => 'account_manager::account',
        ];
        $header[] = ['reference' => ['school', 'chapter'], 'caption' => 'Chapter', 'type' => 'school_chapter'];
        $header[] = ['reference' => 'phone', 'caption' => 'Phone', 'type' => 'text'];
        $header[] = ['reference' => 'email', 'caption' => 'Email', 'type' => 'text'];
        $header[] = [
            'reference' => 'type.caption',
            'caption'   => 'Type',
            'type'      => 'user_type',
            'link'      => 'account_manager::account',
        ];
        $header[] = ['reference' => 'created_at', 'caption' => 'Registration Date', 'type' => 'date_only_with_year'];

        return $header;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return 'list';
    }
}
