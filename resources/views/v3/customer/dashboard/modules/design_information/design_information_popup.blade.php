@extends('v3.layouts.campaign')

@section('title', 'Design Information')

@section('content_campaign')
    {{ Form::open() }}
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="form-group required">
                <label>Print Type</label>
                {{ Form::select('design_type', design_type_options(), $campaign->artwork_request->design_type, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group required">
                <label>Dark Garment</label>
                {{ Form::select('designer_black_shirt', yes_no_options(), $campaign->artwork_request->designer_black_shirt ? 'yes' : 'no', ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group required">
                <label for="contact_first_name">Design Hours</label>
                {{ Form::text('design_hours', to_hours($campaign->artwork_request->design_minutes), ['class' => 'form-control', 'placeholder' => 'Design Hours', 'id' => 'design_hours']) }}
                <span class="input-composite-addon"><img src="{{ static_asset('images/icon-watch-small.png') }}" alt="Watch"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="form-group required">
                <label>Speciality Inks</label>
                {{ Form::select('speciality_inks', yes_no_options(), $campaign->artwork_request->speciality_inks, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group required">
                <label>Embellishment Names</label>
                {{ Form::select('embellishment_names', yes_no_options(), $campaign->artwork_request->embellishment_names, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group required">
                <label for="contact_first_name">Embellishment Numbers</label>
                {{ Form::select('embellishment_numbers', yes_no_options(), $campaign->artwork_request->embellishment_numbers, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="form-checkbox mr-3">
                    Front
                    {{ Form::checkbox('area_front', 1, $campaign->artwork_request->designer_colors_front > 0, ['class' => '', 'data-toggle-display' => '#area-front']) }}
                    <span></span>
                </label>
                <label class="form-checkbox mr-3">
                    Back
                    {{ Form::checkbox('area_back', 1, $campaign->artwork_request->designer_colors_back > 0, ['class' => '', 'data-toggle-display' => '#area-back']) }}
                    <span></span>
                </label>
                <label class="form-checkbox mr-3">
                    Sleeve Left
                    {{ Form::checkbox('area_sleeve', 1, $campaign->artwork_request->designer_colors_sleeve_left > 0, ['class' => '', 'data-toggle-display' => '#area-sleeve_left']) }}
                    <span></span>
                </label>
                <label class="form-checkbox mr-3">
                    Sleeve Right
                    {{ Form::checkbox('area_sleeve', 1, $campaign->artwork_request->designer_colors_sleeve_right > 0, ['class' => '', 'data-toggle-display' => '#area-sleeve_right']) }}
                    <span></span>
                </label>
            </div>
        </div>
    </div>
    <div class="row d-flex align-items-center h-100">
        <div class="col-12 col-md-10">
            &nbsp;
        </div>
        <div class="col-12 col-md-2 font-weight-semi-bold text-center">
            # of Colors
        </div>
    </div>
    <div id="pms-color-list-container">
        @foreach (['front', 'back', 'sleeve_left', 'sleeve_right'] as $area)
            <div class="pms-color-list mb-4" id="area-{{ $area }}" style="{{ $campaign->artwork_request->{'designer_colors_' . $area} == 0 ? 'display: none' : '' }}">
                <div class="row h-100">
                    <div class="col-12 col-md-2 h-50px h-50px">
                        {{ ucwords(str_replace('_', ' ', $area)) }}
                    </div>
                    <div class="col-12 col-md-8 mb-1">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <input type="text" value="" title="PMS Number" class="form-control pms-color-input " data-auto-selected="true" placeholder="Enter PMS Number"/>
                                <input type="hidden" value="{{ $campaign->artwork_request->{'designer_colors_' . $area . '_list'} }}" name="{{ 'designer_colors_' . $area . '_list' }}"
                                       class="pms-color-hidden" v-bind:value="data"/>
                                <?php
                                $captions = [];
                                $list = explode(',', $campaign->artwork_request->{'designer_colors_' . $area . '_list'});
                                for ($i = 0; $i < count($list); $i++) {
                                    $captions[] = pms_color_repository()->caption($list[$i]);
                                }
                                ?>
                                <input type="hidden" value="{{ implode(',', $captions) }}" class="pms-color-hidden-captions"/>
                            </div>
                            <div class="col-12 col-md-6">
                                {{ Form::text('designer_dimensions_' . $area, $campaign->artwork_request->{'designer_dimensions_' . $area}, ['class' => 'form-control', 'placeholder' => 'Dimensions (12”L 14”W)']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 text-center h-50px lh-50px" ref="pmsColorCount">
                        0
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12" ref="pmsEntryList"></div>
                </div>
            </div>
        @endforeach
        <script type="text/x-template" id="pms-entry-template">
            <span class="mb-1 mr-3 text-nowrap d-inline-block" v-bind:data-color="code">
                <span class="color-square" v-bind:style="{ 'background-color': code }"></span>
                <span class="text-sm" v-html="caption"></span>
                 <i class="fa fa-trash-o color-square-delete" aria-hidden="true" v-on:click="deleteThisEntry($event)"></i>
             </span>
        </script>
    </div>
    <div class="row">
        @foreach ($campaign->product_colors as $productColor)
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ $productColor->product->name }} - {{ $productColor->name }} Design Files</label>
                    <div class="file-list">
                        <div class="d-inline-block">
                            @include ('v3.partials.filepicker', [
                                'class' => 'file-block mb-0',
                                'label'     => 'Front',
                                'fieldName' => 'proof' . $productColor->id . '_front',
                                'fieldType' => 'image',
                                'fieldData' => isset($proofs->products[$productColor->id]->front) ? $proofs->products[$productColor->id]->front : null
                            ])
                            <div class="text-center lh-1 text-sm">Front</div>
                        </div>
                        <div class="d-inline-block">
                            @include ('v3.partials.filepicker', [
                                'class' => 'file-block mb-0',
                                'label'     => 'Back',
                                'fieldName' => 'proof' . $productColor->id . '_back',
                                'fieldType' => 'image',
                                'fieldData' => isset($proofs->products[$productColor->id]->back) ? $proofs->products[$productColor->id]->back : null
                            ])
                            <div class="text-center lh-1 text-sm">Back</div>
                        </div>
                        <div class="d-inline-block">
                            @include ('v3.partials.filepicker', [
                                'class' => 'file-block mb-0',
                                'label'     => 'Close Up',
                                'fieldName' => 'proof' . $productColor->id . '_close_up',
                                'fieldType' => 'image',
                                'fieldData' => isset($proofs->products[$productColor->id]->close_up) ? $proofs->products[$productColor->id]->close_up : null
                            ])
                            <div class="text-center lh-1 text-sm">Close Up</div>
                        </div>
                        <div class="d-inline-block">
                            @include ('v3.partials.filepicker', [
                                'class' => 'file-block mb-0',
                                'label'     => 'Other',
                                'fieldName' => 'proof' . $productColor->id . '_other',
                                'fieldType' => 'image',
                                'fieldData' => isset($proofs->products[$productColor->id]->other) ? $proofs->products[$productColor->id]->other : null
                            ])
                            <div class="text-center lh-1 text-sm">Other</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-12">
            <div class="form-group">
                <label>Generic Design Files (old)</label>
                <div class="file-list">
                    @for($i = 0; $i < 10; $i++)
                        @include ('v3.partials.filepicker', [
                            'class' => 'file-block',
                            'fieldName' => 'proof' . $i,
                            'fieldType' => 'image',
                            'fieldData' => isset($proofs->generic['proof' . $i]) ? $proofs->generic['proof' . $i] : null
                        ])
                    @endfor
                </div>
            </div>
        </div>
    </div>
    <div class="text-right">
        <a href="{{ $back }}" class="btn btn-default btn-back">Back</a>
        <button type="submit" class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Submit</button>
    </div>
    {{ Form::close() }}
@endsection

@section('javascript')
    <script>
        PMSColorContainer.init();
        @foreach (['front', 'back', 'sleeve_left', 'sleeve_right'] as $area)
        GreekHouseAutoComplete.init($('#area-{{ $area }} .pms-color-input'), '{{  route('customer_module_popup', ['design_information', $campaign->id, 'auto_complete']) }}');
        @endforeach
    </script>
@append