@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Orders</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Orders
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="admin-filter">
                        {!! Form::open(['method' => 'get', 'class' => 'form-inline margin-bottom ']) !!}
                        Filter by:
                        {!! Form::text('filter_order_id', Request::has('filter_order_id')?Request::get('filter_order_id'):'', ['placeholder' => 'Order Id', 'class' => 'form-control']) !!}
                        {!! Form::text('filter_campaign_id', Request::has('filter_campaign_id')?Request::get('filter_campaign_id'):'', ['placeholder' => 'Campaign Id', 'class' => 'form-control']) !!}
                        {!! Form::text('filter_campaign_username', Request::has('filter_campaign_username')?Request::get('filter_campaign_username'):'', ['placeholder' => 'Campaign Contact Name', 'class' => 'form-control']) !!}
                        {!! Form::text('filter_campaign_name', Request::has('filter_campaign_name')?Request::get('filter_campaign_name'):'', ['placeholder' => 'Campaign Name', 'class' => 'form-control']) !!}
                        {!! Form::text('filter_order_name', Request::has('filter_order_name')?Request::get('filter_order_name'):'', ['placeholder' => 'Order\'s Contact Name', 'class' => 'form-control']) !!}
                        {!! Form::text('filter_order_email', Request::has('filter_order_email')?Request::get('filter_order_email'):'', ['placeholder' => 'Order Contact Email', 'class' => 'form-control']) !!}
                        <button type="submit" name="filter" value="filter" class="btn btn-info">Apply</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="table-responsive table-bordered">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Campaign</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Last Updated</th>
                                <th>State</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($list as $entry)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>
                                        <a href="{{ route('admin::campaign::read', [$entry->campaign->id]) }}">{{ $entry->campaign->name }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin::order::read', [$entry->id]) }}">{{ $entry->payment_type }}
                                            Order {{ ($entry->payment_type=='individual')?' / ' . $entry->shipping_type . ' Shipping':'' }}</a>
                                    </td>
                                    <td>${{ number_format($entry->total, 2) }}</td>
                                    <td>{{ date('m/d/Y h:i a', strtotime($entry->created_at)) }}</td>
                                    <td>{{ date('m/d/Y h:i a', strtotime($entry->updated_at)) }}</td>
                                    <td>{{ $entry->state }}</td>
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
@endsection