<div class="container mt-5">
    @if (count($options) > 1)
        <ul class="nav nav-tabs" role="tablist">
            @foreach ($options as $option)
                @if ($option['type'] == 'option')
                    <li class="nav-item mr-2">
                        <a class="nav-link {{ $active == $option['value'] ? 'active' : '' }} pt-2 pb-2 p-1 text-xs" href="{{ route(Request::route()->getName(), $option['value']) }}" role="tab"
                           aria-selected="true">
                            {{ $option['caption'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    @else
        @if (!$activeOption['forceCaption'])
            <div class="nav-title">{{ $options[0]['caption'] }}
                @if (isset($options[0]['caption_text']))
                    <span class="text-danger">({{ $options[0]['caption_text'] }})</span>
                @endif
            </div>
        @endif
    @endif
</div>

@if (Auth::user() && Auth::user()->isType(['admin', 'art_director', 'junior_designer', 'designer', 'support', 'decorator']) && $activeOption['showFilters'])
    <div class="container mt-4 dashboard-filters">
        <div class="form-group mb-2">
            {{ Form::open(['method' => 'get', 'class' => 'form-inline']) }}
            <div class="mr-2">
                Filter by:
            </div>
            @foreach ($header as $key => $column)
                <?php /** @var array $column */ ?>
                @if (in_array($column['type'], ['campaign_name']))
                    <div class="w-150px mr-2">
                        {{ Form::text('filter_campaign_id', Request::has('filter_campaign_id')?Request::get('filter_campaign_id'):'', ['placeholder' => 'Campaign ID', 'class' => 'form-control form-control-xs']) }}
                    </div>
                    <div class="w-150px mr-2">
                        {{ Form::text('filter_campaign_name', Request::has('filter_campaign_name')?Request::get('filter_campaign_name'):'', ['placeholder' => 'Campaign Name', 'class' => 'form-control form-control-xs']) }}
                    </div>
                @elseif ($column['type'] == 'user')
                    @if (in_array($column['reference'], ['decorator', 'user']))
                        <div class="w-150px mr-2">
                            {{ Form::text('filter_' . $key, Request::has('filter_' . $key)?Request::get('filter_' . $key):'', ['class' => 'form-control form-control-xs', 'placeholder' => $column['caption']]) }}
                        </div>
                    @endif
                @endif
            @endforeach
            <div class="w-90px">
                <button type="submit" name="filter" value="filter" class="btn btn-info btn-xs">Apply</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endif
<div class="{{ dashboard_mode($table['fluid'] ? 'expanded' : 'container') == 'expanded' ? 'container-fluid' : 'container' }} mt-4">
    <div class="tab-content dashboard-table" {!! isset($table['name']) ? 'id="' . $table['name'] . '"' : '' !!}>
        <div class="tab-pane fade show active" id="open-campaigns" role="tabpanel">
            <div class="table-responsive">
                <table class="table border">
                    <thead>
                    @foreach ($header as $index => $column)
                        @if (!isset($column['visible']) || $column['visible'] == true)
                            <th class="text-left">
                                @if (Auth::check() && Auth::user()->isType(['admin', 'support', 'decorator', 'art_director', 'junior_designer', 'designer']))
                                    <a href="{{ url(Request::path()) . '?' . http_build_query(['sort' => $index, 'sort_direction' => sort_direction_toggle((Request::has('sort') && intval(Request::get('sort')) === $index && Request::has('sort_direction')) ? Request::get('sort_direction') : 'asc')] + Request::all()) }}">{{ $column['caption'] }}
                                        @if ($index == intval(Request::get('sort')) && Request::get('sort_direction') == 'asc')
                                            <i class="fa fa-caret-square-o-up" aria-hidden="true"></i>
                                        @elseif ($index == intval(Request::get('sort')) && Request::get('sort_direction') == 'desc')
                                            <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                                        @endif
                                    </a>
                                @else
                                    {{ $column['caption'] }}
                                @endif
                            </th>
                        @endif
                    @endforeach
                    </thead>
                    <tbody>
                    <?php /** @var \App\Models\Campaign $result */ ?>
                    @foreach ($results as $result)
                        <tr>
                            @foreach ($header as $column)
                                @if (!isset($column['visible']) || $column['visible'] == true)
                                    @if ($column['type'] == 'nid')
                                        <td class="text-left">
                                            <a class="tag-campaign-id tag-state-{{ $result['state'] }}" href="{{ route($column['link'], [$result['id']]) }}">{{ $result[$column['reference']] }}</a>
                                        </td>
                                    @elseif ($column['type'] == 'campaign_name')
                                        <td class="text-left">
                                            <a class="tag-campaign-id tag-state-{{ $result['state'] }}" href="{{ route($column['link'], [$result['id']]) }}">{{ $result[$column['reference']] }}</a>
                                            <a class="tag-link margin-left" href="{{ route($column['link'], [$result['id']]) }}">{{ $result['name'] }}</a>
                                        </td>
                                    @elseif ($column['type'] == 'user-name')
                                        <td class="text-left">
                                            <a class="tag-link"
                                               href="{{ route($column['link'], [$result['id']]) }}">{{ $result[$column['reference'][0]] . ' ' . $result[$column['reference'][1]]  }}</a>
                                        </td>
                                    @elseif ($column['type'] == 'user-type')
                                        <td class="text-left">
                                            <a class="tag-link"
                                               href="{{ route($column['link'], [$result['id']]) }}">{{ reference($result, $column['reference']) ? reference($result, $column['reference']) : '-' }}</a>
                                        </td>
                                    @elseif ($column['type'] == 'link')
                                        <td class="text-left">
                                            <a class="tag-link" href="{{ route($column['link'], [$result['id']]) }}">{{ $result[$column['reference']] }}</a>
                                        </td>
                                    @elseif ($column['type'] == 'date')
                                        <td class="text-left">
                                            <span class="tag-date">{{ $result[$column['reference']]?date('M j h:i A', strtotime($result[$column['reference']])):'-' }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'date_only')
                                        <td class="text-left">
                                            <span class="tag-date">{{ $result[$column['reference']]?date('M j', strtotime($result[$column['reference']])):'-' }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'date_only_with_year')
                                        <td class="text-left">
                                            <span class="tag-date">{{ $result[$column['reference']]?date('M j, Y', strtotime($result[$column['reference']])):'-' }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'date_week')
                                        <td class="text-left">
                                            <span class="tag-date">{{ $result[$column['reference']]?date('D, M j', strtotime($result[$column['reference']])):'-' }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'state')
                                        <td class="text-left">
                                            <a class="tag-state tag-state-{{ $result['state'] }}"
                                               href="{{ route($column['link'], [$result['id']]) }}">{!! campaign_state_caption($result[$column['reference']], true, campaign_repository()->find($result['id']), Auth::user()) !!}</a>
                                        </td>
                                    @elseif ($column['type'] == 'views')
                                        <td class="text-left">
                                            <a class="tag-views" href="{{ route($column['link'], [$result['id']]) }}">View Total Ordered</a>
                                        </td>
                                    @elseif ($column['type'] == 'text')
                                        <td class="text-left">
                                            <span class="tag-text">{{ reference($result, $column['reference']) }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'delivery_date')
                                        <td class="text-left">
                                            @if (isset($result[$column['reference']]))
                                                <span class="tag-delivery-date">{{ date('M j', strtotime($result[$column['reference']])) }}</span>
                                            @endif
                                        </td>
                                    @elseif ($column['type'] == 'user')
                                        <td class="text-left">
                                            <span class="tag-user tag-user-{{ reference($result, $column['reference']) ? reference($result, $column['reference'])->type_code : 'none' }}">{{ reference($result, $column['reference']) ? ($column['reference'] == 'designer' ? reference($result, $column['reference'])->getFullName() : reference($result, $column['reference'])->getFullName()) : 'Unassigned' }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'action')
                                        <td class="text-left">
                                            @if (isset($column['link']['url']))
                                                <a class="tag-action {{ isset($column['link']['class'])?$column['link']['class']:'' }}"
                                                   href="{{ route($column['link']['url'], [$result['id']]) }}">{{ $column['link']['text'] }}</a>
                                            @else
                                                @foreach ($column['link'] as $link)
                                                    <a class="tag-action {{ isset($link['class'])?$link['class']:'' }}" href="{{ route($link['url'], [$result['id']]) }}">{{ $link['text'] }}</a>
                                                @endforeach
                                            @endif
                                        </td>
                                    @elseif ($column['type'] == 'designer_action')
                                        <td class="text-left">
                                            <a class="tag-action tag-action-grab" href="{{ route('dashboard::grab', [$result['id']]) }}">Claim</a>
                                            <a class="tag-action tag-action-reject" href="javascript: void(0);" data-toggle="modal" data-target="#modal-reject-{{ $result['id'] }}">Reject</a>
                                            <div class="modal fade modal-override modal-reject" id="modal-reject-{{ $result['id'] }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">Reason for Rejecting Campaign</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="box">
                                                                {{ Form::open(['url' => route('dashboard::reject', [$result['id']])]) }}
                                                                <div class="form-horizontal">
                                                                    <div class="form-group">
                                                                        <p>Why are you rejecting this design?</p>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                {{ Form::select('reason', on_hold_rejected_by_designer_reason_options(['' => 'Select a reason']), null, ['id' => 'reason_' . $result['id'], 'class' => 'form-control']) }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <button type="submit" class="btn btn-danger pull-right" id="reject_{{ $result['id'] }}">Reject</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{ Form::close() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @elseif ($column['type'] == 'quantity')
                                        <td class="text-left">
                                            <span class="tag-quantity {{ isset($column['class'])?$column['class']:'' }}">{{ $result->getSuccessQuantity() }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'colors')
                                        <td class="text-left">
                                    <span class="tag-colors {{ isset($column['class'])?$column['class']:'' }}">{{ $result[$column['reference'][0]] }}
                                        /{{ $result[$column['reference'][1]] }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'rush')
                                        <td class="text-left">
                                            <span class="tag-rush {{ $result[$column['reference']]?'color-red':'color-blue' }} {{ isset($column['class'])?$column['class']:'' }}">{{ $result[$column['reference']]?'Yes':'No' }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'school_chapter')
                                        <td class="text-left">
                                            <span class="tag-text {{ isset($column['class'])?$column['class']:'' }}">{{ $result[$column['reference'][0]] . '/' . $result[$column['reference'][1]] }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'age')
                                        <td class="text-left">
                                            <span class="tag-text {{ isset($column['class'])?$column['class']:'' }}">{{ $result->getDecoratorAssignedAge() }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'days_in_state')
                                        <td class="text-left">
                                            <span class="tag-text {{ isset($column['class'])?$column['class']:'' }}">{{ $result->getDaysInState() }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'countdown')
                                        <td class="text-left">
                                            <span class="tag-text {{ isset($column['class'])?$column['class']:'' }} {{ countdown_class($result->getCountdownTime()) }}">{{ time_count($result->getCountdownTime()) }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'embellishment')
                                        <td class="text-left">
                                            <span class="tag-embellishment {{ isset($column['class'])?$column['class']:'' }}">{{ embellishment_code($result) }}</span>
                                        </td>
                                    @elseif ($column['type'] == 'flexible')
                                        <td class="text-left">
                                            <span class="tag-rush {{ $result[$column['reference']] == 'yes' ?'color-blue':'color-red' }} {{ isset($column['class'])?$column['class']:'' }}">{{ $result[$column['reference']] == 'yes'?'Yes':'No' }}</span>
                                        </td>
                                    @else
                                        <td class="text-left">{{ $result[$column['reference']] }}</td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                {{ $results->render("pagination::bootstrap-4") }}
            </div>
        </div>
    </div>
</div>
