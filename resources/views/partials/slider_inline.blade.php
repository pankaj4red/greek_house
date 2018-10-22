<div class="jcarousel-wrapper">
    <div class="jcarousel">
        <ul>
            @for ($i = 0; $i < count($images); $i++)
                <li><img src="{{ route('system::image', [$images[$i]->id]) }}" alt="{{ $images[$i]->name }}"/></li>
            @endfor
        </ul>
    </div>
    <p class="photo-credits">
        Uploaded Proofs
    </p>
    <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
    <a href="#" class="jcarousel-control-next">&rsaquo;</a>
    <p class="jcarousel-pagination"></p>
</div>

@section ('include')
    <?php register_css(static_asset('css/jcarousel.basic.css')) ?>
@append

@section ('javascript')
    <!--suppress JSCheckFunctionSignatures -->
    <script>
        jQuery.getScript('{{ static_asset('js/jquery.jcarousel.min.js') }}')
            .done(function() {
                var width = $('.jcarousel-wrapper').width();
                $('.jcarousel-wrapper img').each(function () {
                    $(this).attr('width', width + 'px');
                    $(this).attr('height', '380px');
                });
                $('.jcarousel').jcarousel();
                $('.jcarousel-wrapper li').each(function () {
                    $(this).css('width', width + 'px');
                    $(this).css('height', '380px');
                });
                $('.jcarousel-wrapper img').each(function () {
                    $(this).attr('width', 'auto');
                    $(this).attr('height', '380px');
                });
                $('.jcarousel-control-prev')
                        .on('jcarouselcontrol:active', function () {
                            $(this).removeClass('inactive');
                        })
                        .on('jcarouselcontrol:inactive', function () {
                            $(this).addClass('inactive');
                        })
                        .jcarouselControl({
                            target: '-=1'
                        });

                $('.jcarousel-control-next')
                        .on('jcarouselcontrol:active', function () {
                            $(this).removeClass('inactive');
                        })
                        .on('jcarouselcontrol:inactive', function () {
                            $(this).addClass('inactive');
                        })
                        .jcarouselControl({
                            target: '+=1'
                        });

                $('.jcarousel-pagination')
                        .on('jcarouselpagination:active', 'a', function () {
                            $(this).addClass('active');
                        })
                        .on('jcarouselpagination:inactive', 'a', function () {
                            $(this).removeClass('active');
                        })
                        .jcarouselPagination();
            }
        );
    </script>
@append
