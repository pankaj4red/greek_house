<div class="container">
    @if (count($options) > 1)
        <table class="view_links_table">
            <tbody>
            <tr class="view_links_tr">
                @foreach ($options as $option)
                    @if ($option['type'] == 'option')
                        <td><a class="{{ $active==$option['value']?'active':'' }}"
                               href="{{ route(Request::route()->getName(), $option['value']) }}">{{ $option['caption'] }}</a>
                        </td>
                    @endif
                @endforeach
            </tr>
            </tbody>
        </table>
    @else
        @if (!$activeOption['forceCaption'])
            <div class="view_table_title">{{ $options[0]['caption'] }}
                @if (isset($options[0]['caption_text']))
                    <span class="text-danger">({{ $options[0]['caption_text'] }})</span>
                @endif
            </div>
        @endif
    @endif
    @if ($activeOption['forceCaption'])
        <div class="view_table_title">{{ $activeOption['forceCaption'] }}
            @if (isset($activeOption['caption_text']))
                <span class="text-danger">({{ $activeOption['caption_text'] }})</span>
            @endif
        </div>
    @endif
    @if (Auth::user() && Auth::user()->isType(['admin', 'art_director', 'junior_designer', 'designer', 'support', 'decorator']) && $activeOption['showFilters'])
        <div class="table-filters">
            {!! Form::open(['method' => 'get']) !!}
            <div class="table-filter-title">
                Filter by:
            </div>
            @foreach ($header as $key => $column)
                <?php /** @var array $column */ ?>
                @if (in_array($column['type'], ['campaign_name']))
                    <div class="table-filter-entry">
                        {!! Form::text('filter_campaign_id', Request::has('filter_campaign_id')?Request::get('filter_campaign_id'):'', ['placeholder' => 'Campaign ID', 'class' => 'form-control']) !!}
                    </div>
                    <div class="table-filter-entry">
                        {!! Form::text('filter_campaign_name', Request::has('filter_campaign_name')?Request::get('filter_campaign_name'):'', ['placeholder' => 'Campaign Name', 'class' => 'form-control']) !!}
                    </div>
                @elseif ($column['type'] == 'user')
                    @if (in_array($column['reference'], ['decorator', 'user']))
                        <div class="table-filter-entry">
                            {!! Form::text('filter_' . $key, Request::has('filter_' . $key)?Request::get('filter_' . $key):'', ['class' => 'form-control', 'placeholder' => $column['caption']]) !!}
                        </div>
                    @endif
                @endif
            @endforeach
            <div class="table-filter-action">
                <button type="submit" name="filter" value="filter" class="btn btn-info">Apply</button>
            </div>
            {!! Form::close() !!}
        </div>

    @endif
