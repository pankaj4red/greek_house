@extends ('admin.layouts.admin')

@section ('content')
    <h1 class="page-header mb-4 pb-3 border-bottom">Campaigns</h1>
    <div class="card">
        <div class="card-header">Campaigns</div>
        <div class="card-body">
            <div class="mb-3">
                {{ Form::open(['method' => 'get', 'class' => 'form-inline']) }}
                <span class="my-1 mr-sm-2">Filter by:</span>
                {{ Form::text('filter_campaign_id', Request::has('filter_campaign_id')?Request::get('filter_campaign_id'):'', ['placeholder' => 'Campaign Id', 'class' => 'form-control my-1 mr-sm-2']) }}
                {{ Form::text('filter_campaign_name', Request::has('filter_campaign_name')?Request::get('filter_campaign_name'):'', ['placeholder' => 'Campaign Name', 'class' => 'form-control my-1 mr-sm-2']) }}
                {{ Form::text('filter_user_name', Request::has('filter_user_name')?Request::get('filter_user_name'):'', ['placeholder' => 'User Name', 'class' => 'form-control my-1 mr-sm-2']) }}
                {{ Form::select('filter_campaign_state', campaign_state_options(['' => 'Filter by State']), Request::has('filter_campaign_state')?Request::get('filter_campaign_state'):'', ['class' => 'form-control my-1 mr-sm-2']) }}
                {{ Form::text('filter_campaign_updated_from', Request::has('filter_campaign_updated_from')?Request::get('filter_campaign_updated_from'):'', ['placeholder' => 'Updated From', 'class' => 'form-control datepicker my-1 mr-sm-2']) }}
                {{ Form::text('filter_campaign_updated_to', Request::has('filter_campaign_updated_to')?Request::get('filter_campaign_updated_to'):'', ['placeholder' => 'Updated To', 'class' => 'form-control datepicker my-1 mr-sm-2']) }}
                <button type="submit" name="filter" value="filter" class="btn btn-info">Apply</button>
                {{ Form::close() }}
            </div>
            <div class="table-responsive mb-3">
                <table class="table table-sm" id="campaign-list">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Client</th>
                        <th>Designer</th>
                        <th>Last Updated</th>
                        <th>State</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $entry)
                        <tr>
                            <td>{{ $entry->id }}</td>
                            <td>
                                <a href="{{ route('admin::campaign::read', [$entry->id]) }}">{{ $entry->name }}</a>
                            </td>
                            <td>
                                @if ($entry->user)
                                    <a href="{{ route('admin::user::read', [$entry->user->id]) }}">{{ $entry->user->getFullName() }}</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if ($entry->artwork_request->designer_id)
                                    <a href="{{ route('admin::user::read', [$entry->artwork_request->designer_id]) }}">{{ $entry->artwork_request->designer->getFullName() }}</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $entry->updated_at->format('m/d/Y h:i a') }}</td>
                            <td>{{ campaign_state_caption($entry->state) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pull-left">
                <div class="table-entries">
                    Showing {{ ($list->currentPage()-1) * $list->perPage() + 1 }}
                    to {{ (($list->currentPage()-1) * $list->perPage()) + $list->count() }}
                    of {{ $list->total() }} entries
                </div>
            </div>
            <div class="pull-right">
                {{ $list->appends(\Request::except('page'))->render() }}
            </div>
        </div>
    </div>
@endsection