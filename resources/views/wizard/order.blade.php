@extends ('customer')

@section ('title', 'Wizard - Describe your design')

@section ('content')
    <link href="{{ static_asset('css/wizard.css') . '?v=' . config('greekhouse.css_version') }}" rel="stylesheet">
    <!-- the 4 steps section -->
    @include ('partials.wizard_progress')

    <!-- end of the 4 steps section -->
    {{ Form::open(['url' => route('wizard::order')]) }}
    {{ Form::hidden('product_color_tree', json_encode($campaignLead->toProductColorTree()), ['id' => 'product_color_tree']) }}
    <div class="tab-pane fade in show active" id="tabThree" role="tabpanel">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="tabThree-product-container" id="product_list">
                        @foreach (campaign_lead_product_tree($campaignLead->product_colors) as $product)
                            <div class="cart_product" data-key="{{ $loop->index }}" data-id="{{ $product->id }}">
                                <div class="row row-position">
                                    <div class="col-md-3 col-sm-3">
                                        @if ($product->colors->count() > 0)
                                            <img class="img img-responsive img-thumbnail" src="{{ route('system::image', [$product->colors[0]->image_id]) }}"
                                                 alt="{{ $product->name }}">
                                        @else
                                            <img class="img img-responsive img-thumbnail" src="{{ route('system::image', [$product->image_id]) }}" alt="...">
                                        @endif
                                    </div>
                                    <div class="col-md-7 col-sm-7">
                                        <h4 class="media-heading step3_product_title">{{ $product->name . ($product->colors->count() > 0 ? (' - ' . $product->colors[0]->name) : '')}}</h4>
                                    </div>
                                    <div class="col-md-2 col-sm-2 edit_options">
                                        <a href="#" class="remove_product_btn trash-product" style="{{ campaign_lead_product_tree($campaignLead->product_colors)->count() < 2 ? 'display: none;' : '' }}"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="colorboxes">
                                            <a href="#" id="c1" data-slot="1" class="color_slot color_slot_1 color_box btn-baseColor {{ $product->colors->count() > 0 ? 'active' : '' }}"
                                               style="{{ $product->colors->count() > 0 ? 'background-image: url(' . route('system::image', [$product->colors[0]->thumbnail_id]) . ')' : '' }}"
                                               title="{{ $product->colors->count() > 0 ? $product->colors[0]->name : '' }}">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                            <a href="#" id="c2" data-slot="2" class="color_slot color_slot_2 color_box btn-baseColor {{ $product->colors->count() > 1 ? 'active' : '' }}"
                                               style="{{ $product->colors->count() > 1 ? 'background-image: url(' . route('system::image', [$product->colors[1]->thumbnail_id]) . ')' : '' }}"
                                               title="{{ $product->colors->count() > 1 ? $product->colors[1]->name : '' }}">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                            <a href="#" id="c3" data-slot="3" class="color_slot color_slot_3 color_box btn-baseColor {{ $product->colors->count() > 2 ? 'active' : '' }}"
                                               style="{{ $product->colors->count() > 2 ? 'background-image: url(' . route('system::image', [$product->colors[2]->thumbnail_id]) . ')' : '' }}"
                                               title="{{ $product->colors->count() > 2 ? $product->colors[2]->name : '' }}">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                            <a href="#" id="c4" data-slot="4" class="color_slot color_slot_4 color_box btn-baseColor {{ $product->colors->count() > 3 ? 'active' : '' }}"
                                               style="{{ $product->colors->count() > 3 ? 'background-image: url(' . route('system::image', [$product->colors[3]->thumbnail_id]) . ')' : '' }}"
                                               title="{{ $product->colors->count() > 3 ? $product->colors[3]->name : '' }}">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                            <a href="#" class="color_box colorpicker dropdown-toggle btn-baseColor" data-toggle="dropdown" aria-expanded="false">&nbsp;</a>

                                            <ul class="colorpicker_popup colors-available dropdown-menu" role="menu" aria-labelledby="color_1">
                                                @foreach (product_repository()->find($product->id)->colors as $color)
                                                    <li class="color thumbnail" title="{{ $color->name }}"
                                                        style="color:black; background-image: url({{ route('system::image', [$color->thumbnail_id]) }})"
                                                        data-id="{{ $color->id }}" data-thumbnail="{{ route('system::image', [$color->thumbnail_id]) }}"></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end of cart-product -->
                        @endforeach

                    </div> <!-- end of ALL cart-"products" -->
                    <div class="text-centralized">
                        <h6 class="text-centralized-head">
                            You can add up to 4 apparel options.
                        </h6>
                    </div>
                    <div class="tabThree-panel-body">

                        <div id="add_new_product_control" style="display: none;">
                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    {{ Form::select('categories', additional_garment_category_options(['' => 'Select Category']), null, ['class' => 'form-control', 'id' => 'categories']) }}
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <select id="products" class="form-control">
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <a href="#" id="add" class="btn btn-primary btn-blue-greek-house">
                                        <span class="fa fa-plus"></span>
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>
                </div> <!-- end of sm12 md6 lg6 no1 -->


                <div class="col-sm-12 col-md-6 col-lg-5 col-lg-offset-1">

                    <div class="first-select">
                        <label class="print_type_label" for="print_type_select">Print Type:</label>
                        {{ Form::select('design_type', design_type_options(), $campaignLead->design_type, ['class' => 'form-control print_type_selection', 'id' => 'design_type', 'autocomplete' => 'off']) }}
                    </div> <!-- end of first select -->

                    <div class="second-select">
                        <label class="print_type_label" for="print_type_select">Would you like your order bagged and tagged?</label>
                        {{ Form::select('polybag_and_label', yes_no_options(), $campaignLead->polybag_and_label ? 'yes' : 'no', ['class' => 'form-control']) }}
                    </div> <!-- end of third select -->

                    <div class="text-description-select">
                        <p class="text-description-select-p" style="margin-top: 10px;">
                            Bag n Tag costs an additional $1 per shirt
                        </p>
                    </div>

                    <div class="second-select">
                        <label class="print_type_label" for="print_type_select_two">How many pieces do you think will be ordered?</label>
                        {{ Form::select('estimated_quantity', estimated_quantity_options(old('design_type', $campaignLead->design_type)), $campaignLead->estimated_quantity, ['class' => 'form-control', 'id' => 'estimated_quantity', 'placeholder' => 'Estimated Quantity']) }}
                    </div> <!-- end of second select -->

                    <div class="text-description-select">
                        <p class="text-description-select-p">
                            If you are not sure how many pieces will be ordered, select a lower range, we charge for the exact quantity ordered. More purchases means cheaper prices!
                        </p>

                        <p class="text-description-select-p">
                            However, if you do not reach minimum estimated quantity, we cannot process your order <img class="img-smiley-face" src="{{ static_asset('images/wizard/smiley-sad.png') }}">
                        </p>
                    </div>

                    <button type="submit" id="toStep4" class="btn btn-primary btn-blue-greek-house btn-pull-right">Next</button>

                </div> <!-- end of sm12 md6 lg6 -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->

    </div> <!-- end of tabThree full -->
    {{ Form::close() }}