</div>
<div class="{{ Auth::user() && Auth::user()->isType('decorator') ? 'container-fluid' : 'container' }}">
    <div class="table-responsive dashboard-table-wrapper" id="{{ $name }}">
        <table class="table views-table">
            <thead>
            <tr>
                @foreach ($header as $index => $column)
                    @if (!isset($column['visible']) || $column['visible'] == true)
                        <th class="views-field">
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
            </tr>
            </thead>
            <tbody>
            <?php /** @var \App\Models\Campaign $result */ ?>
            @foreach ($results as $result)
                <tr>
                    @foreach ($header as $column)
                        @if (!isset($column['visible']) || $column['visible'] == true)
                            @if ($column['type'] == 'nid')
                                <td class="views-value">
                                    <a class="field-nid state_{{ $result['state'] }}"
                                       href="{{ route($column['link'], [$result['id']]) }}">{{ $result[$column['reference']] }}</a>
                                </td>
                            @elseif ($column['type'] == 'campaign_name')
                                <td class="views-value">
                                    <a class="field-nid state_{{ $result['state'] }}"
                                       href="{{ route($column['link'], [$result['id']]) }}">{{ $result[$column['reference']] }}</a>
                                    <a class="field-link margin-left"
                                       href="{{ route($column['link'], [$result['id']]) }}">{{ $result['name'] }}</a>
                                </td>
                            @elseif ($column['type'] == 'user_name')
                                <td class="views-value">
                                    <a class="field-link"
                                       href="{{ route($column['link'], [$result['id']]) }}">{{ $result[$column['reference'][0]] . ' ' . $result[$column['reference'][1]]  }}</a>
                                </td>
                            @elseif ($column['type'] == 'user_type')
                                <td class="views-value">
                                    <a class="field-link"
                                       href="{{ route($column['link'], [$result['id']]) }}">{{ reference($result, $column['reference']) ? reference($result, $column['reference']) : '-' }}</a>
                                </td>
                            @elseif ($column['type'] == 'link')
                                <td class="views-value">
                                    <a class="field-link"
                                       href="{{ route($column['link'], [$result['id']]) }}">{{ $result[$column['reference']] }}</a>
                                </td>
                            @elseif ($column['type'] == 'date')
                                <td class="views-value">
                                    <span class="field-date">{{ $result[$column['reference']]?date('M j h:i A', strtotime($result[$column['reference']])):'-' }}</span>
                                </td>
                            @elseif ($column['type'] == 'date_only')
                                <td class="views-value">
                                    <span class="field-date">{{ $result[$column['reference']]?date('M j', strtotime($result[$column['reference']])):'-' }}</span>
                                </td>
                            @elseif ($column['type'] == 'date_only_with_year')
                                <td class="views-value">
                                    <span class="field-date">{{ $result[$column['reference']]?date('M j, Y', strtotime($result[$column['reference']])):'-' }}</span>
                                </td>
                            @elseif ($column['type'] == 'date_week')
                                <td class="views-value">
                                    <span class="field-date">{{ $result[$column['reference']]?date('D, M j', strtotime($result[$column['reference']])):'-' }}</span>
                                </td>
                            @elseif ($column['type'] == 'state')
                                <td class="views-value">
                                    <a class="field-state state_{{ $result['state'] }}"
                                       href="{{ route($column['link'], [$result['id']]) }}">{!! campaign_state_caption($result[$column['reference']], true, campaign_repository()->find($result['id']), Auth::user()) !!}</a>
                                </td>
                            @elseif ($column['type'] == 'views')
                                <td class="views-value">
                                    <a class="field-views">View Total Ordered</a>
                                </td>
                            @elseif ($column['type'] == 'text')
                                <td class="views-value">
                                    <span class="field-text">{{ reference($result, $column['reference']) }}</span>
                                </td>
                            @elseif ($column['type'] == 'delivery_date')
                                <td class="views-value">
                                    @if (isset($result[$column['reference']]))
                                        <span class="field-delivery-date">{{ date('M j', strtotime($result[$column['reference']])) }}</span>
                                    @endif
                                </td>
                            @elseif ($column['type'] == 'user')
                                <td class="views-value">
                                    <span class="field-user user_{{ reference($result, $column['reference']) ? reference($result, $column['reference'])->type_code : 'none' }}">{{ reference($result, $column['reference']) ? ($column['reference'] == 'designer' ? reference($result, $column['reference'])->getFullName() : reference($result, $column['reference'])->getFullName()) : 'Unassigned' }}</span>
                                </td>
                            @elseif ($column['type'] == 'action')
                                <td class="views-value">
                                    @if (isset($column['link']['url']))
                                        <a class="field-action {{ isset($column['link']['class'])?$column['link']['class']:'' }}"
                                           href="{{ route($column['link']['url'], [$result['id']]) }}">{{ $column['link']['text'] }}</a>
                                    @else
                                        @foreach ($column['link'] as $link)
                                            <a class="field-action {{ isset($link['class'])?$link['class']:'' }}"
                                               href="{{ route($link['url'], [$result['id']]) }}">{{ $link['text'] }}</a>
                                        @endforeach
                                    @endif
                                </td>
                            @elseif ($column['type'] == 'designer_action')
                                <td class="views-value">
                                    <a class="field-action tag-action-grab" href="{{ route('dashboard::grab', [$result['id']]) }}">Claim</a>
                                    <a class="field-action tag-action-reject" href="javascript: void(0);" data-toggle="modal" data-target="#modal-reject-{{ $result['id'] }}">Reject</a>
                                    <div class="modal fade modal-override" id="modal-reject-{{ $result['id'] }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
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
                                <td class="views-value">
                                    <span class="field-quantity {{ isset($column['class'])?$column['class']:'' }}">{{ $result->getSuccessQuantity() }}</span>
                                </td>
                            @elseif ($column['type'] == 'colors')
                                <td class="views-value">
                                    <span class="field-colors {{ isset($column['class'])?$column['class']:'' }}">{{ $result[$column['reference'][0]] }}
                                        /{{ $result[$column['reference'][1]] }}</span>
                                </td>
                            @elseif ($column['type'] == 'rush')
                                <td class="views-value">
                                    <span class="field-rush {{ $result[$column['reference']]?'red-text':'blue-text' }} {{ isset($column['class'])?$column['class']:'' }}">{{ $result[$column['reference']]?'Yes':'No' }}</span>
                                </td>
                            @elseif ($column['type'] == 'school_chapter')
                                <td class="views-value">
                                    <span class="field-text {{ isset($column['class'])?$column['class']:'' }}">{{ $result[$column['reference'][0]] . '/' . $result[$column['reference'][1]] }}</span>
                                </td>
                            @elseif ($column['type'] == 'age')
                                <td class="views-value">
                                    <span class="field-text {{ isset($column['class'])?$column['class']:'' }}">{{ $result->getDecoratorAssignedAge() }}</span>
                                </td>
                            @elseif ($column['type'] == 'days_in_state')
                                <td class="views-value">
                                    <span class="field-text {{ isset($column['class'])?$column['class']:'' }}">{{ $result->getDaysInState() }}</span>
                                </td>
                            @elseif ($column['type'] == 'countdown')
                                <td class="views-value">
                                    <span class="field-text {{ isset($column['class'])?$column['class']:'' }} {{ countdown_class($result->getCountdownTime()) }}">{{ time_count($result->getCountdownTime()) }}</span>
                                </td>
                            @elseif ($column['type'] == 'embellishment')
                                <td class="views-value">
                                    <span class="field-embellishment {{ isset($column['class'])?$column['class']:'' }}">{{ embellishment_code($result) }}</span>
                                </td>
                            @elseif ($column['type'] == 'flexible')
                                <td class="views-value">
                                    <span class="field-rush {{ $result[$column['reference']] == 'yes' ?'blue-text':'red-text' }} {{ isset($column['class'])?$column['class']:'' }}">{{ $result[$column['reference']] == 'yes'?'Yes':'No' }}</span>
                                </td>
                            @else
                                <td class="views-value">{{ $result[$column['reference']] }}</td>
                            @endif
                        @endif
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {!! $results->render() !!}
        </div>
    </div>
</div>

@section ('javascript')
    <script>
        $('.user_autocomplete').each(function () {
            userAutocomplete($(this).parent().find('.user_id_autocomplete'), $(this));
        });
    </script>
    <script>
        $(".date").datepicker({
            inline: false
        });
    </script>
@append