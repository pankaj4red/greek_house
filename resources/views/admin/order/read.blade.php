@extends ('admin.layouts.admin')

@section ('content')
    <h1 class="page-header mb-4 pb-3 border-bottom">Order Details</h1>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    General Information
                    <a href="{{ route('admin::order::update', [$order->id]) }}" class="btn btn-secondary float-right">Edit</a>
                    @if (in_array($order->state, ['new', 'failed']))
                        {{Form::open(['route' => ['admin::order::cancel', $order->id], 'class' => 'd-inline-block mr-2 float-right']) }}
                        <button type="submit" class="btn btn-danger float-right">Cancel</button>
                        {{Form::close() }}
                    @endif
                    @if ($order->state == 'success')
                        {{Form::open(['route' => ['admin::order::refund', $order->id], 'class' => 'd-inline-block mr-2 float-right']) }}
                        <button type="submit" class="btn btn-warning float-right">Refund</button>
                        {{Form::close() }}
                    @endif
                    @if (in_array($order->state, ['authorized', 'authorized_failed']))
                        {{Form::open(['route' => ['admin::order::void', $order->id], 'class' => 'd-inline-block mr-2 float-right']) }}
                        <button type="submit" class="btn btn-info float-right">Void</button>
                        {{Form::close() }}
                    @endif
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Id</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $order->id }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Campaign</label>
                        <div class="col-12 col-sm-7 col-form-label"><a href="{{ route('admin::campaign::read', [$order->campaign_id]) }}">{{ $order->campaign->name }}</a></div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">User</label>
                        <div class="col-12 col-sm-7 col-form-label">
                            @if ($order->user)
                                <a href="{{ route('admin::user::read', [$order->user_id]) }}">{{ $order->user->getFullName() }}</a>
                            @else
                                N/A
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">State</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $order->state }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Payment Type</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $order->payment_type }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Shipping Type</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $order->shipping_type }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Billing Provider</label>
                        <div class="col-12 col-sm-7 col-form-label">
                            {{ $order->billing_provider }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Billing Charge Id</label>
                        <div class="col-12 col-sm-7 col-form-label">
                            {{ $order->billing_charge_id }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Billing Authorization Id</label>
                        <div class="col-12 col-sm-7 col-form-label">
                            {{ $order->billing_authorization_id }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Billing Settlement Id</label>
                        <div class="col-12 col-sm-7 col-form-label">
                            {{ $order->billing_settlement_id }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Billing Information
                    <a href="{{ route('admin::order::update', [$order->id]) }}" class="btn btn-secondary float-right">Edit</a>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Name</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $order->billing_first_name }} {{ $order->billing_last_name }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Line 1</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $order->billing_line1 }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Line 2</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $order->billing_line2 }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">City</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $order->billing_city }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">State</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $order->billing_state }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Zip Code</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ $order->billing_zip_code }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Shipping Information
                    @if ($order->shipping_type == 'individual')
                        (Individual)
                    @else
                        (Group)
                    @endif
                    <a href="{{ route('admin::order::update', [$order->id]) }}" class="btn btn-secondary float-right">Edit</a>
                </div>
                <div class="card-body">
                    @if ($order->shipping_type == 'individual')
                        <div class="form-group row">
                            <label class="col-12 col-sm-5 col-form-label text-right">Line 1</label>
                            <div class="col-12 col-sm-7 col-form-label">{{ $order->shipping_line1 }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-5 col-form-label text-right">Line 2</label>
                            <div class="col-12 col-sm-7 col-form-label">{{ $order->shipping_line2 }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-5 col-form-label text-right">City</label>
                            <div class="col-12 col-sm-7 col-form-label">{{ $order->shipping_city }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-5 col-form-label text-right">State</label>
                            <div class="col-12 col-sm-7 col-form-label">{{ $order->shipping_state }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-5 col-form-label text-right">Zip Code</label>
                            <div class="col-12 col-sm-7 col-form-label">{{ $order->shipping_zip_code }}</div>
                        </div>
                    @else
                        <a href="{{ route('admin::campaign::read', [$order->campaign_id]) }}">See Order Shipping Address</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Entries
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Color</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($order->entries as $entry)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>
                                        <a href="{{ route('admin::product::read', [$entry->product_color->product_id]) }}">{{ $entry->product_color->product->name }} - {{ $entry->product_color->name }}</a>
                                    </td>
                                    <td>{{ $entry->size->short }}</td>
                                    <td>${{ number_format($entry->price, 2) }}</td>
                                    <td>{{ $entry->quantity }}</td>
                                    <td>${{ number_format($entry->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="4"><strong>Total</strong></td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ money($order->subtotal) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Tax</strong></td>
                                <td>&nbsp;</td>
                                <td>{{ money($order->tax) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Shipping</strong></td>
                                <td>&nbsp;</td>
                                <td>{{ money($order->shipping) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Total</strong></td>
                                <td>&nbsp;</td>
                                <td>{{ money($order->total) }}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@append
