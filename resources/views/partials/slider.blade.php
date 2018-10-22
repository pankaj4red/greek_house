<?php $sliderId = uniqid(); ?>
<div class="prod-slider">
    <div {!! !array_key_exists('slide', get_defined_vars()) || $slide == true ? 'data-ride="carousel"' : '' !!} class="carousel {{ !array_key_exists('slide', get_defined_vars()) || $slide == true ? 'slide' : '' }}" id="{{ $sliderId }}">
        <div class="carousel-inner">
            @for ($i = 0; $i < count($images); $i++)
                <div class="item {{ $i==0?'active':'' }}"><img src="{{ route('system::image', [get_image_id($images[$i]->id, $watermark)]) }}"
                                                               alt="{{ $images[$i]->name }}"></div>
            @endfor
        </div>
    </div>
    <div class="clearfix">
        <div data-interval="false" class="carousel {{ !array_key_exists('slide', get_defined_vars()) || $slide == true ? 'slide' : '' }} prod-thumb" id="thumb{{ $sliderId }}">
            <a data-slide="prev" role="button" href="#thumb{{ $sliderId }}" class="left carousel-control"><img
                        src="{{ static_asset('images/arrow-back.png') }}" alt="Prev"/></a>
            <div class="carousel-inner">
                <div class="item active">
                    @for ($i = 0; $i < count($images) && $i < 8; $i++)
                        <div class="thumb" data-slide-to="{{ $i }}" data-target="#{{ $sliderId }}"><img
                                    src="{{ route('system::image', [get_image_id($images[$i]->id,$watermark)]) }}" alt="{{ $images[$i]->name }}">
                        </div>
                    @endfor
                </div>
                @if (count($images) > 8)
                    <div class="item">
                        @for ($i = 8; $i < count($images); $i++)
                            <div class="thumb" data-slide-to="{{ $i }}" data-target="#{{ $sliderId }}"><img
                                        src="{{ route('system::image', [get_image_id($images[$i]->id, $watermark)]) }}"
                                        alt="{{ $images[$i]->name }}"></div>
                        @endfor
                    </div>
                @endif
            </div>
            <a data-slide="next" role="button" href="#thumb{{ $sliderId }}" class="right carousel-control"><img
                        src="{{ static_asset('images/arrow-fwd.png') }}" alt="Next"/></a>
        </div>
    </div>
    {!! $actionArea !!}
</div>

@section ('javascript')
    <script>
        $(window).load(function () {
            $('#{{ $sliderId }}').find('.carousel-inner img').load(function () {
                var height = 0;
                $('#{{ $sliderId }}').find('.carousel-inner img').each(function () {
                    if ($(this).height() > height) {
                        height = $(this).height();
                    }
                });
                if (height > 0) {
                    $('#{{ $sliderId }}').find('.carousel-inner').css('height', height + 'px');
                }
            });
        });
    </script>
@append