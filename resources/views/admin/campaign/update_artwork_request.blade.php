@extends ('admin.layouts.admin')

@section ('content')
    {{ Form::open() }}
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Campaign Proofs
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-right">Print Type</label>
                                <div class="col-12 col-sm-9">{{ Form::select('design_type', design_type_options(), $campaign->artwork_request->design_type, ['class' => 'form-control', 'id' => 'design_type']) }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-right">Design Hours</label>
                                <div class="col-12 col-sm-9">{{ Form::text('design_hours', to_hours($campaign->artwork_request->design_minutes), ['class' => 'form-control']) }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-right">Hourly Rate</label>
                                <div class="col-12 col-sm-9">{{ Form::text('hourly_rate', $campaign->artwork_request->hourly_rate, ['class' => 'form-control']) }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-right">Revision Text</label>
                                <div class="col-12 col-sm-9">{{ Form::textarea('revision_text', $campaign->artwork_request->revision_text, ['class' => 'form-control']) }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <div class="text-lg">Printing - Front</div>
                                <hr/>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-right">Enabled</label>
                                    <div class="col-12 col-sm-9">{{ Form::select('print_front', yes_no_repository()->options(), $campaign->artwork_request->print_front ? 'yes' : 'no', ['class' => 'form-control']) }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-right">No. of Colors</label>
                                    <div class="col-12 col-sm-9">{{ Form::select('print_front_colors', color_options('front', [], false), $campaign->artwork_request->print_front_colors, ['class' => 'form-control form-number-counter', 'id' => 'print_front_nr_colors']) }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-right">Description</label>
                                    <div class="col-12 col-sm-9">{{ Form::textarea('print_front_description', $campaign->artwork_request->print_front_description, ['class' => 'form-control', 'rows' => 5, 'cols' => 30, 'autocomplete' => 'off']) }}</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="text-lg">Printing - Pocket</div>
                                <hr/>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-right">Enabled</label>
                                    <div class="col-12 col-sm-9">{{ Form::select('print_pocket', yes_no_repository()->options(), $campaign->artwork_request->print_pocket ? 'yes' : 'no', ['class' => 'form-control']) }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-right">No. of Colors</label>
                                    <div class="col-12 col-sm-9">{{ Form::select('print_pocket_colors', color_options('pocket', [], false), $campaign->artwork_request->print_pocket_colors, ['class' => 'form-control form-number-counter', 'id' => 'print_pocket_nr_colors']) }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-right">Description</label>
                                    <div class="col-12 col-sm-9">{{ Form::textarea('print_pocket_description', $campaign->artwork_request->print_pocket_description, ['class' => 'form-control', 'rows' => 5, 'cols' => 30, 'autocomplete' => 'off']) }}</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="text-lg">Printing - Back</div>
                                <hr/>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-right">Enabled</label>
                                    <div class="col-12 col-sm-9">{{ Form::select('print_back', yes_no_repository()->options(), $campaign->artwork_request->print_back ? 'yes' : 'no', ['class' => 'form-control']) }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-right">No. of Colors</label>
                                    <div class="col-12 col-sm-9">{{ Form::select('print_back_colors', color_options('back', [], false), $campaign->artwork_request->print_back_colors, ['class' => 'form-control form-number-counter', 'id' => 'print_back_nr_colors']) }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-right">Description</label>
                                    <div class="col-12 col-sm-9">{{ Form::textarea('print_back_description', $campaign->artwork_request->print_back_description, ['class' => 'form-control', 'rows' => 5, 'cols' => 30, 'autocomplete' => 'off']) }}</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="text-lg">Printing - Sleeves</div>
                                <hr/>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-right">Enabled</label>
                                    <div class="col-12 col-sm-9">{{ Form::select('print_sleeve', yes_no_repository()->options(), $campaign->artwork_request->print_sleeves ? 'yes' : 'no', ['class' => 'form-control']) }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-right">Preferred Sleeve</label>
                                    <div class="col-12 col-sm-9">{{ Form::select('print_sleeve_preferred', sleeve_options(), $campaign->artwork_request->print_sleeve_preferred, ['class' => 'form-control form-number-counter', 'id' => 'print_sleeve_preferred']) }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-right">No. of Colors</label>
                                    <div class="col-12 col-sm-9">{{ Form::select('print_sleeve_colors', color_options('sleeve', [], false), $campaign->artwork_request->print_sleeve_colors, ['class' => 'form-control form-number-counter', 'id' => 'print_sleeve_nr_colors']) }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-right">Description</label>
                                    <div class="col-12 col-sm-9">{{ Form::textarea('print_sleeve_description', $campaign->artwork_request->print_sleeve_description, ['class' => 'form-control', 'rows' => 5, 'cols' => 30, 'autocomplete' => 'off']) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('admin::campaign::read', [$campaign->id]) }}" class="btn btn-default btn-back">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
