//TODO: File not being used. Just for phase 2 reference

@extends('v2.layouts.app')

@section('title', 'My Store')

@section('content')
    <div class="store landing">
{{--dd($campaigns[0]->contact_chapter)--}}
    <section class="intro">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="gh-title blue text-uppercase">Shop live sales for {{$chapterName}}</h1>
                    <h5 class="gh-subtitle">
                        Live Sales Campaigns are added every week! Orders ship 7-10 business days the live sales campaign closes.
                    </h5>
                </div>
            </div>
        </div>
    </section>
    <section class="products">
        <h3 class="gh-title blue text-uppercase">Your Organization's Products</h3>
         @include('v2.home.custom_store.partials.products', ['products' => null, 'campaigns'=> $campaigns, 'class' => ''])
    </section>

    @include('v2.home.custom_store.partials.get_featured', ['className' => ''])

    @include('v2.home.custom_store.partials.get_involved')
</div>
@endsection

@section ('javascript')
    <script>

         function addToBasket(id) {
             $.getJSON("?id=" + id, function (data) {
                 //if true, change button state
                 //if not, not...
             });
         }

         $(document).ready(function () {
             $(".add_to_basket").click(function () {
                 addToBasket(productId);
             });
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

             //history.pushState('data', '', '/wizard/product/category/' + categoryUrl);
             showProducts(results);
             hideLoading();
             //scrollToGenders();
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
             });
         }

         $('#chaptersTabs').on('shown.bs.tab', function (e) {
             $('li.nav-item').removeClass('active');
             $(e.target).closest('li.nav-item').addClass('active');
         })
    </script>
@append