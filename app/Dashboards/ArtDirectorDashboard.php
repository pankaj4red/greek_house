<?php

namespace App\Dashboards;

use App\Contracts\Dashboard\Dashboard;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ArtDirectorDashboard extends Dashboard
{
    /**
     * @return array|string[]
     */
    public function getOptions()
    {
        return [
            [
                'type'         => 'option',
                'value'        => 'unclaimed',
                'caption'      => 'Unclaimed',
                'showFilters'  => true,
                'forceCaption' => false,
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
                'value'        => 'upload_print_files',
                'caption'      => 'Upload Files',
                'showFilters'  => true,
                'forceCaption' => false,
            ],
            [
                'type'         => 'option',
                'value'        => 'fulfillment_artwork_failed',
                'caption'      => 'Artwork Revision',
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
                    $results = $results->whereHas('artwork_request', function ($query) {
                        /** @var Builder $query */
                        $query->whereNull('designer_id');
                    })->whereNotIn('state', ['cancelled', 'delivered', 'campus_approval', 'on_hold']);
                    break;
                case 'open':
                    $results = $results->whereIn('state', [
                        'awaiting_design',
                        'revision_requested',
                        'awaiting_approval',
                        'awaiting_quote',
                        'collecting_payment',
                        'processing_payment',
                        'fulfillment_ready',
                        'fulfillment_validation',
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
                    ]);
                    break;
                case 'revision_requested':
                    $results = $results->whereIn('state', [
                        'revision_requested',
                    ]);
                    break;
                case 'upload_print_files':
                    $results = $results->where(function ($query) {
                        /** @var Builder $query */
                        $query->whereIn('state', [
                            'awaiting_quote',
                            'collecting_payment',
                            'processing_payment',
                            'fulfillment_ready',
                            'fulfillment_validation',
                        ])->orWhere(function ($query2) {
                            /** @var Builder $query2 */
                            $query2->whereIn('state', [
                                'collecting_payment',
                                'processing_payment',
                                'fulfillment_ready',
                                'fulfillment_validation',
                                'printing',
                                'shipped',
                                'delivered',
                                'cancelled',
                            ])->whereHas('artwork_request', function ($query3) {
                                /** @var Builder $query3 */
                                $query3->whereHas('proofs');
                            })->whereHas('artwork_request', function ($query3) {
                                /** @var Builder $query3 */
                                $query3->whereDoesntHave('print_files');
                            });
                        });
                    })->whereHas('artwork_request', function ($query2) {
                        /** @var Builder $query2 */
                        $query2->whereDoesntHave('print_files');
                    });
                    break;
                case 'fulfillment_artwork_failed':
                    $results->whereHas('artwork_request', function ($query) {
                        /** @var Builder $query */
                        $query->whereHas('print_files');
                    });
                    $results->where('fulfillment_valid', false)->where('fulfillment_invalid_reason', 'Artwork')->whereIn('state', [
                        'fulfillment_validation',
                    ]);
                    break;
                case 'closed':
                    $results = $results->whereIn('state', [
                        'fulfillment_validation',
                        'printing',
                        'shipped',
                        'delivered',
                        'cancelled',
                    ])->whereHas('artwork_request', function ($query) {
                        /** @var Builder $query */
                        $query->whereHas('print_files');
                    })->where('fulfillment_valid', true);
                    break;
            }
        }
        if (empty($query) && $option != 'unclaimed') {
            $results->whereHas('artwork_request', function ($query) {
                /** @var Builder $query */
                $query->where('designer_id', Auth::user()->id);
            });
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
            ['reference' => 'updated_at', 'caption' => 'Updated date', 'type' => 'date'],
            ['reference' => 'state', 'caption' => 'State', 'type' => 'state', 'link' => 'dashboard::details'],
            ['reference' => 'created_at', 'caption' => 'Created date', 'type' => 'date'],
            ['reference' => '', 'caption' => 'Countdown', 'type' => 'countdown'],
        ];
        switch ($option) {
            case 'unclaimed':
                $header[] = [
                    'caption'   => 'Estimated Quantity',
                    'type'      => 'text',
                    'class'     => 'field-text',
                    'reference' => 'estimated_quantity',
                ];
                $header[] = [
                    'caption' => 'Actions',
                    'type'    => 'designer_action',
                ];
                break;
            case 'awaiting_design':
            case 'revision_requested':
                $header[] = [
                    'caption' => 'Upload Designs',
                    'type'    => 'action',
                    'link'    => [
                        'url'   => 'dashboard::details',
                        'text'  => 'Upload Designs',
                        'class' => 'tag-action-upload-designs',
                    ],
                ];
                break;
            case 'upload_print_files':
                $header[] = [
                    'caption' => 'Upload Print Files',
                    'type'    => 'action',
                    'link'    => [
                        'url'   => 'dashboard::details',
                        'text'  => 'Upload Prints',
                        'class' => 'tag-action-upload-prints',
                    ],
                ];
                break;
        }

        return $header;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return 'unclaimed';
    }
}
