@extends ('customer')

@section ('title', 'Wizard - Choose a Product')

@section ('content')

    <link href="{{ static_asset('css/wizard.css') . '?v=' . config('greekhouse.css_version') }}" rel="stylesheet">
    <!-- the 4 steps section -->
    @include ('partials.wizard_progress')

    <!-- end of the 4 steps section -->
    <div class="tab-content">
        <div class="tab-pane fade in show active" id="tabOne" role="tabpanel">
            <div class="container">
                <div class="tab-1-error-message alert alert-danger" style="display: none" role="alert"><strong>Oh snap!</strong> In order to go further, please choose a product first!</div>
            </div>
            <!-- CAROUSEL TYPE OF APPAREL ITEMS -->
            <div class="container">
                <div class="row" id="carousel-apparel-row">
                    <div id="carousel-apparel" class="carousel slide" data-ride="carousel" data-interval="false">
                        <div class="carousel-inner" role="listbox">
                            @foreach (garment_category_repository()->allActive()->chunk(6) as $categoryChunk)
                                <div class="item col-xs-12 {{ $categoryChunk->filter(function($category) use ($categoryId) { return $category->id == $categoryId; })->count() > 0 ? 'active' : '' }}">
                                    @foreach ($categoryChunk as $category)
                                        <div class="col-sm-2 {{ $category->id == $categoryId ? 'active' : '' }}">
                                            <a href="#" class="carousel-apparel-anchor" data-category="{{ $category->id }}" data-url="{{ category_to_url($category->id,$category->name) }}">
                                                <div class="apparel-container-bg" style="background-image: url({{ route('system::image', [$category->image_id]) }});">
                                                    <p>{{ $category->name }}</p></div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                        </div><!-- end of carousel-inner-->

                        <!--carousel controls -->
                        <a href="#carousel-apparel" class="carousel-control apparel-control apparel-control-left left" role="button" data-slide="prev">
                            <img class="arrow-left-carousel" src="{{ static_asset('images/wizard/blue-pre-arrow.png') }}">
                        </a>
                        <a href="#carousel-apparel" class="carousel-control apparel-control apparel-control-right right" role="button" data-slide="next">
                            <img class="arrow-right-carousel" src="{{ static_asset('images/wizard/blue-next-arrow.png') }}">
                        </a>
                        <!--end of carousel controls -->
                    </div>
                </div><!-- end of row -->
            </div><!-- end of container -->
            <!-- end of CAROUSEL TYPE OF APPAREL ITEMS-->


            <!-- search box bootstrap -->
            <div class="container">
                <div class="row">

                    <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                        <form class="tab-one-search-box">
                            <div id="custom-search-input">
                                <div class="input-group col-md-12">
                                    <input type="text" class="form-control input-lg" id="search-query" placeholder="Search" value="{{ $query }}"/>
                                    <span class="input-group-btn">
																<button class="btn btn-info btn-lg" type="submit">
																		<i class="glyphicon glyphicon-search"></i>
																</button>
														</span>
                                </div>
                            </div><!-- end of custom search input -->
                        </form>
                    </div>

                </div>
            </div>
            <!-- end of search box bootstrap -->


            <div class="container margin-top-container" id="gender-section">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="btn-container-gender">
                            <a href="#" class="btn-search-gender active" data-gender="u">All</a>
                            <a href="#" class="btn-search-gender" data-gender="f">Women's</a>
                            <a href="#" class="btn-search-gender" data-gender="m">Men's</a>
                        </div>

                    </div>
                </div>
            </div>


            <!-- loading intermezzo -->
            <div class="container">
                <div class="row">
                    <div id="loading" class="hide">
                        <ul class="bokeh">
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
            </div>


            <!-- 4x4 section of images -->
            <div class="container" id="section4x4">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="thumb-wrapper {{ $product->id == $campaignLead->hasProduct($product->id) ? 'active' : '' }}">
                                <a href="#" class="product-item-anchor no-decoration" data-target="#modalLargeProducts" data-name="{{ stripslashes($product->name) }}"
                                   data-img="{{ route('system::image', [$product->image_id]) }}" data-id="{{ $product->id }}"
                                   data-style="{{ $product->style_number }}" data-type="{{ $product->category->name }}" data-gender="{{ $product->gender->code }}"
                                   data-size="{{ size_list($product->sizes) }}" data-description="{{ $product->description }}"
                                   data-colors="{{ json_encode(color_list($product->active_colors)) }}">
                                    <div class="product-wrapper">
                                        <img class="designs-img products-img" src="{{ route('system::image', [$product->image_id]) }}">
                                    </div>
                                    <div class="text-wrapper">
                                        <p class="description-product">{{ $product->name }}</p>
                                    </div>

                                </a>
                            </div><!-- end thumb-wrapper-->
                        </div><!-- end of column xs, sm, md, lg -->
                    @endforeach
                </div><!-- end of 4x4 row -->
            </div><!-- end of container -->
            <!-- end of 4x4 section of images -->


            <!-- Large modal -->
            <div class="modal fade" id="modalLargeProducts" tabindex="-1" role="dialog" aria-labelledby="modalLargeTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title" id="productsModalLargeTitleWrapper"><span id="productsModalLargeTitle">American Apparel Ladies Short Sleeve T-Shirt</span> (STYLE # <span
                                        id="productModalLargeTitleStyle"></span>) <span id="productModalLargeTitleColor"></span></h5>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <a href="#">
                                            <img class="design-preview-image img-fluid img-responsive" src="{{ static_asset('images/not_available.png') }}">
                                        </a>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="color-pick">
                                            <p class="color-pick-head">Choose a Color:</p>

                                        </div>
                                        <ul class="list-inline" id="product-color-list">
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Blue">
                                                <li class=" inline-color-picker-modal color-no-1"></li>
                                            </a>
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Desaturated Orange">
                                                <li class=" inline-color-picker-modal color-no-2"></li>
                                            </a>
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Desaturated Red">
                                                <li class=" inline-color-picker-modal color-no-3"></li>
                                            </a>
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Desaturated Green">
                                                <li class=" inline-color-picker-modal color-no-4"></li>
                                            </a>
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Soft Cyan">
                                                <li class=" inline-color-picker-modal color-no-5"></li>
                                            </a>
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Grayish Cyan">
                                                <li class=" inline-color-picker-modal color-no-6"></li>
                                            </a>
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Grayish Blue">
                                                <li class=" inline-color-picker-modal color-no-7"></li>
                                            </a>
                                            <br>
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Pale Orange">
                                                <li class=" inline-color-picker-modal color-no-8"></li>
                                            </a>
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Yellow">
                                                <li class=" inline-color-picker-modal color-no-9"></li>
                                            </a>
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Light Gray">
                                                <li class=" inline-color-picker-modal color-no-10"></li>
                                            </a>
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Dark Cyan">
                                                <li class=" inline-color-picker-modal color-no-11"></li>
                                            </a>
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Red">
                                                <li class=" inline-color-picker-modal color-no-12"></li>
                                            </a>
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Dark Blue">
                                                <li class=" inline-color-picker-modal color-no-13"></li>
                                            </a>
                                            <a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title="Lime Green">
                                                <li class=" inline-color-picker-modal color-no-14"></li>
                                            </a>
                                        </ul>
                                        <div class="size">
                                            <p class="size-range-head">Size:</p>
                                            <p class="size-range-p">S - XL</p>
                                        </div>
                                        <div class="product-description-small product-description-small-modal">
                                            <h5 class="product-desc-head product-desc-modal-head">
                                                Product Description
                                            </h5>
                                            <p class="product-desc-p product-desc-modal-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                                quis nostrud exercitation ullamco laboris.
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div><!-- end of modal-body -->
                        {{ Form::open(['url' => route('wizard::product')]) }}
                        {{ Form::hidden('color_id', $campaignLead->product_colors->count() > 0 ? $campaignLead->product_colors->first()->id : null, ['id' => 'wizard_color_id']) }}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-blue-greek-house" id="toStep2">Next</button>
                        </div><!-- end of modal footer -->
                        {{ Form::close() }}
                    </div><!-- end of Modal Content -->
                </div>
            </div><!-- end of ALL LARGE MODAL -->
        </div><!-- end of tabOne -->
    </div><!-- end of DIV TAB PANE GENERAL CONTENT -->
