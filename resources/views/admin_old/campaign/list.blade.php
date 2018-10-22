@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Campaigns</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Campaigns
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="admin-filter">
                        {!! Form::open(['method' => 'get', 'class' => 'form-inline margin-bottom ']) !!}
                        Filter by:
                        {!! Form::text('filter_campaign_id', Request::has('filter_campaign_id')?Request::get('filter_campaign_id'):'', ['placeholder' => 'Campaign Id', 'class' => 'form-control']) !!}
                        {!! Form::text('filter_campaign_name', Request::has('filter_campaign_name')?Request::get('filter_campaign_name'):'', ['placeholder' => 'Campaign Name', 'class' => 'form-control']) !!}
                        {!! Form::text('filter_user_name', Request::has('filter_user_name')?Request::get('filter_user_name'):'', ['placeholder' => 'User Name', 'class' => 'form-control']) !!}
                        {!! Form::select('filter_campaign_state', campaign_state_options(['' => 'Filter by State']), Request::has('filter_campaign_state')?Request::get('filter_campaign_state'):'', ['class' => 'form-control']) !!}
                        {!! Form::text('filter_campaign_updated_from', Request::has('filter_campaign_updated_from')?Request::get('filter_campaign_updated_from'):'', ['placeholder' => 'Updated From', 'class' => 'form-control datepicker']) !!}
                        {!! Form::text('filter_campaign_updated_to', Request::has('filter_campaign_updated_to')?Request::get('filter_campaign_updated_to'):'', ['placeholder' => 'Updated To', 'class' => 'form-control datepicker']) !!}
                        <button type="submit" name="filter" value="filter" class="btn btn-info">Apply</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="table-responsive table-bordered" id="campaign-list">
                        <table class="table">
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
                        {!! $list->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class=" action-area pull-right">
                <a href="{{ route('admin::campaign::create') }}" class="btn btn-success">Create</a>
            </div>
        </div>
    </div>
@endsection

@section ('javascript')
    <link href="{{ static_asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    <script src="{{ static_asset('js/jquery-ui.min.js') }}"></script>
    <script>
        $(".datepicker").datepicker({
            inline: false
        });
    </script>
@append