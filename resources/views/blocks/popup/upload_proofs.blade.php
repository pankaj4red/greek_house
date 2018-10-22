@extends ('customer')

@section ('title', 'Proofs Information')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">UPLOAD PROOFS</div>
        <div class="popup-body">
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            {{ Form::open(['id' => 'ajax-form']) }}
            <div class="ajax-messages"></div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Front Colors<i class="required">*</i></label>
                        {{ Form::select('designer_colors_front', color_options('front'), $campaign->artwork_request->designer_colors_front, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Back Colors<i class="required">*</i></label>
                        {{ Form::select('designer_colors_back', color_options('back'), $campaign->artwork_request->designer_colors_back, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Sleeve Left Colors<i class="required">*</i></label>
                        {{ Form::select('designer_colors_sleeve_left', color_options('sleeve'), $campaign->artwork_request->designer_colors_sleeve_left, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Sleeve Right Colors<i class="required">*</i></label>
                        {{ Form::select('designer_colors_sleeve_right', color_options('sleeve'), $campaign->artwork_request->designer_colors_sleeve_right, ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Front Color List</label>
                        {{ Form::text('designer_colors_front_list', $campaign->artwork_request->designer_colors_front_list, ['class' => 'form-control', 'placeholder' => '#111111,#222222,#333333']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Back Color List</label>
                        {{ Form::text('designer_colors_back_list', $campaign->artwork_request->designer_colors_back_list, ['class' => 'form-control', 'placeholder' => '#111111,#222222,#333333']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Sleeve Left Color List</label>
                        {{ Form::text('designer_colors_sleeve_left_list', $campaign->artwork_request->designer_colors_sleeve_left_list, ['class' => 'form-control', 'placeholder' => '#111111,#222222,#333333']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Sleeve Right Color List</label>
                        {{ Form::text('designer_colors_sleeve_right_list', $campaign->artwork_request->designer_colors_sleeve_right_list, ['class' => 'form-control', 'placeholder' => '#111111,#222222,#333333']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Front Dimensions</label>
                        {{ Form::text('designer_dimensions_front', $campaign->artwork_request->designer_dimensions_front, ['class' => 'form-control', 'placeholder' => '12”L 14”W']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Back Dimensions</label>
                        {{ Form::text('designer_dimensions_back', $campaign->artwork_request->designer_dimensions_back, ['class' => 'form-control', 'placeholder' => '12”L 14”W']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Sleeve Left Dimensions</label>
                        {{ Form::text('designer_dimensions_sleeve_left', $campaign->artwork_request->designer_dimensions_sleeve_left, ['class' => 'form-control', 'placeholder' => '12”L 14”W']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Sleeve Right Dimensions</label>
                        {{ Form::text('designer_dimensions_sleeve_right', $campaign->artwork_request->designer_dimensions_sleeve_right, ['class' => 'form-control', 'placeholder' => '12”L 14”W']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Black Shirt<i class="required">*</i></label>
                        {{ Form::select('designer_black_shirt', yes_no_options(), $campaign->artwork_request->designer_black_shirt ? 'yes' : 'no', ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Design Hours<i class="required">*</i></label>
                        <div class="input-composite">
                            {{ Form::text('design_hours', to_hours($campaign->artwork_request->design_minutes), ['class' => 'form-control', 'placeholder' => 'Design Hours', 'id' => 'design_hours']) }}
                            <span class="input-composite-addon"><img
                                        src="{{ static_asset('images/icon-watch-small.png') }}" alt="Watch"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Print Type<i class="required">*</i></label>
                        {{ Form::select('design_type', design_type_options(), $campaign->artwork_request->design_type, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Speciality Inks<i class="required">*</i></label>
                        {{ Form::select('speciality_inks', yes_no_options(), $campaign->artwork_request->speciality_inks, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Embellishment Names<i class="required">*</i></label>
                        {{ Form::select('embellishment_names', yes_no_options(), $campaign->artwork_request->embellishment_names, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="design_hours">Embellishment Numbers<i class="required">*</i></label>
                        {{ Form::select('embellishment_numbers', yes_no_options(), $campaign->artwork_request->embellishment_numbers, ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($campaign->product_colors as $productColor)
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ $productColor->product->name }} - {{ $productColor->name }} Design Files</label>
                            <div class="file-list">
                                @include ('partials.image_picker', [
                                    'label'     => 'Front',
                                    'fieldName' => 'proof' . $productColor->id . '_front',
                                    'fieldType' => 'image',
                                    'fieldData' => isset($proofs->products[$productColor->id]->front) ? $proofs->products[$productColor->id]->front : null
                                ])
                                @include ('partials.image_picker', [
                                    'label'     => 'Back',
                                    'fieldName' => 'proof' . $productColor->id . '_back',
                                    'fieldType' => 'image',
                                    'fieldData' => isset($proofs->products[$productColor->id]->back) ? $proofs->products[$productColor->id]->back : null
                                ])
                                @include ('partials.image_picker', [
                                    'label'     => 'Close Up',
                                    'fieldName' => 'proof' . $productColor->id . '_close_up',
                                    'fieldType' => 'image',
                                    'fieldData' => isset($proofs->products[$productColor->id]->close_up) ? $proofs->products[$productColor->id]->close_up : null
                                ])
                                @include ('partials.image_picker', [
                                    'label'     => 'Other',
                                    'fieldName' => 'proof' . $productColor->id . '_other',
                                    'fieldType' => 'image',
                                    'fieldData' => isset($proofs->products[$productColor->id]->other) ? $proofs->products[$productColor->id]->other : null
                                ])
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Generic Design Files (old)</label>
                        <div class="file-list">
                            @for($i = 0; $i < 10; $i++)
                                @include ('partials.image_picker', [
                                    'fieldName' => 'proof' . $i,
                                    'fieldType' => 'image',
                                    'fieldData' => isset($proofs->generic['proof' . $i]) ? $proofs->generic['proof' . $i] : null
                                ])
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            <div class="action-row">
                <a href="{{ $back }}" class="button-back btn btn-default back-btn">Cancel</a>
                <button type="submit" name="save" value="save" class="btn btn-primary" id="popup-ajax-button">Save
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    @if (!Request::ajax())
        {!! '</div>' !!}
    @endif
@endsection

@section ('include')
    @if (!Request::ajax())
        @include ('partials.enable_filepicker')
    @endif
@append
