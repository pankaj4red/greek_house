@extends ('customer')

@section ('title', 'Order - Step 5')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (config('services.crazy_egg.enabled'))
        <script type="text/javascript">
            setTimeout(function () {
                var a = document.createElement("script");
                var b = document.getElementsByTagName("script")[0];
                a.src = document.location.protocol + "//script.crazyegg.com/pages/scripts/0050/4238.js?" + Math.floor(new Date().getTime() / 3600000);
                a.async = true;
                a.type = "text/javascript";
                b.parentNode.insertBefore(a, b)
            }, 1);
        </script>
    @endif
    <div class="container">
        @include ('partials.progress')
        <div class="form-header">
            <h1><i class="icon icon-info"></i><span class="icon-text">Tell Us What You Want</span></h1>
            <hr/>
        </div>
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        {!! Form::model($model, ['id' => 'form']) !!}
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default panel-box">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon icon-tshirt"></i><span
                                    class="icon-text">{{ $product->name }}</span></h3>
                        <p class="pull-right style-number">Style Number: <strong>{{ $product->style_number }}</strong>
                        </p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name This Campaign<i class="required">*</i></label>
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
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
                                                    <div>{!! Form::radio('design_style_preference', $key, null, []) !!} {{ $value }}
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
                        <div class="form-group">
                            <label>Print Location<i class="required">*</i></label>
                            <p>(Only one can be selected between Front and Pocket)</p>
                            {!! Form::checkbox('print_front', true, null, ['class' => 'print-button', 'data-area' => 'front', 'data-group' => '1']) !!}
                            <label for="print_front">Front</label>
                            {!! Form::checkbox('print_pocket', true, null, ['class' => 'print-button', 'data-area' => 'pocket', 'data-group' => '1']) !!}
                            <label for="print_front">Pocket</label>
                            {!! Form::checkbox('print_back', true, null, ['class' => 'print-button', 'data-area' => 'back', 'data-group' => '2']) !!}
                            <label for="print_back">Back</label>
                            {!! Form::checkbox('print_sleeve', true, null, ['class' => 'print-button', 'data-area' => 'sleeve', 'data-group' => '3']) !!}
                            <label for="print_sleeve">Sleeve</label>
                            <p>
                                <small><i>Please include as much information as possible to help our designers get your
                                        design right the first time!</i></small>
                            </p>
                        </div>
                        <div class="group-area"
                             id="front" {!! (!null&&!$model['print_front'])?'style="display: none"':'' !!}>
                            <div class="form-group">
                                <label for="print_front_description">Describe what you would like Designed on the
                                    front of the shirt<i class="required">*</i><span class="tooltip"
                                                                                     title="Most designs take less than two hours.&lt;br/&gt;However, things that are highly custom such as hand drawn designs or designs with more colors can take longer.&lt;br/&gt;For design inspiration, check out our <a href='{{ route('home::design_gallery') }}'>design gallery</a>."></span></label>
                                {!! Form::textarea('print_front_description', null, ['class' => 'form-control', 'rows' => '6', 'placeholder' => '1. Please add notes/changes you need in a numbered list.
2. Please try to keep your notes concise.
3. Please make sure to write the exact text you want on the shirt (event name, date, venue, letters, school, chapter, sponsors, etc...).']) !!}
                            </div>
                            <div class="form-group">
                                <label for="print_front_colors">Preferred number of colors on front <span
                                            class="tooltip"
                                            title="The more colors you have on your design, the more expensive your final product will be.<br/>Use our <a href='javascript:void(0)' class='toggle-quick-quote'>Quick Quote</a> to find the right price."></span></label>
                                {!! Form::select('print_front_colors', color_options('front'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="group-area"
                             id="pocket" {!! (!null&&!$model['print_pocket'])?'style="display: none"':'' !!}>
                            <div class="form-group">
                                <label for="description_location_pocket">Describe what you would like Designed on the
                                    pockets of the shirt<i class="required">*</i><span class="tooltip"
                                                                                       title="Most designs take less than two hours.&lt;br/&gt;However, things that are highly custom such as hand drawn designs or designs with more colors can take longer.&lt;br/&gt;For design inspiration, check out our <a href='{{ route('home::design_gallery') }}'>design gallery</a>."></span></label>
                                {!! Form::textarea('print_pocket_description', null, ['class' => 'form-control', 'rows' => '6', 'placeholder' => '1. Please add notes/changes you need in a numbered list.
2. Please try to keep your notes concise.
3. Please make sure to write the exact text you want on the shirt (event name, date, venue, letters, school, chapter, sponsors, etc...).']) !!}
                            </div>
                            <div class="form-group">
                                <label for="print_pocket_colors">Preferred number of colors on pocket <span
                                            class="tooltip"
                                            title="The more colors you have on your design, the more expensive your final product will be.<br/>Use our <a href='javascript:void(0)' class='toggle-quick-quote'>Quick Quote</a> to find the right price."></span></label>
                                {!! Form::select('print_pocket_colors', color_options('pocket'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="group-area"
                             id="back" {!! (!null&&!$model['print_back'])?'style="display: none"':'' !!}>
                            <div class="form-group">
                                <label for="print_back_description">Describe what you would like Designed on the back
                                    of the shirt<i class="required">*</i><span class="tooltip"
                                                                               title="Most designs take less than two hours.&lt;br/&gt;However, things that are highly custom such as hand drawn designs or designs with more colors can take longer.&lt;br/&gt;For design inspiration, check out our <a href='{{ route('home::design_gallery') }}'>design gallery</a>."></span></label>
                                {!! Form::textarea('print_back_description', null, ['class' => 'form-control', 'rows' => '6', 'placeholder' => '1. Please add notes/changes you need in a numbered list.
2. Please try to keep your notes concise.
3. Please make sure to write the exact text you want on the shirt (event name, date, venue, letters, school, chapter, sponsors, etc...).']) !!}
                            </div>
                            <div class="form-group">
                                <label for="color_location_back">Preferred number of colors on back <span
                                            class="tooltip"
                                            title="The more colors you have on your design, the more expensive your final product will be.<br/>Use our <a href='javascript:void(0)' class='toggle-quick-quote'>Quick Quote</a> to find the right price."></span></label>
                                {!! Form::select('print_back_colors', color_options('back'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="group-area"
                             id="sleeve" {!! (!null&&!$model['print_sleeve'])?'style="display: none"':'' !!}>
                            <div class="form-group">
                                <label for="print_sleeve_description">Which sleeve do you want to print?<i
                                            class="required">*</i><span class="tooltip"
                                                                        title="Most designs take less than two hours.&lt;br/&gt;However, things that are highly custom such as hand drawn designs or designs with more colors can take longer.&lt;br/&gt;For design inspiration, check out our <a href='{{ route('home::design_gallery') }}'>design gallery</a>."></span></label><br/>
                                {!! Form::radio('print_sleeve_preferred', 'left', null, ['class' => '']) !!}
                                <label for="print_location_front">Left Sleeve</label><br/>
                                {!! Form::radio('print_sleeve_preferred', 'right', null, ['class' => '']) !!}
                                <label for="print_location_front">Right Sleeve</label><br/>
                                {!! Form::radio('print_sleeve_preferred', 'both', null, ['class' => '']) !!}
                                <label for="print_sleeve_preferred">Both</label>
                            </div>
                            <div class="form-group">
                                <label for="print_sleeve_description">Describe what you would like Designed on the
                                    sleeve of the shirt</label>
                                {!! Form::textarea('print_sleeve_description', null, ['class' => 'form-control', 'rows' => '6', 'placeholder' => '1. Please add notes/changes you need in a numbered list.
2. Please try to keep your notes concise.
3. Please make sure to write the exact text you want on the shirt (event name, date, venue, letters, school, chapter, sponsors, etc...).']) !!}
                            </div>
                            <div class="form-group">
                                <label for="print_sleeve_colors">Preferred number of colors on sleeve <span
                                            class="tooltip"
                                            title="The more colors you have on your design, the more expensive your final product will be.<br/>Use our <a href='javascript:void(0)' class='toggle-quick-quote'>Quick Quote</a> to find the right price."></span></label>
                                {!! Form::select('print_sleeve_colors', color_options('sleeve'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="design_type">Print Type<i class="required">*</i></label>
                                    {!! Form::select('design_type', design_type_options(), null, ['class' => 'form-control', 'id' => 'design_type']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estimated_quantity">Estimated Quantity<i class="required">*</i></label>
                                    {!! Form::select('estimated_quantity', estimated_quantity_options(old('design_type', $model['design_type'])), null, ['class' => 'form-control', 'id' => 'estimated_quantity', 'placeholder' => 'Estimated Quantity']) !!}
                                </div>
                            </div>
                            @if ($product->price < config('greekhouse.product.price_limit'))
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="size_short">Free Shirt Size<i class="required">*</i></label>
                                        {!! Form::select('size_short', $sizeOptions, null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <ul>
                                        <li>
                                            <small><i>If you are not sure how many pieces will be ordered, select a
                                                    lower range, we charge for the exact quantity ordered. More
                                                    purchases means cheaper prices!</i></small>
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
                                    {!! Form::select('budget', yes_no_options(), null, ['class' => 'form-control', 'id' => 'budget']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="budget-range-group">
                                    <label for="size_short">If so, how much?<i class="required">*</i></label>
                                    {!! Form::select('budget_range', budget_options(), null, ['class' => 'form-control', 'id' => 'budget_range']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Upload Reference Images</label>
                            <div class="file-list">
                                @include ('partials.image_picker', [
                                    'fieldName' => 'design1',
                                    'fieldType' => 'image',
                                    'fieldData' => isset($design1) ? $design1 : null
                                ])
                                @include ('partials.image_picker', [
                                    'fieldName' => 'design2',
                                    'fieldType' => 'image',
                                    'fieldData' => isset($design2) ? $design2 : null
                                ])
                                @include ('partials.image_picker', [
                                    'fieldName' => 'design3',
                                    'fieldType' => 'image',
                                    'fieldData' => isset($design3) ? $design3 : null
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="action-row">
            <input type="hidden" id="color-id" name="color-id" value="{{ $product->colors[0]->id }}"/>
            <a href="{{ route('campaign::step4', [$productId]) }}" class="btn btn-default">Back</a>
            <button type="submit" name="next" value="next" class="btn btn-primary">Next</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section ('include')
    @include ('partials.enable_filepicker')
    @include ('partials.enable_print_type')
@append

@section ('javascript')
    <script>
        printType('#design_type', '#estimated_quantity');
    </script>
    <script>
        $(document).ready(function () {
            $('.tooltip').tooltipster({
                contentAsHTML: true,
                interactive: true
            });
        });
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

        $('.print-button').change(function () {
            var that = this;
            $('.print-button').each(function () {
                if (that !== this && $(that).attr('data-group') === $(this).attr('data-group')) {
                    $(this).prop('checked', false);
                }
            });
            refreshGroupAreas();
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
