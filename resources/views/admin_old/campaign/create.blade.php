@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create Campaign</h1>
        </div>
    </div>
    {{ Form::open() }}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Basic Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('name', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">State</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('state', campaign_state_options(), null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Flexible Date</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {{ Form::radio('flexible', 'yes', true) }}Yes
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('flexible', 'no', false) }}No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Requested Date</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('date', null, ['class' => 'form-control datepicker']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Print Type</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('design_type', design_type_options(), 'screen', ['class' => 'form-control', 'id' => 'print_type']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Estimated Quantity</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('estimated_quantity', estimated_quantity_options('screen'), '24-47', ['class' => 'form-control', 'id' => 'estimated_quantity']) }}
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
                <a href="{{ route('admin::campaign::list') }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section ('javascript')
    @include ('partials.enable_print_type')
    <script>
        printType('#print_type', '#estimated_quantity');
    </script>
    <link href="{{ static_asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    <script src="{{ static_asset('js/jquery-ui.min.js') }}"></script>
    <script>
        $(".datepicker").datepicker({
            inline: false
        });
    </script>
@append
