@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Campaign Artwork Request</h1>
        </div>
    </div>
    {{ Form::open() }}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Proofs
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Print Type</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('design_type', design_type_options(), $campaign->artwork_request->design_type, ['class' => 'form-control', 'id' => 'design_type']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Design Hours</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('design_hours', to_hours($campaign->artwork_request->design_minutes), ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Hourly Rate</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('hourly_rate', $campaign->artwork_request->hourly_rate, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Proofs</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="file-list">
                                    @for($i = 0; $i < 10; $i++)
                                        @include ('partials.image_picker', [
                                            'fieldName' => 'proof' . $i,
                                            'fieldType' => 'image',
                                            'fieldData' => isset(${'proof' . $i}) ? ${'proof' . $i} : null
                                        ])
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Revision Text</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::textarea('revision_text', $campaign->artwork_request->revision_text, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Printing - Front
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Enabled</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {{ Form::radio('print_front', 'yes', $campaign->artwork_request->print_front) }}Yes
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('print_front', 'no', ! $campaign->artwork_request->print_front) }}No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Colors</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('print_front_colors', color_options('front'), $campaign->artwork_request->print_front_colors, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::textarea('print_front_description', $campaign->artwork_request->print_front_description, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Printing - Pocket
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Enabled</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {{ Form::radio('print_pocket', 'yes', $campaign->artwork_request->print_pocket) }}Yes
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('print_pocket', 'no', ! $campaign->artwork_request->print_pocket) }}No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Colors</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('print_pocket_colors', color_options('pocket'), $campaign->artwork_request->print_pocket_colors, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::textarea('print_pocket_description', $campaign->artwork_request->print_pocket_description, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Printing - Back
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Enabled</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {{ Form::radio('print_back', 'yes', $campaign->artwork_request->print_back) }}Yes
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('print_back', 'no', ! $campaign->artwork_request->print_back) }}No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Colors</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('print_back_colors', color_options('back'), $campaign->artwork_request->print_back_colors, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::textarea('print_back_description', $campaign->artwork_request->print_back_description, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Printing - Sleeves
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Enabled</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {{ Form::radio('print_sleeve', 'yes', $campaign->artwork_request->print_sleeve) }}Yes
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('print_sleeve', 'no', ! $campaign->artwork_request->print_sleeve) }}No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Sleeve</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {{ Form::radio('print_sleeve_preferred', 'left', $campaign->artwork_request->print_sleeve_preferred == 'left') }}
                                    Left
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('print_sleeve_preferred', 'right', $campaign->artwork_request->print_sleeve_preferred == 'right') }}
                                    Right
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('print_sleeve_preferred', 'both', $campaign->artwork_request->print_sleeve_preferred == 'both') }}
                                    Both
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Colors</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('print_sleeve_colors', color_options('sleeve'), $campaign->artwork_request->print_sleeve_colors, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::textarea('print_sleeve_description', $campaign->artwork_request->print_sleeve_description, ['class' => 'form-control']) }}
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
                <a href="{{ route('admin::campaign::read', [$campaign->id]) }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section ('javascript')
    @include ('partials.enable_filepicker')
@append