@endsection

@section ('stylesheet')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"/>
@append

@section ('include')
    @include ('partials.enable_filepicker')
    @include ('partials.enable_print_type')
@append

@section ('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="{{ static_asset('js/wizard.js') . '?v=' . config('greekhouse.css_version') }}"></script>
    <script>
        @foreach (campaign_lead_product_tree($campaignLead->product_colors) as $product)
        GreekHouse.wizardPage.addProduct({
            id: {{ $product->id }},
            img: "{{ route('system::image', [$product->image_id]) }}",
            name: "{{ $product->name }}",
            additionalColors: [],
        }, false);
        <?php $productLoop = $loop ?>
        @foreach ($product->colors as $color)
        GreekHouse.wizardPage.addColor({{ $productLoop->index }}, {
            id: {{ $color->id }},
            name: "{{ $color->name }}",
            image: "{{ route('system::image', [$color->thumbnail_id]) }}",
        }, false);
                @endforeach
                @endforeach
        var categoryProducts = {
        @foreach (additional_garment_category_options() as $categoryOptionKey => $categoryOptionValue)
        {{ $categoryOptionKey }}:
        [
                @foreach (product_repository()->options(['' => 'Select a Product'], $categoryOptionKey) as $productOptionKey => $productOptionValue)
            {
                id: "{{ $productOptionKey }}", name: "{{ $productOptionValue }}"
            }
            @if (! $loop->last)
            ,
            @endif
            @endforeach
        ]
                @if (! $loop->last)
            ,
        @endif
        @endforeach
        };
        $('#categories').change(function () {
            $('#products').html('');
            var category = categoryProducts[$(this).val()];
            for (var key in category) {
                var option = $('<option></option>');
                option.text(category[key].name);
                option.attr('value', category[key].id);
                $('#products').append(option);
            }
        });
    </script>
    <script>
        printType('#design_type', '#estimated_quantity');
    </script>
@append