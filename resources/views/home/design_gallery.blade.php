@extends ('customer')

@section ('title')
    @if ($designDisplay)
        {{ $designDisplay->name }}
    @else
        Design Gallery
    @endif
@append

@section ('metadata')
    @if ($designDisplay)
        <meta property="og:url"
              value="{{ route('home::design_gallery', [$designDisplay->id]) }}"/>
        <meta property="og:type" value="website"/>
        <meta property="og:title" value="{{ $designDisplay->name }} | Greek House"/>
        <meta property="og:site_name" value="Greek House"/>
        <meta property="og:description" value="Don't miss out on this design!"/>
        @if ($designDisplay->getThumbnail())
            <meta property="og:image" value="{{ route('system::image', [get_image_id($designDisplay->getThumbnail(),true)]) }}"/>
        @endif
        <meta name="p:domain_verify" content="205e0c139cd6a5d2093567a56916f331"/>
    @endif
@append

@section ('content')
    <style>
    </style>
    <!-- Design Gallery section -->
    <div class="light-gray-background-full-width cancel-header-margin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="design-gallery-box">
                        <h2 class="design-gallery-heading">DESIGN GALLERY</h2>
                        <h5 class="design-gallery-subheading">All designs can be customized for your chapter.</h5>
                        <div class="blue-line-centered"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="multiselect-container">
                                        <select class="form-control select2-multiple" multiple="multiple" id="select-multi" style="width: 100%" title="">
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag }}" selected="selected">{{ $tag }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 visible-xs text-center">
                                    <script>
                                        function scrollDown()
                                        {
                                            $('html, body').animate({ scrollTop: $('#carousel-row').offset().top }, 1000);
                                        }
                                    </script>
                                    <a href="javascript: scrollDown()" class="btn btn-info default-margin-vertical">Search</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of Design Gallery section -->

    <!-- Advance search section -->
    <div class="gray-background-full-width">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="advance-search-box">
                        <h3 class="advance-search-heading">ADVANCE SEARCH</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="btn-wrapper-advance-search">
                        <select class="filter-by tag-select select-options-dropdown-styling" title="" id="filter-event-themes" data-group="event,themes" data-caption="Event/Theme">
                        </select>
                        <select class="filter-by tag-select select-options-dropdown-styling" title="" id="filter-chapter" data-group="chapter" data-caption="Chapter">
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of Advance search section -->

    <!-- Trending heading section -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="decorated"><span class="designs-txt">TRENDING</span></h2>
            </div>
            <div class="col-12">
                <div class="centered-box">
                    <div class="button-wrapper-blue">
                        <button type="button" class="btn btn-primary btn-dimensions btn-helper-padding active filter-button" data-filter="all">
                            All
                        </button>
                        <button type="button" class="btn btn-primary btn-dimensions filter-button" data-filter="week">
                            Week
                        </button>
                        <button type="button" class="btn btn-primary btn-dimensions filter-button" data-filter="month">
                            Month
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of Trending heading section -->

    <!-- Carousel 4x2 section -->
    <div class="container">
        <div id="carousel-row">
            <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner" role="listbox" id="trending-designs-container">
                    @foreach ($trending->chunk(8) as $chunk)
                        <div class="item {{ $loop->first ? 'active' : '' }}">
                            <div class="row">
                                @foreach ($chunk as $design)
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 design-square">
                                        <a href="#" data-toggle="modal" data-target="#modalLarge" data-info="{{ $design->getInfo() }}" class="designs-anchor"><img class="designs-img design-entry"
                                                                                                                                                                   src="{{ route('system::image', [get_image_id()]) }}"></a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="left carousel-control" href="#carousel" data-slide="prev">
                    <img class="carousel-arrow-both carousel-arrow-left" src="{{ static_asset('images/gray-arrow-left.jpg') }}">
                </a>
                <a class="right carousel-control" href="#carousel" data-slide="next">
                    <img class="carousel-arrow-both carousel-arrow-right" src="{{ static_asset('images/gray-arrow-right.jpg') }}">
                </a>
            </div>
        </div>
    </div>
    <!-- end of Carousel 4x2 section -->

    <!-- Recent designs -->
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="decorated"><span class="designs-txt">RECENT DESIGNS</span></h2>
            </div>
        </div>
    </div>
    <!-- end of Recent designs -->

    <!-- 4x4 section of images -->
    <div class="container" id="recent-designs-container">
        @foreach ($recent->chunk(4) as $chunk)
            <div class="item {{ $loop->first ? 'active' : '' }}">
                <div class="row">
                    @foreach ($chunk as $design)
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 design-square">
                            <a href="#" data-toggle="modal" data-target="#modalLarge" data-info="{{ $design->getInfo() }}" class="designs-anchor"><img class="designs-img design-entry img-responsive"
                                                                                                                                                       src="{{ route('system::image', [get_image_id($design->getThumbnail(),true)]) }}"></a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <!-- end of 4x4 section of images -->

    <!-- Scroll down for more designs -->
    <div class="container">
        <div class="row margin-top-bottom">
            <div class="col-12">
                <div class="scroll-down-container">
                    <h5 class="scroll-down-design">SCROLL DOWN FOR MORE DESIGN</h5>
                    <img class="centered-img-arrow" src="{{ static_asset('images/blue-arrow-down.jpg') }}">
                </div>
                <div class="scroll-down-spinner" style="display: none">
                    <span class="fa fa-spinner fa-spin"></span> Loading...
                </div>
            </div>
        </div>
    </div>
    <!-- end of Scroll down for more designs -->

    <!-- Large modal -->
    <div class="modal fade modal-override" id="modalLarge" tabindex="-1" role="dialog" aria-labelledby="modalLargeTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-7">
                                <img class="designs-img modal-img-main" src="{{ static_asset('images/black-box-modal.jpg') }}">
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-5">
                                <h3 class="name-design-heading">Name of the design</h3>
                                <p class="design-code">#Code</p>
                                <div class="modal-image-list">
                                    <a class="modal-img-small-action">
                                        <img class="modal-img-small" src="{{ static_asset('images/black-box-modal.jpg') }}">
                                    </a>
                                </div>
                                <hr>
                                <a href="#" class="btn btn-primary btn-modal-style campaign-from-design">CUSTOMIZE THIS DESIGN ON A PRODUCT</a>
                                <div class="half-margin-top">
                                    <small>This design can be completely customized for your chapter! You can pick the product(s) you would like this design on, and let us know what you
                                        want changed
                                    </small>
                                </div>
                                <hr>
                                <p class="share-design-modal">Share the design:</p>
                                <div class="addthis_toolbox" addthis:url="{{ route('home::design_gallery') }}" addthis:description="Don't miss out on this shirt!" addthis:title=" | Greek House">
                                    <a class="social-network-link addthis_button_facebook at300b" href="javascript:void(0)" target="_blank">
                                        <img class="social-network-small" src="{{ static_asset('images/fb-logo.jpg') }}">
                                    </a>
                                    <a class="social-network-link addthis_button_twitter at300b" href="javascript:void(0)" target="_blank">
                                        <img class="social-network-small" src="{{ static_asset('images/tw-logo.jpg') }}">
                                    </a>
                                    <a href="javascript:void(0)" class="social-network-link addthis_button_pinterest_share at300b"
                                       target="_blank" title=""
                                       pi:pinit:description="Don't miss out on this shirt! - "
                                       pi:pinit:layout="horizontal"
                                       pi:pinit:url="{{ route('home::design_gallery') }}" id="addthis_toolbox_pinterest">
                                        <img src="{{ static_asset('images/icon_pt.png') }}" alt="icon-social" class="social-network-small" data-pin-nopin="true"></a>
                                    <?php register_js('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5416f2ad4d856633') ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="decorated">Similar designs you'll love</h3>
                            </div>
                            <div id="carousel-modal" class="carousel slide" data-ride="carousel" data-interval="3000">
                                <div class="carousel-inner" role="listbox">
                                    <div class="item active">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <a href="#">
                                                    <img class="img-fluid black-img-modal" src="{{ static_asset('images/black-box-modal.jpg') }}">
                                                </a>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="#">
                                                    <img class="img-fluid black-img-modal" src="{{ static_asset('images/black-box-modal.jpg') }}">
                                                </a>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="#">
                                                    <img class="img-fluid black-img-modal" src="{{ static_asset('images/black-box-modal.jpg') }}">
                                                </a>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="#">
                                                    <img class="img-fluid black-img-modal" src="{{ static_asset('images/black-box-modal.jpg') }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <a href="#">
                                                    <img class="img-fluid black-img-modal" src="{{ static_asset('images/black-box-modal.jpg') }}">
                                                </a>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="#">
                                                    <img class="img-fluid black-img-modal" src="{{ static_asset('images/black-box-modal.jpg') }}">
                                                </a>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="#">
                                                    <img class="img-fluid black-img-modal" src="{{ static_asset('images/black-box-modal.jpg') }}">
                                                </a>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="#">
                                                    <img class="img-fluid black-img-modal" src="{{ static_asset('images/black-box-modal.jpg') }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#carousel-modal" class="left carousel-control hidden-sm-down left-modal-arrow" role="button" data-slide="prev">
                                    <img class="carousel-arrow-both-modal carousel-arrow-modal-left" src="{{ static_asset('images/arrows-left.png') }}">
                                </a>
                                <a href="#carousel-modal" class="right carousel-control hidden-sm-down right-modal-arrow" role="button" data-slide="next">
                                    <img class="carousel-arrow-both-modal carousel-arrow-modal-right" src="{{ static_asset('images/arrows-right.png') }}">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of Large modal -->
