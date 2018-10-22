@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Designs</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Designs
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="admin-filter">
                        {!! Form::open(['method' => 'get', 'class' => 'form-inline margin-bottom ']) !!}
                        Filter by:
                        {!! Form::text('name', Request::has('name') ? Request::get('name') : '', ['placeholder' => 'Design Name', 'class' => 'form-control']) !!}
                        {!! Form::text('campaign_name', Request::has('campaign_name') ? Request::get('campaign_name') : '', ['placeholder' => 'Campaign Name', 'class' => 'form-control']) !!}
                        <button type="submit" name="filter" value="filter" class="btn btn-info">Apply</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="table-responsive table-bordered" id="design-list">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Campaign</th>
                                <th>Active</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($list as $entry)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>
                                        <a href="{{ route('admin::design::read', [$entry->id]) }}">{{ $entry->name }}</a>
                                    </td>
                                    <td>
                                        @if ($entry->campaign_id)
                                            <a href="{{ route('admin::campaign::read', [$entry->campaign_id]) }}">{{ $entry->campaign->name }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if (! $entry->campaign_id || $entry->campaign->designs->first()->active)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>
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
                <a href="{{ route('admin::design::create') }}" class="btn btn-success">Create</a>
            </div>
        </div>
    </div>
@endsection