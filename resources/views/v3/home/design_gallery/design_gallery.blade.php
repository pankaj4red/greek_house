@extends('v3.layouts.app')

@section ('title')
    @if ($designDisplay)
        {{ $designDisplay->name }}
    @else
        Design Gallery
    @endif
@append

@section ('metadata')
    @if ($designDisplay)
        <meta property="og:url" value="{{ route('home::design_gallery', [$designDisplay->id]) }}"/>
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
    <div id="design-gallery" data-design-id="{{ $designDisplay ? $designDisplay->id : '' }}">
        <div id="design-gallery-tags">
            <div class="bg-lighter">
                <div class="container text-center pt-4 pb-4">
                    <h1 class="h2">Design Galleryss</h1>
                    <p class="font-lg">All Designs can be customized for your chapter</p>
                    <hr class="short-blue"/>
                    <div class="row">
                        <div class="col-12 col-md-8 offset-md-2">
                            <div class="multiselect-container">
                                <select class="form-control select2-multiple" multiple="multiple" id="design-gallery-tag-select" style="width: 100%" title="">
                                    @foreach ($tags as $tag)
                                        <option value="{{ urldecode($tag) }}" selected="selected">{{ urldecode($tag) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 d-sm-none">
                            <a href="javascript: scrollDown()" class="btn btn-blue mt-5">Search</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-light">
                <div class="container text-center pt-4 pb-4">
                    <div class="block-container-small background-grey">
                        <div class="container">
                            <p class="h5">Advance Search</p>
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
        </div>
        <script type="text/x-template" id="design-gallery-entry-template">
            <div class="col-6 col-lg-3 design-gallery-entry" v-bind:data-design-gallery-id="id">
                <a v-bind:href="link" data-toggle="modal" data-target="#modalLarge" v-bind:data-info="info" v-on:click="selectThisDesign($event)">
                    <img class="w-100 mh-100px image-loading" v-bind:src="thumbnail" v-images-loaded:on.progress="imageProgress">
                </a>
            </div>
        </script>
        <div class="container text-center pt-4 pb-4" id="design-gallery-trending" v-show="tags.length == 0">
            <h2 class="h4-line"><span class="h4">Trending</span></h2>
            <div class="button-list">
                <a href="{{ route('home::design_gallery') }}" data-gallery-period="all" class="btn {{ ! in_array($period, ['week', 'month']) ? 'active' : ''}}">All</a>
                <a href="{{ route('home::design_gallery') }}?period=week" data-gallery-period="week" class="btn {{ $period == 'week' ? 'active' : ''}}">Week</a>
                <a href="{{ route('home::design_gallery') }}?period=month" data-gallery-period="month" class="btn {{ $period == 'month' ? 'active' : ''}}">Month</a>
            </div>
            <div id="carousel-row" class="mt-4">
                <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner" role="listbox" id="design-gallery-trending-list">
                        @foreach ($trending->chunk(8) as $chunk)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <div class="row">
                                    @foreach ($chunk as $design)
                                        <div class="col-6 col-lg-3 design-gallery-entry" data-design-gallery-id="{{ $design->id }}">
                                            <a href="{{ route('home::design_gallery', [$design->id]) }}" data-toggle="modal" data-target="#modalLarge" data-info="{{ $design->getInfo() }}"
                                               v-on:click="selectDesign({{ $design->id }}, $event)">
                                                <img class="w-100 mh-100px image-loading" src="{{ route('system::image', [get_image_id($design->getThumbnail(),true)]) }}">
                                            </a>
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
        <div class="container text-center mt-4" id="design-gallery-results" v-show="tags.length > 0">
            <h2 class="h4-line"><span class="h4">Results</span></h2>
            <div class="mt-2 p-0" id="design-gallery-results-list" ref="designGalleryResults">
                @foreach ($results->chunk(4) as $chunk)
                    <div class="row">
                        @foreach ($chunk as $design)
                            <div class="col-6 col-lg-3 design-gallery-entry" data-design-gallery-id="{{ $design->id }}">
                                <a href="{{ route('home::design_gallery', [$design->id]) }}" data-toggle="modal" data-target="#modalLarge" data-info="{{ $design->getInfo() }}"
                                   v-on:click="selectDesign({{ $design->id }}, $event)">
                                    <img class="w-100 mh-100px image-loading" src="{{ route('system::image', [get_image_id($design->getThumbnail(), true)]) }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="scroll-down-spinner" v-if="searchLoading">
                        <div class="loading">
                            <ul class="bokeh">
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="design-gallery-recent">
            <div class="container text-center mt-4">
                <h2 class="h4-line sp-2"><span class="h4">Recent Designs</span></h2>
                <div id="design-gallery-recent" class="mt-2" ref="designGalleryRecent">
                    @foreach ($recent->chunk(4) as $chunk)
                        <div class="row">
                            @foreach ($chunk as $design)
                                <div class="col-6 col-lg-3 design-gallery-entry" data-design-gallery-id="{{ $design->id }}">
                                    <a href="{{ route('home::design_gallery', [$design->id]) }}" data-toggle="modal" data-target="#modalLarge" data-info="{{ $design->getInfo() }}"
                                       v-on:click="selectDesign({{ $design->id }}, $event)">
                                        <img class="w-100 mh-100px image-loading" src="{{ route('system::image', [get_image_id($design->getThumbnail(), true)]) }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="scroll-down-container" v-if="! scrollLoading">
                            <h5 class="scroll-down-design">SCROLL DOWN FOR MORE DESIGN</h5>
                            <img class="centered-img-arrow" src="{{ static_asset('images/blue-arrow-down.jpg') }}">
                        </div>
                        <div class="scroll-down-spinner" v-else>
                            <div class="loading">
                                <ul class="bokeh">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Large modal -->
        <div class="modal {{ $designDisplay ? 'show' : '' }}" id="design-gallery-modal" tabindex="-1" role="dialog" aria-labelledby="modalLargeTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid">
                            @if ($designDisplay)
                                <a class="close" href="{{ route('home::design_gallery') }}" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </a>
                            @else
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            @endif
                            <div class="row">
                                <div class="col-12 col-lg-7">
                                    @if ($designDisplay)
                                        <img class="w-100 mh-200px image-loading" src="{{ route('system::image', [get_image_id($designDisplay->getThumbnail(), true)]) }}" ref="designDisplayImage">
                                    @else
                                        <img class="w-100 mh-200px image-loading" src="{{ static_asset('images/black-box-modal.jpg') }}" ref="designDisplayImage">
                                    @endif
                                </div>
                                <script type="text/x-template" id="design-gallery-image-entry-template">
                                    <a class="pb-1 pr-1 d-inline-block design-image cursor-pointer" v-on:click="selectThisImage($event)">
                                        <img class="w-85px image-loading" v-bind:src="url" v-images-loaded:on.progress="imageProgress">
                                    </a>
                                </script>
                                <div class="col-12 col-lg-5">
                                    <h5 class="h5" ref="designDisplayName">{{ $designDisplay ? $designDisplay->name : 'Name of the design' }}</h5>
                                    <p class="small" ref="designDisplayCode">{{ $designDisplay ? $designDisplay->code : '#code' }}</p>
                                    <div class="design-image-list" ref="designDisplayImageList">
                                        @if ($designDisplay && $designDisplay->enabled_images->count() > 0)
                                            @foreach ($designDisplay->enabled_images as $image)
                                                <a class="pb-1 d-inline-block design-image cursor-pointer" v-on:click="selectImage('{{ route('system::image', [get_image_id($image->file_id, true)]) }}', $event)">
                                                    <img class="wh-85px image-loading" src="{{ route('system::image', [get_image_id($image->file_id, true)]) }}">
                                                </a>
                                            @endforeach
                                        @else
                                            <a class="pb-1 d-inline-block design-image cursor-pointer">
                                                <img class="wh-85px image-loading" src="{{ static_asset('images/black-box-modal.jpg') }}">
                                            </a>
                                        @endif
                                    </div>
                                    <hr class="long-gray mb-4 mt-4"/>
                                    <a href="{{ $designDisplay ? route('wizard::start', [$designDisplay->id]) : '#' }}" class="btn btn-primary text-xs" ref="designDisplayWizard">CUSTOMIZE THIS DESIGN ON A PRODUCT</a>
                                    <div class="mb-3 mt-3">
                                        <p class="text-xs">This design can be completely customized for your chapter! You can pick
                                            the product(s) you would like this design on, and let us know what you
                                            want changed </p>
                                    </div>
                                    <hr class="mt-4"/>
                                </div>
                            </div>
                            <script type="text/x-template" id="design-gallery-related-template">
                                <div class="carousel-inner" role="listbox">
                                    <div v-for="(chunk, index) in designChunks" class="carousel-item" :class="{'active': index == 0}">
                                        <div class="row">
                                            <div class="col-12 col-sm-3" v-for="design in chunk">
                                                <a v-bind:href="design.link">
                                                    <img class="w-100 mh-100px image-loading" v-bind:src="design.thumbnail" v-images-loaded:on.progress="imageProgress"/>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </script>
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="h3 mt-3 text-center">Similar designs you'll love</p>
                                </div>
                                <div class="col-sm-12">
                                    <div id="carousel-modal" class="carousel slide" data-ride="carousel" data-interval="3000" ref="designDisplayRelated">
                                        <div class="carousel-inner" role="listbox">
                                            @if ($designDisplay)
                                                @foreach ($designDisplay->getRelated()->chunk(4) as $chunk)
                                                    <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                                                        <div class="row">
                                                            @foreach ($chunk as $related)
                                                                <div class="col-12 col-sm-3">
                                                                    <a href="{{ route('home::design_gallery', [$related->id]) }}">
                                                                        <img class="w-100 mh-100px image-loading" src="{{ route('system::image', [get_image_id($related->getThumbnail(), true)]) }}"/>
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <a href="#carousel-modal" class="left carousel-control hidden-sm-down carousel-modal-left" role="button" data-slide="prev">
                                            <img class="carousel-arrow-both-modal carousel-arrow-modal-left" src="{{ static_asset('images/arrows-left.png') }}">
                                        </a>
                                        <a href="#carousel-modal" class="right carousel-control hidden-sm-down carousel-modal-right" role="button" data-slide="next">
                                            <img class="carousel-arrow-both-modal carousel-arrow-modal-right" src="{{ static_asset('images/arrows-right.png') }}">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section ('javascript')
    <script>
        var dataTags = {!! json_encode(array_merge([['id' => '', 'text' => '']], design_tag_repository()->getTagJSONList(['themes', 'chapter', 'general', 'themes', 'event']))) !!};
        var dataThemeEvents = {!! json_encode(array_merge([['id' => '', 'text' => '']], design_tag_repository()->getTagJSONList(['themes', 'event']))) !!};
        var dataChapters = {!! json_encode(array_merge([['id' => '', 'text' => '']], design_tag_repository()->getTagJSONList('chapter'))) !!};

        DesignGalleryTags.init(dataTags, dataThemeEvents, dataChapters);
        DesignGallery.setUrls('{{ route('system::design_gallery_recent') }}', '{{ route('system::design_gallery_related', ['ID']) }}', '{{ route('wizard::start', ['ID']) }}');

        function scrollDown() {
            $('html, body').animate({scrollTop: $('#carousel-row').offset().top}, 1000);
        }
    </script>
@append
