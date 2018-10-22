@extends('v2.layouts.app')

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
            <meta property="og:image" value="{{ route('system::image', [get_image_id($designDisplay->getThumbnail(), true)]) }}"/>
        @endif
        <meta name="p:domain_verify" content="205e0c139cd6a5d2093567a56916f331"/>
    @endif
@append

@section('content')
    <div class="block-container-small background-light-grey">
        <div class="container text-center">
            <h1 class="title-standard">Design Gallery</h1>
            <p class="subtitle-text">All Designs can be customized for your chapter</p>
            <hr class="separator-short"/>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="multiselect-container">
                        <select class="form-control select2-multiple" multiple="multiple" id="select-multi" style="width: 100%" title="">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag }}" selected="selected">{{ $tag }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 d-sm-none">
                    <script>
                        function scrollDown() {
                            $('html, body').animate({scrollTop: $('#carousel-row').offset().top}, 1000);
                        }
                    </script>
                    <a href="javascript: scrollDown()" class="btn btn-blue mt-5">Search</a>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container-small background-grey">
        <div class="container">
            <h2 class="title-black">Advance Search</h2>
            <div class="btn-wrapper-advance-search">
                <select class="filter-by tag-select select-options-dropdown-styling" title="" id="filter-event-themes" data-group="event,themes" data-caption="Event/Theme">
                </select>
                <select class="filter-by tag-select select-options-dropdown-styling" title="" id="filter-chapter" data-group="chapter" data-caption="Chapter">
                </select>
            </div>
        </div>
    </div>
    <div class="block-container-small" id="design-gallery-trending" style="{{ $tags->count() != 0 ? 'display: none' : ''}}">
        <div class="container text-center p-0">
            <h2 class="title-lined line-space-1"><span class="title-lined-text">Trending</span></h2>
            <div class="action-tab">
                <button type="button" class="btn active filter-button" data-filter="all">All</button>
                <button type="button" class="btn filter-button" data-filter="week">Week</button>
                <button type="button" class="btn filter-button" data-filter="month">Month</button>
            </div>
            <div id="carousel-row" class="mt-4">
                <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner" role="listbox" id="trending-designs-container">
                        @foreach ($trending->chunk(8) as $chunk)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <div class="row">
                                    @foreach ($chunk as $design)
                                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-3 design-square">
                                            <a href="#" data-toggle="modal" data-target="#modalLarge" data-info="{{ $design->getInfo() }}" class="designs-anchor"><img class="designs-img design-entry"
                                                                                                                                                                       src="{{ route('system::image', [get_image_id($design->getThumbnail(),true)]) }}"></a>
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
    </div>
    <div class="block-container-small" id="design-gallery-results" style="{{ $tags->count() == 0 ? 'display: none' : ''}}">
        <div class="container text-center">
            <h2 class="title-lined line-space-1"><span class="title-lined-text">Results</span></h2>
        </div>
        <div class="container mt-2 p-0" id="result-designs-container">
            @foreach ($results->chunk(4) as $chunk)
                <div class="item {{ $loop->first ? 'active' : '' }}">
                    <div class="row">
                        @foreach ($chunk as $design)
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-3 design-square">
                                <a href="#" data-toggle="modal" data-target="#modalLarge" data-info="{{ $design->getInfo() }}" class="designs-anchor"><img
                                            class="designs-img design-entry img-responsive"
                                            src="{{ route('system::image', [get_image_id($design->getThumbnail(),true)]) }}"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="block-container-small" id="design-gallery-recent">
        <div class="container text-center">
            <h2 class="title-lined line-space-2"><span class="title-lined-text">Recent Designs</span></h2>
        </div>
        <div class="container mt-2 p-0" id="recent-designs-container">
            @foreach ($recent->chunk(4) as $chunk)
                <div class="item {{ $loop->first ? 'active' : '' }}">
                    <div class="row">
                        @foreach ($chunk as $design)
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-3 design-square">
                                <a href="#" data-toggle="modal" data-target="#modalLarge" data-info="{{ $design->getInfo() }}" class="designs-anchor"><img
                                            class="designs-img design-entry img-responsive"
                                            src="{{ route('system::image', [get_image_id($design->getThumbnail(),true)]) }}"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="container">
            <div class="row">
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
    </div>

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
                                <hr class="mb-4 mt-4"/>
                                <a href="#" class="btn btn-primary btn-modal-style campaign-from-design">CUSTOMIZE THIS DESIGN ON A PRODUCT</a>
                                <div class="mb-3 mt-3">
                                    <small>This design can be completely customized for your chapter! You can pick the product(s) you would like this design on, and let us know what you
                                        want changed
                                    </small>
                                </div>
                                <hr class="mt-4"/>
                                <p class="share-design-modal mt-4 mb-1">Share the design:</p>
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
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="decorated mt-3">Similar designs you'll love</h3>
                            </div>
                            <div id="carousel-modal" class="carousel slide" data-ride="carousel" data-interval="3000">
                                <div class="carousel-inner" role="listbox">
                                    <div class="carousel-item active">
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
                                    <div class="carousel-item">
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
@endsection

@section ('style')
@append

@section ('javascript')
    <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5416f2ad4d856633" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({ cache: false });
        });
        var data = {!! json_encode(array_merge([['id' => '', 'text' => '']], design_tag_repository()->getTagJSONList(['themes', 'chapter', 'general', 'themes', 'event']))) !!};

        $(".select2-multiple").select2({
            allowClear: true,
            data: data,
            tags: true,
            minimumInputLength: 1
        });
        $('.select2-multiple').on("select2:select", load_data_from_search);
        $('.select2-multiple').on("select2:unselect", load_data_from_search);

        $(document).ready(function () {
            $(".filter-button").click(function () {
                var value = $(this).attr('data-filter');

                if ($(".filter-button").removeClass("active")) {
                    $(this).removeClass("active");
                }
                $(this).addClass("active");

                load_data_from_search();
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
        $(".tag-select").on("change", load_data_from_search);
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
                    related1: $('#modalLarge #carousel-modal .carousel-item:first-child'),
                    related2: $('#modalLarge #carousel-modal .carousel-item:last-child'),
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
                var related = $.map(data.related, function (value, index) {
                    return [value];
                });
                for (i = 0; i < related.length && i < 4; i++) {
                    GreekHouse.galleryPage.modal.related1.append($('<div class="col-6 col-sm-3"><a href="' + related[i].url + '"><img class="img-fluid black-img-modal" src="' + related[i].thumbnail + '"></a> </div>'));
                }
                for (i = 4; i < related.length; i++) {
                    GreekHouse.galleryPage.modal.related2.append($('<div class="col-6 col-sm-3"><a href="' + related[i].url + '"><img class="img-fluid black-img-modal" src="' + related[i].thumbnail + '"></a> </div>'));
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
                    load_data_from_recent();
                }, 2000);
                console.log('Done!');
            }

            if (GreekHouse.scrollLoadBatchCount >= GreekHouse.scrollLoadMaxBatches) {
                hide_scroll_down_to_show_more();
            }
        });

        var page = 0;

        var haltProcessingRecent = false;

        function load_data_from_recent() {
            load_recent_data(false);
        }

        function load_data_from_search() {
            if (haltProcessingRecent) {
                return;
            }

            var tags = $('.select2-multiple').val() && $('.select2-multiple').val().length > 0 ? $('.select2-multiple').val() : [];
            var changed = false;
            $('.tag-select').each(function () {
                if ($(this).val()) {
                    tags.push($(this).val().trim());
                    changed = true;
                    haltProcessingRecent = true;
                    $(this).val([]).trigger("change");
                    haltProcessingRecent = false;
                }
            });
            if (changed == true) {
                haltProcessingRecent = true;
                $('.select2-multiple').val(tags).trigger("change");
                haltProcessingRecent = false;
            }

            var tagText = '';
            tags.forEach(function (value) {
                if (tagText) {
                    tagText += ',';
                }
                tagText += encodeURIComponent(value);
            });
            if (tags.length > 0) {
                window.history.pushState('page', "Design Gallery | Greek House", '{{ route('home::design_gallery') }}?tags=' + encodeURIComponent(tagText));
            } else {
                window.history.pushState('page', "Design Gallery | Greek House", '{{ route('home::design_gallery') }}');
            }

            load_result_data(tags);
        }

        function load_result_data(tags) {
            console.log('Fetching result data...');
            if (tags.length > 0) {
                $('#design-gallery-results').show();
                $('#design-gallery-trending').hide();
            } else {
                $('#design-gallery-results').hide();
                $('#design-gallery-trending').show();
            }

            var tagText = '';
            tags.forEach(function (value) {
                if (tagText) {
                    tagText += ',';
                }
                tagText += encodeURIComponent(value);
            });

            $('#result-designs-container').html('');
            $.getJSON("{{ route('system::design_gallery_recent') }}?page=0&pageSize=9999&tags=" + encodeURIComponent(tagText), function (data) {
                var row = $('<div class="row" />');
                $.each(data.data, function (key, val) {
                    var element = $('<div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-3 design-square" />');
                    var info = JSON.parse(val.info);
                    var imageLink = $('<a href="#" data-toggle="modal" data-target="#modalLarge" class="designs-anchor"/>');
                    imageLink.append($('<img class="designs-img design-entry" />').attr('src', info.thumbnail));
                    imageLink.attr('data-info', val.info);
                    element.append(imageLink);
                    row.append(element);
                });

                $('#result-designs-container').append(row);
            }
        );

        GreekHouse.scrollLoad = true;
        GreekHouse.scrollLoadBatchCount += 1;
        hide_spinner();
        }

        function load_recent_data(startOver = false) {
            console.log('Fetching recent data...');

            if (startOver) {
                page = 0;
                $('#recent-designs-container').html('');
            } else {
                page++;
            }
            $.getJSON("{{ route('system::design_gallery_recent') }}?page=" + page, function (data) {
                var row = $('<div class="row" />');
                $.each(data.data, function (key, val) {
                    var element = $('<div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-3 design-square" />');
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

        function load_trending_data() {
            console.log('Fetching trending data...');

            $.getJSON("{{ route('system::design_gallery_trending') }}?period=" + $('.filter-button.active').attr('data-filter'), function (data) {
                $('#trending-designs-container').html('');
                var item = $('<div class="carousel-item active"></div>');
                var row = $('<div class="row" />');
                $.each(data.data, function (key, val) {
                    var element = $('<div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-3 design-square" />');
                    var info = JSON.parse(val.info);
                    var imageLink = $('<a href="#" data-toggle="modal" data-target="#modalLarge" class="designs-anchor"/>');
                    imageLink.append($('<img class="designs-img design-entry" />').attr('src', info.thumbnail));
                    imageLink.attr('data-info', val.info);
                    element.append(imageLink);
                    row.append(element);
                    if (key === 7) {
                        item.append(row);
                        $('#trending-designs-container').append(item);
                        item = $('<div class="carousel-item"></div>');
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
        GreekHouse.galleryPage.modal.image.attr('src', "{{ route('system::image', [$designDisplay->enabled_images->count() > 0 ? get_image_id($designDisplay->enabled_images->first()->file_id,true) : '#']) }}");
        GreekHouse.galleryPage.modal.download.attr('href', "{{ $designDisplay->enabled_images->count() > 0 ? route('system::image', [get_image_id($designDisplay->enabled_images->first()->file_id, true)]) : '#' }}");
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
        related.find('.row').append('<div class="col-6 col-sm-3"><a href="{{ route('home::design_gallery', [$design->id]) }}"><img class="img-fluid black-img-modal" src="{{ route('system::image', [get_image_id($design->getThumbnail(),true)]) }}"></a> </div>');
        @endforeach
        @endforeach
        GreekHouse.galleryPage.modal.toolbox.attr('addthis:url', '{{ route('home::design_gallery', [$designDisplay->id]) }}');
        GreekHouse.galleryPage.modal.toolbox.attr('addthis:title', "{{ $designDisplay->name }} | Greek House");
        GreekHouse.galleryPage.modal.toolbox_pinterest.attr('title', "{{ $designDisplay->name }} | Greek House");
        GreekHouse.galleryPage.modal.toolbox_pinterest.attr('pi:pinit:description', 'Don\'t miss out on this shirt!');
        GreekHouse.galleryPage.modal.toolbox_pinterest.attr('pi:pinit:url', '{{ route('home::design_gallery', [$designDisplay->id]) }}');
        GreekHouse.galleryPage.modal.element.modal('show');
        @endif

        $('.select2-multiple').on('select2:close', function (e) {
            var element = $(this).closest($('select[name ="' + e.currentTarget.name + '"'));
            var that = this;
            var setfocus = setTimeout(function () {
                $(that).closest('.multiselect-container').find('.select2-search__field').focus();
            }, 100);
        });
    </script>
@append
