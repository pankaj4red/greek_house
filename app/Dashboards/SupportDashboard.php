<?php

namespace App\Dashboards;

use App\Contracts\Dashboard\Dashboard;
use Illuminate\Pagination\LengthAwarePaginator;

class SupportDashboard extends Dashboard
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
                'value'        => 'on_hold',
                'caption'      => 'On Hold',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
            [
                'type'         => 'option',
                'value'        => 'awaiting_design',
                'caption'      => 'Design',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
            [
                'type'         => 'option',
                'value'        => 'awaiting_approval',
                'caption'      => 'Approval',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
            [
                'type'         => 'option',
                'value'        => 'revision_requested',
                'caption'      => 'Revision',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
            [
                'type'         => 'option',
                'value'        => 'awaiting_quote',
                'caption'      => 'Quote',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
            [
                'type'         => 'option',
                'value'        => 'collecting_payment',
                'caption'      => 'Payment',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
            [
                'type'         => 'option',
                'value'        => 'fulfillment_ready',
                'caption'      => 'F. Ready',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
            [
                'type'         => 'option',
                'value'        => 'fulfillment_validation',
                'caption'      => 'F. Validation',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
            [
                'type'         => 'option',
                'value'        => 'fulfillment_issue',
                'caption'      => 'F. Issue',
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
                'value'        => 'shipped',
                'caption'      => 'Shipped',
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
        $results = campaign_repository()->newQuery()->with('artwork_request.designer', 'user');
        if (is_query_empty($query)) {
            switch ($option) {
                case 'unclaimed':
                    $results = $results->whereNull('manager_id');
                    break;
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
                        'shipped',
                    ]);
                    break;
                case 'on_hold':
                    $results = $results->whereIn('state', [
                        'on_hold',
                    ]);
                    break;
                case 'awaiting_design':
                    $results = $results->whereIn('state', [
                        'awaiting_design',
                    ]);
                    break;
                case 'awaiting_approval':
                    $results = $results->whereIn('state', [
                        'awaiting_approval',
                        'campus_approval',
                    ]);
                    break;
                case 'revision_requested':
                    $results = $results->whereIn('state', [
                        'revision_requested',
                    ]);
                    break;
                case 'awaiting_quote':
                    $results = $results->whereIn('state', [
                        'awaiting_quote',
                    ]);
                    break;
                case 'collecting_payment':
                    $results = $results->whereIn('state', [
                        'collecting_payment',
                        'processing_payment',
                    ]);
                    break;
                case 'fulfillment_ready':
                    $results = $results->whereIn('state', [
                        'fulfillment_ready',
                    ]);
                    break;
                case 'fulfillment_validation':
                    $results = $results->whereIn('state', [
                        'fulfillment_validation',
                    ])->where('fulfillment_valid', true);
                    break;
                case 'fulfillment_issue':
                    $results = $results->whereIn('state', [
                        'fulfillment_validation',
                    ])->where('fulfillment_valid', false);
                    break;
                case 'printing':
                    $results = $results->whereIn('state', [
                        'printing',
                    ]);
                    break;
                case 'shipped':
                    $results = $results->whereIn('state', [
                        'shipped',
                    ]);
                    break;
                case 'closed':
                    $results = $results->whereIn('state', [
                        'delivered',
                        'cancelled',
                    ]);
                    break;
            }
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
            ['reference' => 'user', 'caption' => 'Customer', 'type' => 'user'],
            ['reference' => 'artwork_request.designer', 'caption' => 'Designer', 'type' => 'user'],
            ['reference' => 'updated_at', 'caption' => 'Updated date', 'type' => 'date'],
            ['reference' => 'state', 'caption' => 'Status', 'type' => 'state', 'link' => 'dashboard::details'],
            ['reference' => 'decorator', 'caption' => 'Decorator', 'type' => 'user', 'visible' => false],
        ];
        switch ($option) {
            case 'unclaimed':
                $header[] = [
                    'caption' => 'Grab order',
                    'type'    => 'action',
                    'link'    => [
                        'url'   => 'dashboard::grab',
                        'text'  => 'Grab Campaign',
                        'class' => 'tag-action-grab half-margin-bottom',
                    ],
                ];
                break;
            case 'awaiting_quote':
                $header[] = [
                    'caption' => 'Provide Quote',
                    'type'    => 'action',
                    'link'    => [
                        'url'   => 'dashboard::details',
                        'text'  => 'Provide Quote',
                        'class' => 'tag-action-quote',
                    ],
                ];
                break;
            case 'fulfillment_ready':
            case 'fulfillment_validation':
            case 'fulfillment_issue':
            case 'printing':
                $header[] = ['reference' => '-', 'caption' => 'Quantity', 'type' => 'quantity'];
                $header[] = ['reference' => 'printing_date', 'caption' => 'Print Date', 'type' => 'date_only'];
                $header[] = [
                    'reference' => ['designer_colors_front', 'designer_colors_back'],
                    'caption'   => 'Colors',
                    'type'      => 'colors',
                ];
                $header[] = ['reference' => 'rush', 'caption' => 'Rush', 'type' => 'rush'];
                break;
        }

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
