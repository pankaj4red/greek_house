@extends ('customer')

@section ('title', 'Campaign Information')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">CAMPAIGN INFORMATION</div>
        <div class="popup-body">
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            {{ Form::open(['id' => 'ajax-form']) }}
            <div class="ajax-messages"></div>
            @if (Auth::user()->isType(['admin', 'support']))
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Print Location<i class="required">*</i></label>
                            <p>(Only one can be selected between Front and Pocket)</p>
                            {{ Form::checkbox('print_front', 'front', $campaign->artwork_request->print_front, ['class' => 'print-button', 'data-area' => 'front', 'data-group' => '1', 'id' => 'print_front']) }}
                            <label for="print_front">Front</label>
                            {{ Form::checkbox('print_pocket', 'pocket', $campaign->artwork_request->print__pocket, ['class' => 'print-button', 'data-area' => 'pocket', 'data-group' => '1', 'id' => 'print_pocket']) }}
                            <label for="print_front">Pocket</label>
                            {{ Form::checkbox('print_back', 'back', $campaign->artwork_request->print_back, ['class' => 'print-button', 'data-area' => 'back', 'data-group' => '2', 'id' => 'print_back']) }}
                            <label for="print_back">Back</label>
                            {{ Form::checkbox('print_sleeve', 'sleeve', $campaign->artwork_request->print_sleeve, ['class' => 'print-button', 'data-area' => 'sleeve', 'data-group' => '3', 'id' => 'print_sleeve']) }}
                            <label for="print_sleeve">Sleeve</label>
                            <p>
                                <small><i>Please include as much information as possible to help our designers
                                        get your design right the first time!</i></small>
                            </p>
                        </div>
                        <div class="group-area"
                             id="front" {!! (! $campaign->artwork_request->print_front) ? 'style="display: none"' : '' !!}>
                            <div class="form-group">
                                <label for="print_front_description">Describe what you would like designed on
                                    the front of the shirt<i class="required">*</i><span class="tooltip"
                                                                                         title="Most designs take less than two hours.&lt;br/&gt;However, things that are highly custom such as hand drawn designs or designs with more colors can take longer.&lt;br/&gt;For design inspiration, check out our <a href='{{ route('home::design_gallery') }}'>design gallery</a>."></span></label>
                                {{ Form::textarea('print_front_description', $campaign->artwork_request->print_front_description, ['class' => 'form-control', 'rows' => '6', 'placeholder' => '1. Please add notes/changes you need in a numbered list.
2. Please try to keep your notes concise.
3. Please make sure to write the exact text you want on the shirt (event name, date, venue, letters, school, chapter, sponsors, etc...).', 'id' => 'print_front_description']) }}
                            </div>
                            <div class="form-group">
                                <label for="print_front_colors">Preferred number of colors on front <span
                                            class="tooltip"
                                            title="The more colors you have on your design, the more expensive your final product will be.<br/>Use our <a href='javascript:void(0)' class='toggle-quick-quote'>Quick Quote</a> to come up with a product and # of colors at a price you will be happy with."></span></label>
                                {{ Form::select('print_front_colors', color_options('front'), $campaign->artwork_request->print_front_colors, ['class' => 'form-control', 'id' => 'print_front_colors']) }}
                            </div>
                        </div>
                        <div class="group-area"
                             id="pocket" {!! (! $campaign->artwork_request->print_pocket) ? 'style="display: none"' : '' !!}>
                            <div class="form-group">
                                <label for="print_pocket_description">Describe what you would like designed on
                                    the pockets of the shirt<i class="required">*</i><span class="tooltip"
                                                                                           title="Most designs take less than two hours.&lt;br/&gt;However, things that are highly custom such as hand drawn designs or designs with more colors can take longer.&lt;br/&gt;For design inspiration, check out our <a href='{{ route('home::design_gallery') }}'>design gallery</a>."></span></label>
                                {{ Form::textarea('print_pocket_description', $campaign->artwork_request->print_pocket_description, ['class' => 'form-control', 'rows' => '6', 'placeholder' => '1. Please add notes/changes you need in a numbered list.
2. Please try to keep your notes concise.
3. Please make sure to write the exact text you want on the shirt (event name, date, venue, letters, school, chapter, sponsors, etc...).', 'id' => 'print_pocket_description']) }}
                            </div>
                            <div class="form-group">
                                <label for="print_pocket_colors">Preferred number of colors on pocket <span
                                            class="tooltip"
                                            title="The more colors you have on your design, the more expensive your final product will be.<br/>Use our <a href='javascript:void(0)' class='toggle-quick-quote'>Quick Quote</a> to come up with a product and # of colors at a price you will be happy with."></span></label>
                                {{ Form::select('print_pocket_colors', color_options('pocket'), $campaign->artwork_request->print_pocket_colors, ['class' => 'form-control', 'id' => 'print_pocket_colors']) }}
                            </div>
                        </div>
                        <div class="group-area"
                             id="back" {!! (! $campaign->artwork_request->print_back) ? 'style="display: none"' : '' !!}>
                            <div class="form-group">
                                <label for="print_back_description">Describe what you would like designed on the
                                    back of the shirt<i class="required">*</i><span class="tooltip"
                                                                                    title="Most designs take less than two hours.&lt;br/&gt;However, things that are highly custom such as hand drawn designs or designs with more colors can take longer.&lt;br/&gt;For design inspiration, check out our <a href='{{ route('home::design_gallery') }}'>design gallery</a>."></span></label>
                                {{ Form::textarea('print_back_description', $campaign->artwork_request->print_back_description, ['class' => 'form-control', 'rows' => '6', 'placeholder' => '1. Please add notes/changes you need in a numbered list.
2. Please try to keep your notes concise.
3. Please make sure to write the exact text you want on the shirt (event name, date, venue, letters, school, chapter, sponsors, etc...).', 'id' => 'print_back_description']) }}
                            </div>
                            <div class="form-group">
                                <label for="print_back_colors">Preferred number of colors on back</label>
                                {{ Form::select('print_back_colors', color_options('back'), $campaign->artwork_request->print_back_colors, ['class' => 'form-control', 'id' => 'print_back_colors']) }}
                            </div>
                        </div>
                        <div class="group-area"
                             id="sleeve" {!! (! $campaign->artwork_request->print_sleeve) ? 'style="display: none"' : '' !!}>
                            <div class="form-group">
                                <label for="print_sleeve_description">Which sleeve do you want to print?<i
                                            class="required">*</i><span class="tooltip"
                                                                        title="Most designs take less than two hours.&lt;br/&gt;However, things that are highly custom such as hand drawn designs or designs with more colors can take longer.&lt;br/&gt;For design inspiration, check out our <a href='{{ route('home::design_gallery') }}'>design gallery</a>."></span></label><br/>
                                {{ Form::radio('print_sleeve_preferred', 'left', $campaign->artwork_request->print_sleeve_preferred == 'left', ['class' => '', 'id' => 'print_sleeve_preferred']) }}
                                <label for="print_sleeve_preferred">Left Sleeve</label><br/>
                                {{ Form::radio('print_sleeve_preferred', 'right', $campaign->artwork_request->print_sleeve_preferred == 'right', ['class' => '', 'id' => 'print_sleeve_preferred']) }}
                                <label for="print_sleeve_preferred">Right Sleeve</label><br/>
                                {{ Form::radio('print_sleeve_preferred', 'both', $campaign->artwork_request->print_sleeve_preferred == 'both', ['class' => '', 'id' => 'print_sleeve_preferred']) }}
                                <label for="print_sleeve_preferred">Both</label>
                            </div>
                            <div class="form-group">
                                <label for="print_sleeve_description">Describe what you would like on the sleeve
                                    of the shirt<span class="tooltip"
                                                      title="Most designs take less than two hours.&lt;br/&gt;However, things that are highly custom such as hand drawn designs or designs with more colors can take longer.&lt;br/&gt;For design inspiration, check out our <a href='{{ route('home::design_gallery') }}'>design gallery</a>."></span></label>
                                {{ Form::textarea('print_sleeve_description', $campaign->artwork_request->print_sleeve_description, ['class' => 'form-control', 'rows' => '6', 'placeholder' => '1. Please add notes/changes you need in a numbered list.
2. Please try to keep your notes concise.
3. Please make sure to write the exact text you want on the shirt (event name, date, venue, letters, school, chapter, sponsors, etc...).', 'id' => 'print_sleeve_description']) }}
                            </div>
                            <div class="form-group">
                                <label for="print_sleeve_colors">Preferred number of colors on sleeve <span
                                            class="tooltip"
                                            title="The more colors you have on your design, the more expensive your final product will be.<br/>Use our <a href='javascript:void(0)' class='toggle-quick-quote'>Quick Quote</a> to come up with a product and # of colors at a price you will be happy with."></span></label>
                                {{ Form::select('print_sleeve_colors', color_options('sleeve'), $campaign->artwork_request->print_sleeve_colors, ['class' => 'form-control', 'id' => 'print_sleeve_colors']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="designer_id">Designer<i class="required">*</i></label>
                            {{ Form::hidden('designer_id', $campaign->artwork_request->designer_id, ['class' => 'form-control designer_id', 'id' => 'designer_id']) }}
                            {{ Form::text('designer', $campaign->artwork_request->designer ? $campaign->artwork_request->designer->getFullName() : '', ['class' => 'form-control designer', 'placeholder' => 'Designer']) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="design_style_preference">Design Style Preference<i
                                        class="required">*</i></label>
                            <table class="width-100">
                                <tr>
                                    <td>
                                        <?php $index = 0; ?>
                                        @foreach (design_style_preference_options() as $key => $value)
                                            @if ($index++ == 3)
                                                {!! "</td><td>" !!}
                                            @endif
                                            <div>{{ Form::radio('design_style_preference', $key, $campaign->artwork_request->design_style_preference == $key, ['id' => 'design_style_preference']) }} {{ $value }}
                                                <span class="tooltip"
                                                      title="<div style='width: 200px; height: 200px; text-align: center'><img src='{{ route('system::image', [design_style_preference_image_id($key)]) }}' style='max-width: 200px; max-height: 200px'/></div>"></span>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="design_type">Print Type<i class="required">*</i></label>
                        {{ Form::select('design_type', design_type_options(), $campaign->artwork_request->design_type, ['class' => 'form-control', 'id' => 'design_type']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="estimated_quantity">Estimated Quantity<i class="required">*</i></label>
                        {{ Form::select('estimated_quantity', estimated_quantity_options($campaign->artwork_request->design_type), $campaign->estimated_quantity, ['class' => 'form-control', 'id' => 'estimated_quantity', 'placeholder' => 'Estimated Quantity']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <ul>
                            <li>
                                <small><i>If you are not sure how many pieces will be ordered, select a lower
                                        range, we charge for the exact quantity ordered. More purchases means
                                        cheaper prices!</i></small>
                            </li>
                            <li>
                                <small><i>However, if you do not reach minimum estimated quantity, we cannot
                                        process your order</i> 😞
                                </small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="estimated_quantity">On a Budget?<i class="required">*</i></label>
                        {{ Form::select('budget', yes_no_options(), $campaign->budget, ['class' => 'form-control', 'id' => 'budget']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" id="budget-range-group">
                        <label for="size_short">If so, how much?<i class="required">*</i></label>
                        {{ Form::select('budget_range', budget_options(), $campaign->budget_range, ['class' => 'form-control', 'id' => 'budget_range']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="design_type">Promo Code</label>
                        {{ Form::text('promo_code', $campaign->promo_code, ['class' => 'form-control', 'placeholder' => 'Promo Code', 'id' => 'promo_code']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if($editCloseDate)
                        <div class="form-group">
                            <label for="date">Campaign Close Date<i
                                        class="required">*</i></label>
                            {{ Form::text('close_date', $campaign->close_date ? $campaign->close_date->format('m/d/Y') : '', ['class' => 'form-control', 'placeholder' => 'Date', 'id' => 'close_date']) }}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="date">When would you ideally need this order delivered?<i
                                    class="required">*</i></label>
                        {{ Form::text('date', $campaign->date ? $campaign->date->format('m/d/Y') : '', ['class' => 'form-control', 'placeholder' => 'Date', 'id' => 'campaign_date']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::radio('flexible', 'no', $campaign->flexible == 'no', ['class' => '', 'id' => 'flexible_no']) }} <label
                                for="flexible">I must have delivered by this date</label><br/>
                        {{ Form::radio('flexible', 'yes', $campaign->flexible == 'yes', ['class' => '', 'id' => 'flexible_yes']) }} <label
                                for="flexible">Ship date is flexible within timeframe</label><br/>
                    </div>
                </div>
            </div>
            <div class="action-row">
                <a href="{{ $back }}" class="button-back btn btn-default back-btn">Cancel</a>
                <button type="submit" name="save" value="save" class="btn btn-primary" id="popup-ajax-button">
                    Save
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
    @include('partials.enable_username')
    @include ('partials.enable_print_type')
@append

@section ('javascript')
    <script>
        printType('#design_type', '#estimated_quantity');
    </script>
    <script>
        function refreshGroupAreas() {
            $('.group-area').hide();
            $('.print-button').each(function () {
                if ($(this).prop('checked')) {
                    $('#' + $(this).attr('data-area')).show();
                }
            });
        }

        $(document).ready(function () {
            $('.tooltip').tooltipster({
                contentAsHTML: true,
                interactive: true
            });
            userAutocomplete($('.designer_id'), $('.designer'));
            $("#campaign_date").datepicker({
                inline: false
            });
            $("#close_date").datepicker({
                inline: false
            });
            $('.print-button').change(function () {
                var that = this;
                $('.print-button').each(function () {
                    if (that !== this && $(that).attr('data-group') === $(this).attr('data-group')) {
                        $(this).prop('checked', false);
                    }
                });
                refreshGroupAreas();
            });
        });
    </script>
    <script>
        function updateBudget() {
            if ($('#budget').val() == 'yes') {
                $('#budget-range-group').show();
            } else {
                $('#budget-range-group').hide();
            }
        }
        $('#budget').change(updateBudget);
        updateBudget();
    </script>
@append



