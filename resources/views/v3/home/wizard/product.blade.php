@extends('v3.layouts.app')

@section('title', 'Wizard - Choose a Product')

@section('content')
    <div id="wizard" xmlns:v-bind="http://www.w3.org/1999/xhtml">
        <div class="container mt-5">
            <div class="progress-steps">
                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li role="presentation" class="{{ Request::is('wizard/product*') ? 'active' : '' }}">
                        <a href="{{ route('wizard::product') }}"><span>1.</span> CHOOSE A PRODUCT</a>
                    </li>
                    <li role="presentation" class="{{ Request::is('wizard/design*') ? 'active' : '' }}">
                        @if ($campaignLead->product_colors->count() > 0)
                            <a href="{{ route('wizard::design') }}"><span>2.</span> DESIGN DESCRIPTION</a>
                        @else
                            <span><span>2.</span> DESIGN DESCRIPTION</span>
                        @endif
                    </li>
                    <li role="presentation" class="{{ Request::is('wizard/order*') ? 'active' : '' }}">
                        @if ($campaignLead->name)
                            <a href="{{ route('wizard::order') }}"><span>3.</span> PRINT TYPE</a>
                        @else
                            <span><span>3.</span> PRINT TYPE</span>
                        @endif
                    </li>
                    <li role="presentation" class="{{ Request::is('wizard/delivery*') ? 'active' : '' }}">
                        @if ($campaignLead->estimated_quantity)
                            <a href="{{ route('wizard::delivery') }}"><span>4.</span> DELIVERY</a>
                        @else
                            <span><span>4.</span> DELIVERY</span>
                        @endif
                    </li>
                    <li role="presentation" class="{{ Request::is('wizard/review*') ? 'active' : '' }}">
                        @if ($campaignLead->flexible)
                            <a href="{{ route('wizard::review') }}"><span>5.</span> REVIEW</a>
                        @else
                            <span><span>5.</span> REVIEW</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <div class="owl-carousel owl-theme owl-loaded simple-carousel" data-ride="carousel"
                     data-interval="false">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">
                            @foreach (garment_category_repository()->allActive() as $category)
                                <div class="owl-item {{ $category->id == $selectedCategoryId ? 'active' : '' }}">
                                    <div class="simple-carousel-item">
                                        <a href="{{ wizard_url(route('wizard::product_category', [category_to_url($category->id, $category->name)]), $search, $gender) }}"
                                           class="wizard-category {{ $category->id == $selectedCategoryId ? 'active' : '' }}"
                                           data-wizard-category="{{ $category->id }}"
                                           data-wizard-category-description="{{ category_to_url($category->id, $category->name) }}"
                                           data-wizard-url="{{ route('wizard::product_category', [category_to_url($category->id, $category->name)]) }}"
                                           v-on:click="selectCategory({{ $category->id }}, '{{ category_to_url($category->id, $category->name) }}', $event)">
                                            <div style="background-image: url({{ route('system::image', [$category->image_id]) }});">
                                                <p>{{ $category->name }}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row justify-content-md-center">
                <div class="col col-md-6">
                    <form method="get" class="wizard-search-form" v-on:submit="search($event)">
                        <div class="search-input-wrapper">
                            <input type="hidden" name="g" value="{{  $gender }}"/>
                            <input type="text" class="form-control search-input wizard-search" placeholder="Search"
                                   name="q" value="{{ $search }}" v-model="searchText">
                            <span class="search-input-btn-wrapper">
                            <button class="search-input-btn" type="submit">
                                @include('v3.partials.icons.search', ['width' => '28px', 'height' => '28px'])
                            </button>
                        </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row justify-content-md-center">
                <div class="col col-md-6">
                    <div class="text-center">
                        <a href="{{ wizard_url(route('wizard::product_category', [category_to_url($category->id, $category->name)]), $search) }}"
                           class="btn btn-sm btn-caps btn-default btn-hover-info wizard-gender {{ ($gender == 'a' || ! $gender) ? 'active' : '' }}"
                           data-wizard-gender="a" v-on:click="selectGender('a', $event)">All</a>
                        <a href="{{ wizard_url(route('wizard::product_category', [category_to_url($category->id, $category->name)]), $search, 'f') }}"
                           class="btn btn-sm btn-caps btn-default btn-hover-info wizard-gender {{ $gender == 'f' ? 'active' : '' }}"
                           data-wizard-gender="f" v-on:click="selectGender('f', $event)">Women's</a>
                        <a href="{{ wizard_url(route('wizard::product_category', [category_to_url($category->id, $category->name)]), $search, 'm') }}"
                           class="btn btn-sm btn-caps btn-default btn-hover-info wizard-gender {{ $gender == 'm' ? 'active' : '' }}"
                           data-wizard-gender="m" v-on:click="selectGender('m', $event)">Men's</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="simple-gallery">
                <div class="row wizard-products" ref="wizardProductList">
                    @foreach ($products as $product)
                        <div class="col-6 col-xs-6 col-sm-6 col-md-3 col-lg-3"
                             style="{{ $gender != 'a' && $product->gender->code != 'u' && $product->gender->code != $gender ? 'display: none;' : '' }}">
                            <div class="simple-gallery-entry {{ $product->id == $campaignLead->hasProduct($product->id) || $product->id == $selectedProductId ? 'active' : '' }}">
                                <a href="{{ route('wizard::product', [$product->id]) }}"
                                   class="simple-gallery-entry-link wizard-product"
                                   data-wizard-id="{{ $product->id }}"
                                   data-wizard-name="{{ stripslashes($product->name) }}"
                                   data-wizard-img="{{ route('system::image', [$product->image_id]) }}"
                                   data-wizard-style="{{ $product->style_number }}"
                                   data-wizard-type="{{ $product->category->name }}"
                                   data-wizard-gender="{{ $product->gender->code }}"
                                   data-wizard-size="{{ size_list($product->sizes) }}"
                                   data-wizard-price="{{ price_representation($product->price) }}"
                                   data-wizard-description="{{ $product->description }}"
                                   data-wizard-colors="{{ json_encode(color_list($product->active_colors)) }}"
                                   v-on:click="selectProduct({{ $product->id }}, $event)">
                                    <div class="simple-gallery-entry-image">
                                        <img src="{{ route('system::image', [$product->image_id]) }}"
                                             class="image-loading-disabled">
                                    </div>
                                    <div class="simple-gallery-entry-caption">
                                        <span>{{ $product->name }}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div v-if="loading" class="loading">
                    <ul class="bokeh">
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>
        <script type="text/x-template" id="wizard-product-template">
            <div class="col-6 col-xs-6 col-sm-6 col-md-3 col-lg-3" style="">
                <div class="simple-gallery-entry">
                    <a v-bind:href="link"
                       class="simple-gallery-entry-link wizard-product"
                       v-bind:data-wizard-id="id"
                       v-bind:data-wizard-name="name"
                       v-bind:data-wizard-img="img"
                       v-bind:data-wizard-style="style"
                       v-bind:data-wizard-size="size"
                       v-bind:data-wizard-price="price"
                       v-bind:data-wizard-description="description"
                       v-bind:data-wizard-colors="colors"
                       v-on:click="selectThisProduct($event)">
                        <div class="simple-gallery-entry-image">
                            <img v-bind:src="img" class="image-loading-disabled">
                        </div>
                        <div class="simple-gallery-entry-caption">
                            <span v-html="name"></span>
                        </div>
                    </a>
                </div>
            </div>
        </script>
        <script type="text/x-template" id="wizard-product-color-template">
            <li v-bind:data-wizard-product-color-id="id">
                <a v-bind:href="link"
                   v-bind:class="{ active: active }"
                   v-bind:title="name"
                   v-bind:data-wizard-product-color-name="name"
                   v-bind:data-wizard-product-color-image="image"
                   v-bind:data-wizard-product-color-id="id"
                   v-on:click="selectThisColor($event)">
                    <img v-bind:src="thumbnail" class="image-loading-disabled"/>
                </a>
            </li>
        </script>
        <div id="wizard-product-modal" class="modal" style="{{ $selectedProduct ? 'display: block;' : '' }}"
             tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">
                            <span class="wizard-product-name">{{ $selectedProduct ? $selectedProduct->name : '' }}</span>
                            (STYLE # <span
                                    class="wizard-product-style">{{ $selectedProduct ? $selectedProduct->style_number : '' }}</span>)
                            <span class="wizard-product-color-name"> {{ $selectedProductColor ? $selectedProductColor->name : ($selectedProduct ? $selectedProduct->colors->first()->name : '') }}</span>
                        </h6>
                        @if ($selectedProduct)
                            <a class="close" href="{{ route('wizard::product_category', [$selectedCategoryId]) }}"
                               data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        @else
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        @endif
                    </div>
                    <div class="modal-body">
                        <div class="wizard-product-modal">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <img class="wizard-product-preview img-fluid img-responsive image-loading-disabled"
                                             src="{{ $selectedProductColor ? route('system::image', [$selectedProductColor->image_id]) : static_asset('images/not_available.png') }}">
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        @include ('v3.partials.messages.all')
                                        <div class="wizard-product-colors mt-3">
                                            <p class="h6 text-sm">Choose a Color:</p>
                                            <ul class="color-list wizard-product-color-list"
                                                ref="wizardProductColorList">
                                                @if ($selectedProduct)
                                                    @foreach ($selectedProduct->colors as $productColor)
                                                        <li data-wizard-product-color-id="{{ $productColor->id }}">
                                                            <a href="{{ route('wizard::product', [$selectedProduct->id]) }}?c={{ $productColor->id }}"
                                                               class="{{ $selectedProductColorId && $productColor->id == $selectedProductColorId ? 'active' : '' }}{{ ! $selectedProductColorId && $loop->index == 0 ? 'active' : '' }}"
                                                               title="{{ $productColor->name }}"
                                                               data-wizard-product-color-name="{{ $productColor->name }}"
                                                               data-wizard-product-color-image="{{ route('system::image', [$productColor->image_id]) }}"
                                                               data-wizard-product-color-id="{{ $productColor->id }}"
                                                               v-on:click="selectColor({{ $productColor->id }}, $event)">
                                                                <img src="{{ route('system::image', [$productColor->thumbnail_id]) }}"
                                                                     class="image-loading-disabled"/>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="wizard-product-size">
                                            <span class="h6 title text-sm">Size:</span>
                                            <span class="text text-sm">{{ $selectedProduct ? $selectedProduct->sizes_text : '' }}</span>
                                        </div>
                                        <div class="wizard-product-price">
                                            <span class="h6 title text-sm">Pricing: </span>
                                            <span class="text text-sm">{{ $selectedProduct ? price_representation($selectedProduct->price) : '' }}</span>

                                        </div>
                                        <div class="wizard-product-description mt-3">
                                            <p class="h6 title-underline text-sm title">Product Description:</p>
                                            <div class="text text-xs text-justify color-slate font-weight-bold">
                                                {!! $selectedProduct ? bbcode($selectedProduct->description) : '' !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{ Form::open() }}
                        <input type="hidden" name="color_id" class="wizard-product-color-id"
                               value="{{ $selectedProductColorId ?? ($selectedProduct ? $selectedProduct->colors->first()->id : 0) }}"/>

                        @if ($selectedProduct)
                            <a class="btn btn-default"
                               href="{{ route('wizard::product_category', [$selectedCategoryId]) }}"
                               data-dismiss="modal">Close</a>
                        @else
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        @endif

                        <button type="submit" class="btn btn-primary">Next</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section ('javascript')

    @if ($selectedProduct)
        <script>
            wizard.selectProduct({{ $selectedProductId }});
            @if ($selectedProductColorId)
            wizard.selectColor({{ $selectedProductColorId }});
            @endif
        </script>
    @endif
@append