@endsection

@section ('stylesheet')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"/>
@append

@section ('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <!--script type="text/javascript" src="{{ static_asset('js/wizard.js') . '?v=' . config('greekhouse.css_version') }}"></script-->
    <script type="text/javascript">
        let originalProductId = {{ $campaignLead->product_colors->first() ? $campaignLead->product_colors->first()->product_id : 'null' }};
        let originalColorId = {{ $campaignLead->product_colors->first() ? $campaignLead->product_colors->first()->id : 'null' }};
        @if ($open)
        openModal($('.product-item-anchor'));
        @endif

        $('body').on('click', '.product-item-anchor', function (e) {
            e.preventDefault();
            openModal($(this));
        });

        $('.btn-search-gender').click(function (e) {
            e.preventDefault();
            $('.btn-search-gender').removeClass('active');
            $(this).addClass('active');
            filterProducts();
        });

        $('.tab-one-search-box').submit(function (e) {
            e.preventDefault();
            search();
        });

        $('body').on('click', 'a.carousel-apparel-anchor', function (e) {
            e.preventDefault();
            $('a.carousel-apparel-anchor').each(function () {
                $(this).parent().removeClass('active');
                $(this).parent().parent().removeClass('active');
            });

            $(this).parent().addClass('active');
            $(this).parent().parent().addClass('active');

            search();
        });

        function filterProducts() {
            let gender = $('.btn-search-gender.active').attr('data-gender');
            $('.product-item-anchor').each(function () {
                let target = $(this).parent().parent();
                if (gender === 'u' || $(this).attr('data-gender') === 'u' || $(this).attr('data-gender') === gender) {
                    target.show();
                } else {
                    target.hide();
                }
            });
        }

        function showLoading() {
            $('#loading').removeClass('hide');
            $('#section4x4').addClass('hide');
        }

        function hideLoading() {
            setTimeout(function () {
                $('#loading').addClass('hide');
                $('#section4x4').removeClass('hide');
                $('body').delay(10).animate({
                    scrollTop: $('#gender-section').offset().top
                }, 1000);
            }, 1000);
        }

        function fetch(category, query) {
            let compiledRequestUri = '/wizard/ajax/products';
            let categoryUriComponent = 'category=' + category;
            let queryUriComponent = 'query=' + query;

            if (category && !query) {
                compiledRequestUri += '?' + categoryUriComponent;
            } else if (query && !category) {
                compiledRequestUri += '?' + queryUriComponent;
            } else {
                compiledRequestUri += '?' + categoryUriComponent + '&' + queryUriComponent;
            }

            let result = {"foo": "bar"};
            $.ajaxSetup({
                beforeSend: function (xhr) {
                    if (xhr.overrideMimeType) {
                        xhr.overrideMimeType("application/json");
                    }
                },
                async: false
            });
            $.getJSON(compiledRequestUri, function (data) {
                result = data;
            });

            return result.data;
        }

        function search() {
            showLoading();

            let category = $('#carousel-apparel .col-sm-2.active .carousel-apparel-anchor').attr('data-category');
            let categoryUrl = $('#carousel-apparel .col-sm-2.active .carousel-apparel-anchor').attr('data-url');
            let query = $('#search-query').val();
            let results = fetch(query ? '' : category, query);

            history.pushState('data', '', '/wizard/product/category/' + categoryUrl);

            showProducts(results);

            hideLoading();
            scrollToGenders();
        }

        function scrollToGenders() {
            $('body').animate({
                scrollTop: $('#gender-section').offset().top
            }, 1000);
        }

        function showProducts(data) {
            let container = $('#section4x4');
            container.empty();
            let row = container.append('<div class="row" />');

            $.each(data, function (i, item) {
                let element = $('<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" />');
                let thumbWrapper = $('<div class="thumb-wrapper" />');
                let anchor = $('<a href="#" class="product-item-anchor no-decoration" />');
                anchor.attr('data-id', item.id);
                anchor.attr('data-name', item.name);
                anchor.attr('data-img', item.img);
                anchor.attr('data-style', item.style);
                anchor.attr('data-type', item.type);
                anchor.attr('data-size', item.size);
                anchor.attr('data-description', item.description);
                anchor.attr('data-gender', item.gender);
                anchor.attr('data-colors', item.colors);
                let productImgWrapper = $('<div class="product-wrapper"><img class="designs-img products-img" src="' + item.img + '"></div>');
                let productTextWrapper = $('<div class="text-wrapper"><p class="description-product">' + item.name + '</p></div>');
                anchor.append(productImgWrapper).append(productTextWrapper);
                thumbWrapper.append(anchor);
                element.append(thumbWrapper);
                row.append(element);

                if (originalProductId == item.id) {
                    thumbWrapper.addClass('active');
                }
            });
        }

        function openModal(element) {
            $('#modalLargeProducts').find('#productsModalLargeTitle').text(element.attr('data-name'));
            $('#modalLargeProducts img.design-preview-image').attr('src', element.attr('data-img'));
            $('#modalLargeProducts p.product-desc-p').text(element.attr('data-description'));
            $('#modalLargeProducts p.size-range-p').text(element.attr('data-size'));
            $('#modalLargeProducts').find('#productModalLargeTitleStyle').text(element.attr('data-style'));

            $('#modalLargeProducts ul#product-color-list').html('');
            let colors = JSON.parse(element.attr('data-colors'));
            let entry;
            for (var i = 0; i < colors.length; i++) {
                entry = $('<a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title=""><li class="inline-color-picker-modal"></li></a>');
                entry.attr('title', colors[i].name);
                entry.find('li').css('background-image', 'url(' + colors[i].thumbnail + ')');
                entry.attr('data-image', colors[i].image);
                entry.attr('data-id', colors[i].id);
                entry.attr('data-colors', colors[i].colors);
                $('#modalLargeProducts ul#product-color-list').append(entry);

                if (originalColorId == colors[i].id) {
                    selectColor(entry);
                }
            }
            $('#modalLargeProducts').modal('show');
            history.pushState('data', '', '/wizard/product/' + element.attr('data-id'));
        }

        $('#modalLargeProducts').on('click', '.color-picker-modal-anchor', function (e) {
            e.preventDefault();
            selectColor($(this));


        });

        function selectColor(element) {
            $('#modalLargeProducts .color-picker-modal-anchor').attr('style', '');
            $('#wizard_color_id').val($(element).attr('data-id'));
            $('#productModalLargeTitleColor').text(' - ' + $(element).attr('title'));
            $('#modalLargeProducts').find('.color-picker-modal-anchor').each(function () {
                element.removeClass('active');
                element.css('border-color', 'transparent').css('border-radius', '0px');
            });
            element.css('border-color', '#3a3939').css('border-radius', '10px');
            element.addClass('active');
            $('#modalLargeProducts img.design-preview-image').attr('src', '/images/download.gif');
            let that = element;
            setTimeout(function () {
                $('#modalLargeProducts img.design-preview-image').attr('src', that.attr('data-image'));
            }, 100);
            return false;
        }
    </script>
@append