@append

@section ('include')
    <link href="{{ static_asset('css/style_new.css') . '?v=' . config('greekhouse.css_version') }}?" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
@append

@section ('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script type="text/javascript">
        var data = {!! json_encode(array_merge([['id' => '', 'text' => '']], design_tag_repository()->getTagJSONList(['themes', 'chapter', 'general', 'themes', 'event']))) !!};

        $(".select2-multiple").select2({
            allowClear: true,
            data: data,
            tags: true,
            minimumInputLength: 1
        });
        $('.select2-multiple').on("select2:select", load_trending_data);
        $('.select2-multiple').on("select2:unselect", load_trending_data);

        $(document).ready(function () {
            $(".filter-button").click(function () {
                var value = $(this).attr('data-filter');

                if ($(".filter-button").removeClass("active")) {
                    $(this).removeClass("active");
                }
                $(this).addClass("active");

                load_trending_data();
            });
        });

        var dataThemeEvents = {!! json_encode(array_merge([['id' => '', 'text' => '']], design_tag_repository()->getTagJSONList(['themes', 'event']))) !!};
        var dataChapters = {!! json_encode(array_merge([['id' => '', 'text' => '']], design_tag_repository()->getTagJSONList('chapter'))) !!};

        $("#filter-event-themes").each(function () {
            $(this).select2({
                data: dataThemeEvents,
                allowClear: true,
                placeholder: "Filter by " + $(this).attr('data-caption')
            });
        });
        $("#filter-chapter").each(function () {
            $(this).select2({
                data: dataChapters,
                allowClear: true,
                placeholder: "Filter by " + $(this).attr('data-caption')
            });
        });
        $(".tag-select").on("change", load_trending_data);
        $('.tag-select').on('select2:unselecting', function () {
            var opts = $(this).data('select2').options;
            opts.set('disabled', true);
            setTimeout(function () {
                opts.set('disabled', false);
            }, 1);
        });

        var GreekHouse = {
            scrollLoad: true,
            scrollLoadMaxBatches: 999,
            scrollLoadBatchCount: 0,
            galleryPage: {
                modal: {
                    element: $('#modalLarge'),
                    name: $('#modalLarge h3.name-design-heading'),
                    code: $('#modalLarge .design-code'),
                    image: $('#modalLarge img.modal-img-main'),
                    list: $('#modalLarge .modal-image-list'),
                    download: $('#modalLarge .link-modal'),
                    related1: $('#modalLarge #carousel-modal .item:first-child'),
                    related2: $('#modalLarge #carousel-modal .item:last-child'),
                    campaign: $('#modalLarge .campaign-from-design'),
                    toolbox: $('#modalLarge .addthis_toolbox'),
                    toolbox_pinterest: $('#modalLarge .addthis_toolbox_pinterest')
                }
            }
        };

        // Modal loading etc
        $('body').on('click', '.designs-anchor', function (e) {
            var info = JSON.parse($(this).attr('data-info'));
            GreekHouse.galleryPage.modal.name.text(info.name);
            GreekHouse.galleryPage.modal.code.text(info.code);
            GreekHouse.galleryPage.modal.image.attr('src', info.images[0]);
            GreekHouse.galleryPage.modal.download.attr('href', info.download ? info.download : '#');
            GreekHouse.galleryPage.modal.list.html('');
            for (var i = 0; i < info.images.length; i++) {
                GreekHouse.galleryPage.modal.list.append($('<a class="modal-img-small-action"><img class="modal-img-small" src="' + info.images[i] + '"/></a>'));
            }
            GreekHouse.galleryPage.modal.campaign.attr('href', "{{ route('wizard::start') }}/" + info.id);
            GreekHouse.galleryPage.modal.toolbox.attr('addthis:url', '{{ route('home::design_gallery') }}/' + info.id);
            GreekHouse.galleryPage.modal.toolbox.attr('addthis:title', info.name + " | Greek House");
            GreekHouse.galleryPage.modal.toolbox_pinterest.attr('title', info.name + " | Greek House");
            GreekHouse.galleryPage.modal.toolbox_pinterest.attr('pi:pinit:description', 'Don\'t miss out on this shirt!');
            GreekHouse.galleryPage.modal.toolbox_pinterest.attr('pi:pinit:url', '{{ route('home::design_gallery') }}/' + info.id);
            document.title = info.name + " | Greek House";
            window.history.pushState('page', info.name + " | Greek House", '{{ route('home::design_gallery') }}/' + info.id);
            GreekHouse.galleryPage.modal.related1.html('<div class="row"/>');
            GreekHouse.galleryPage.modal.related2.html('<div class="row"/>');
            $.getJSON("{{ route('home::ajax_design_gallery') }}/" + info.id, function (data) {
                for (i = 0; i < data.related.length && i < 4; i++) {
                    GreekHouse.galleryPage.modal.related1.append($('<div class="col-sm-3"><a href="' + data.related[i].url + '"><img class="img-fluid black-img-modal" src="' + data.related[i].thumbnail + '"></a> </div>'));
                }
                for (i = 4; i < data.related.length; i++) {
                    GreekHouse.galleryPage.modal.related2.append($('<div class="col-sm-3"><a href="' + data.related[i].url + '"><img class="img-fluid black-img-modal" src="' + data.related[i].thumbnail + '"></a> </div>'));
                }
            });
        });

        GreekHouse.galleryPage.modal.element.on('hide.bs.modal', function () {
            document.title = "Design Gallery | Greek House";
            window.history.pushState('page', "Design Gallery | Greek House", '{{ route('home::design_gallery') }}');
        });

        $('body').on('click', '.modal-img-small-action', function (e) {
            GreekHouse.galleryPage.modal.image.attr('src', $(this).find('img').attr('src'));
        });

        // Scroll down to load more functionality
        $(window).scroll(function () {
            if (GreekHouse.scrollLoad && GreekHouse.scrollLoadBatchCount < GreekHouse.scrollLoadMaxBatches && $(window).scrollTop() >= $(document).height() - $(window).height() - 300) {
                GreekHouse.scrollLoad = false;
                show_spinner();
                // Mime :)
                setTimeout(function () {
                    load_recent_data()
                }, 2000);
                console.log('Done!');
            }

            if (GreekHouse.scrollLoadBatchCount >= GreekHouse.scrollLoadMaxBatches) {
                hide_scroll_down_to_show_more();
            }
        });

        var page = 0;

        function load_recent_data() {
            console.log('Fetching recent data...');
            page++;
            $.getJSON("{{ route('system::design_gallery_recent') }}?page=" + page, function (data) {
                var row = $('<div class="row" />');
                $.each(data.data, function (key, val) {
                    var element = $('<div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 design-square" />');
                    var info = JSON.parse(val.info);
                    var imageLink = $('<a href="#" data-toggle="modal" data-target="#modalLarge" class="designs-anchor"/>');
                    imageLink.append($('<img class="designs-img design-entry" />').attr('src', info.thumbnail));
                    imageLink.attr('data-info', val.info);
                    element.append(imageLink);
                    row.append(element);
                });

                $('#recent-designs-container').append(row);
            });

            GreekHouse.scrollLoad = true;
            GreekHouse.scrollLoadBatchCount += 1;
            hide_spinner();
        }

        var haltProcessingTrending = false;

        function load_trending_data() {
            if (haltProcessingTrending) {
                return;
            }
            console.log('Fetching trending data...');

            var tags = $('.select2-multiple').val() && $('.select2-multiple').val().length > 0 ? $('.select2-multiple').val() : [];
            var changed = false;
            $('.tag-select').each(function () {
                if ($(this).val()) {
                    tags.push($(this).val().trim());
                    changed = true;
                    haltProcessingTrending = true;
                    $(this).val([]).trigger("change");
                    haltProcessingTrending = false;
                }
            });
            if (changed == true) {
                haltProcessingTrending = true;
                $('.select2-multiple').val(tags).trigger("change");
                haltProcessingTrending = false;
            }

            var tagText = '';
            tags.forEach(function (value) {
                if (tagText) {
                    tagText += ',';
                }
                tagText += encodeURIComponent(value);
            });
            if (tags.length > 0) {
                window.history.pushState('page', "Design Gallery | Greek House", '{{ route('home::design_gallery') }}?tags=' + tags);
            } else {
                window.history.pushState('page', "Design Gallery | Greek House", '{{ route('home::design_gallery') }}');
            }

            page++;
            $.getJSON("{{ route('system::design_gallery_trending') }}?period=" + $('.filter-button.active').attr('data-filter') + '&tags=' + encodeURIComponent(tags.join()), function (data) {
                $('#trending-designs-container').html('');
                var item = $('<div class="item active"></div>');
                var row = $('<div class="row" />');
                $.each(data.data, function (key, val) {
                    var element = $('<div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 design-square" />');
                    var info = JSON.parse(val.info);
                    var imageLink = $('<a href="#" data-toggle="modal" data-target="#modalLarge" class="designs-anchor"/>');
                    imageLink.append($('<img class="designs-img design-entry" />').attr('src', info.thumbnail));
                    imageLink.attr('data-info', val.info);
                    element.append(imageLink);
                    row.append(element);
                    if (key === 7) {
                        item.append(row);
                        $('#trending-designs-container').append(item);
                        item = $('<div class="item"></div>');
                        row = $('<div class="row" />');
                    }
                });
                item.append(row);
                $('#trending-designs-container').append(item);
                $('#carousel').carousel();
            });

            GreekHouse.scrollLoad = true;
            GreekHouse.scrollLoadBatchCount += 1;
            hide_spinner();
        }

        function show_spinner() {
            $('.scroll-down-spinner').show();
            $('.scroll-down-container').hide();
        }

        function hide_spinner() {
            $('.scroll-down-spinner').hide();
            $('.scroll-down-container').show();
        }

        function hide_scroll_down_to_show_more() {
            $('.scroll-down-spinner').hide();
            $('.scroll-down-container').hide();
        }

        @if ($designDisplay)
        GreekHouse.galleryPage.modal.name.text("{!! strip_tags($designDisplay->name) !!}");
        GreekHouse.galleryPage.modal.code.text({!! strip_tags($designDisplay->code) !!});
        GreekHouse.galleryPage.modal.image.attr('src', "{{ route('system::image', [$designDisplay->enabled_images->count() > 0 ? $designDisplay->enabled_images->first()->file_id : '#']) }}");
        GreekHouse.galleryPage.modal.download.attr('href', "{{ $designDisplay->enabled_images->count() > 0 ? route('system::image', [$designDisplay->enabled_images->first()->file_id]) : '#' }}");
        GreekHouse.galleryPage.modal.campaign.attr('href', "{{ route('wizard::start', [$designDisplay->id]) }}");
        GreekHouse.galleryPage.modal.list.html('');
        @foreach ($designDisplay->enabled_images as $image)
        GreekHouse.galleryPage.modal.list.append($('<a class="modal-img-small-action"><img class="modal-img-small" src="{{ route('system::image', [$image->file_id]) }}"/></a>'));
        @endforeach
        GreekHouse.galleryPage.modal.related1.html('<div class="row"/>');
        GreekHouse.galleryPage.modal.related2.html('<div class="row"/>');
        @foreach ($designDisplay->getRelated()->chunk(4) as $chunk)
                @if ($loop->first)
            related = GreekHouse.galleryPage.modal.related1;
        @else
            related = GreekHouse.galleryPage.modal.related2;
        @endif
        @foreach ($chunk as $design)
        related.find('.row').append('<div class="col-sm-3"><a href="{{ route('home::design_gallery', [$design->id]) }}"><img class="img-fluid black-img-modal" src="{{ route('system::image', [get_image_id($design->getThumbnail(), true)]) }}"></a> </div>');
        @endforeach
        @endforeach
        GreekHouse.galleryPage.modal.toolbox.attr('addthis:url', '{{ route('home::design_gallery', [$designDisplay->id]) }}');
        GreekHouse.galleryPage.modal.toolbox.attr('addthis:title', "{{ $designDisplay->name }} | Greek House");
        GreekHouse.galleryPage.modal.toolbox_pinterest.attr('title', "{{ $designDisplay->name }} | Greek House");
        GreekHouse.galleryPage.modal.toolbox_pinterest.attr('pi:pinit:description', 'Don\'t miss out on this shirt!');
        GreekHouse.galleryPage.modal.toolbox_pinterest.attr('pi:pinit:url', '{{ route('home::design_gallery', [$designDisplay->id]) }}');
        GreekHouse.galleryPage.modal.element.modal('show');
        @endif
    </script>
@append