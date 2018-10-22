@extends ('admin.layouts.admin')

@section ('content')
    {{ Form::open() }}
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Transactions
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Campaign</label>
                        <div class="col-12 col-sm-7 col-form-label">
                            <a href="{{ route('admin::campaign::read', [$transaction->order->campaign_id]) }}">{{ $transaction->order->campaign->name }}</a>
                            [<a href="{{ route('admin::transaction::list') }}?filter_campaign_id={{ $transaction->order->campaign_id }}">List Transactions</a>]
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Order</label>
                        <div class="col-12 col-sm-7 col-form-label">
                            <a href="{{ route('admin::order::read', [$transaction->order_id]) }}">#{{ $transaction->order_id }}</a>
                            [<a href="{{ route('admin::transaction::list') }}?filter_order_id={{ $transaction->order_id }}">List Transactions</a>]
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Customer</label>
                        <div class="col-12 col-sm-7 col-form-label">
                            @if ($transaction->order->user_id)
                                <a href="{{ route('admin::order::read', [$transaction->order_id]) }}">#{{ $transaction->order_id }}</a>
                            @else
                                {{ $transaction->order->getContactFullName() }}
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Action</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $transaction->action }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Amount</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ money($transaction->amount) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Result</label>
                        <div class="col-12 col-sm-7 col-form-label">
                            {{ $transaction->result }}
                            @if ($transaction->message)
                                ({{ $transaction->message }})
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Billing Provider</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $transaction->billing_provider }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Billing Customer Id</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $transaction->billing_customer_id }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Billing Method</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $transaction->billing_payment_method }}</div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-12 col-form-label">
                            <pre>{{ $transaction->billing_details ? format_json($transaction->billing_details) : 'N/A' }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
