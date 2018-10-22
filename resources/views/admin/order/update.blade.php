@extends ('admin.layouts.admin')

@section ('content')
    {{ Form::open() }}
    <h1 class="page-header mb-4 pb-3 border-bottom">Order Details</h1>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    General Information
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Shipping Type</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ Form::select('shipping_type', ['group' => 'Group', 'individual' => 'Individual'], $order->shipping_type, ['class' => 'form-control']) }}</div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Billing Information
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">First Name</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ Form::text('billing_first_name', $order->billing_first_name, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Last Name</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ Form::text('billing_last_name', $order->billing_last_name, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Line 1</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ Form::text('billing_line1', $order->billing_line1, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Line 2</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ Form::text('billing_line2', $order->billing_line2, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">City</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ Form::text('billing_city', $order->billing_city, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">State</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ Form::text('billing_state', $order->billing_state, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Zip Code</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ Form::text('billing_zip_code', $order->billing_zip_code, ['class' => 'form-control']) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Shipping Information
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Line 1</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ Form::text('shipping_line1', $order->shipping_line1, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Line 2</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ Form::text('shipping_line2', $order->shipping_line2, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">City</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ Form::text('shipping_city', $order->shipping_city, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">State</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ Form::text('shipping_state', $order->shipping_state, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-5 col-form-label text-right">Zip Code</label>
                        <div class="col-12 col-sm-7 col-form-label">{{ Form::text('shipping_zip_code', $order->shipping_zip_code, ['class' => 'form-control']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="text-right">
                <a href="{{ URL::previous() }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection