@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Order Details</h1>
        </div>
    </div>
    {!! Form::model($model) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Order Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Order</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static"><a
                                            href="{{ route('admin::campaign::read', [$model->campaign_id]) }}">{{ $model->campaign->name }}</a>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">User</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">
                                    @if ($model->user)
                                        <a href="{{ route('admin::user::read', [$model->user_id]) }}">{{ $model->user->getFullName() }}</a>
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">State</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->state }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Payment Type</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->payment_type }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Shipping Type</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->shipping_type }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Billing Charge Id</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">
                                    @if ($model->billing_charge_id)
                                        <a href="{{ config('greekhouse.billing.providers.' . mb_strtolower($model->billing_provider) . '.dashboard_charge') }}/{{ $model->billing_charge_id }}"
                                           target="_blank">{{ $model->billing_charge_id }}</a>
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive table-bordered margin-bottom">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($sizeList as $size)
                        <tr>
                            <td>{{ $size->id }}</td>
                            <td>
                                <a href="{{ route('admin::product::read', [$model->product->id]) }}">{{ $model->product->name }}</a>
                            </td>
                            <td>{{ $size->short }}</td>
                            <td>-</td>
                            <td>{!! Form::text('quantity_' . $size->short, old('quantity_' . $size->short), ['class' => 'form-control']) !!}</td>
                            <td>-</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Total Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Subtotal</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">${{ number_format($model->subtotal, 2) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Tax</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">${{ number_format($model->tax, 2) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Shipping</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">${{ number_format($model->shipping, 2) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Total</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">${{ number_format($model->total, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Shipping Information
                    @if ($model->payment_type == 'individual' && $model->shipping_type == 'individual')
                        (Individual Shipping)
                    @else
                        (Group Shipping)
                    @endif
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        @if ($model->payment_type == 'individual' && $model->shipping_type == 'individual')
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Line 1</label>
                                </div>
                                <div class="col-sm-9">
                                    {!! Form::text('shipping_line1', old('shipping_line1'), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Line 2</label>
                                </div>
                                <div class="col-sm-9">
                                    {!! Form::text('shipping_line2', old('shipping_line2'), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">City</label>
                                </div>
                                <div class="col-sm-9">
                                    {!! Form::text('shipping_city', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">State</label>
                                </div>
                                <div class="col-sm-9">
                                    {!! Form::text('shipping_state', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Zip Code</label>
                                </div>
                                <div class="col-sm-9">
                                    {!! Form::text('shipping_zip_code', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Country</label>
                                </div>
                                <div class="col-sm-9">
                                    {!! Form::select('shipping_country', country_options(), null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        @else
                            <a href="{{ route('admin::campaign::read', [$model->campaign_id]) }}">See Order Shipping
                                Address</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Billing Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->billing_first_name }} {{ $model->billing_last_name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Line 1</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->billing_line1 }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Line 2</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->billing_line2 }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">City</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->billing_city }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">State</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->billing_state }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Zip Code</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->billing_zip_code }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Country</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->billing_country }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class=" action-area pull-right">
                <a href="{{ URL::previous() }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection