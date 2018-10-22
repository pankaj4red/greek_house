@if (!array_key_exists('hide_top_bar', View::getSections()))
    @include ('partials.navigation')
@else
    <div class="margin-bottom">&nbsp;</div>
@endif

@section ('include')
    <?php register_js(static_asset('js/jquery.mCustomScrollbar.concat.min.js')) ?>
    <?php register_css(static_asset('css/jquery.mCustomScrollbar.css')) ?>

@append

@section ('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".fancybox").click(function (event) {
                event.preventDefault();
                $.fancybox({
                    width: '400px',
                    height: 'auto',
                    autoSize: false,
                    href: $(this).attr('href'),
                    type: 'ajax',
                    scrolling: 'no',
                    wrapCSS: 'custom-login-register'
                });
                return false;
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            var width = $(window).width();
            if (width > 992) {
                $('#navbar-collapse-1').addClass('in');
                $('#navbar-collapse-1').attr('aria-expanded', 'true');
            }
        });
        $(window).resize(function () {
            var width = $(window).width();
            if (width > 992) {
                $('#navbar-collapse-1').addClass('in');
                $('#navbar-collapse-1').attr('aria-expanded', 'true');
            }
        });
    </script>
@append