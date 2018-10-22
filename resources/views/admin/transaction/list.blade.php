@extends ('admin.layouts.admin')

@section ('content')
    <h1 class="page-header mb-4 pb-3 border-bottom">Transactions</h1>
    <div class="card">
        <div class="card-header">Transactions</div>
        <div class="card-body">
            <div class="mb-3">
                {{ Form::open(['method' => 'get', 'class' => 'form-inline']) }}
                <span class="my-1 mr-sm-2">Filter by:</span>
                {{ Form::text('filter_transaction_id', Request::has('filter_transaction_id')?Request::get('filter_transaction_id'):'', ['placeholder' => 'Transaction Id', 'class' => 'form-control my-1 mr-sm-2']) }}
                {{ Form::text('filter_campaign_id', Request::has('filter_campaign_id')?Request::get('filter_campaign_id'):'', ['placeholder' => 'Campaign Id', 'class' => 'form-control my-1 mr-sm-2']) }}
                {{ Form::text('filter_campaign_name', Request::has('filter_campaign_name')?Request::get('filter_campaign_name'):'', ['placeholder' => 'Campaign Name', 'class' => 'form-control my-1 mr-sm-2']) }}
                {{ Form::text('filter_user_name', Request::has('filter_user_name')?Request::get('filter_user_name'):'', ['placeholder' => 'User Name', 'class' => 'form-control my-1 mr-sm-2']) }}
                {{ Form::text('filter_order_id', Request::has('filter_order_id')?Request::get('filter_order_id'):'', ['placeholder' => 'Order Id', 'class' => 'form-control my-1 mr-sm-2']) }}
                {{ Form::select('filter_campaign_state', campaign_state_options(['' => 'Filter by Campaign State']), Request::has('filter_campaign_state')?Request::get('filter_campaign_state'):'', ['class' => 'form-control my-1 mr-sm-2']) }}
                {{ Form::select('filter_order_state', campaign_state_options(['' => 'Filter by Order State']), Request::has('filter_order_state')?Request::get('filter_order_state'):'', ['class' => 'form-control my-1 mr-sm-2']) }}
                {{ Form::text('filter_created_from', Request::has('filter_created_from')?Request::get('filter_created_from'):'', ['placeholder' => 'Created From', 'class' => 'form-control datepicker my-1 mr-sm-2']) }}
                {{ Form::text('filter_created_to', Request::has('filter_created_to')?Request::get('filter_created_to'):'', ['placeholder' => 'Created To', 'class' => 'form-control datepicker my-1 mr-sm-2']) }}
                <button type="submit" name="filter" value="filter" class="btn btn-info">Apply</button>
                {{ Form::close() }}
            </div>
            <div class="table-responsive mb-3">
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Campaign</th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Provider</th>
                        <th>Action</th>
                        <th>Result</th>
                        <th>Created</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $entry)
                        <tr>
                            <td><a href="{{ route('admin::transaction::read', [$entry->id]) }}">{{ $entry->id }}</a></td>
                            <td>
                                <a href="{{ route('admin::campaign::read', [$entry->order->campaign_id]) }}">#{{ $entry->order->campaign_id }} - {{ $entry->order->campaign->name }} ({{ campaign_state_caption($entry->order->campaign->state) }})</a>
                            </td>
                            <td><a href="{{ route('admin::order::read', [$entry->order_id]) }}">#{{ $entry->order_id }} ({{ $entry->order->state }})</a></td>
                            @if ($entry->order->user_id)
                                <td><a href="{{ route('admin::user::read', [$entry->order->user_id]) }}">{{ $entry->order->user->getFullName() }}</a></td>
                            @else
                                <td>{{ $entry->order->getContactFullName() }}</td>
                            @endif
                            <td>{{ strtolower($entry->billing_provider) }}</td>
                            <td><a href="{{ route('admin::transaction::read', [$entry->id]) }}">{{ $entry->action }}</a></td>
                            <td>
                                {{ $entry->result }}
                                @if ($entry->message)
                                    ({{ $entry->message }})
                                @endif
                            </td>
                            <td>{{ $entry->created_at->format('m/d/Y h:i a') }}</td>
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