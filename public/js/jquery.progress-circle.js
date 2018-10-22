
(function ($) {
    $.fn.circlebar = function () {
        var DEFAULTS = {
            backgroundColor: '#b3cef6',
            progressColor: '#4b86db',
            percent: 75
        };
        $(this).each(function () {
            var $target = $(this);

            var opts = {
                backgroundColor: $target.data('color') ? $target.data('color').split(',')[0] : DEFAULTS.backgroundColor,
                progressColor: $target.data('color') ? $target.data('color').split(',')[1] : DEFAULTS.progressColor,
                percent: $(this).attr('data-percent') ? $(this).attr('data-percent') : DEFAULTS.percent
            };

            $target.html('');
            $target.append('<div class="background"></div><div class="rotate"></div><div class="left"></div><div class="right"></div><div class=""><span><i>' + $(this).attr('data-text') + '</i></span></div>');
            $target.find('.background').css('background-color', opts.backgroundColor);
            $target.find('.left').css('background-color', opts.backgroundColor).css('clip', 'rect(0px, 32px, 64px, 0px)');
            $target.find('.right').css('background-color', opts.progressColor).css('clip', 'rect(0px, 64px, 64px, 32px)');
            $target.find('.rotate').css('background-color', opts.progressColor);

            if (opts.percent > 100) {
                opts.percent = 100;
            }
            var angle = opts.percent * 3.6;
            var $rotate = $target.find('.rotate');
            $rotate.css({
                'transform': 'rotate(' + (180 + angle) + 'deg)',
                'clip': 'rect(0px, 64px, 64px, 32px)'
            });

            if (angle < 180) {
                $(this).find('.left').show();
                $(this).find('.right').hide();
            } else {
                $(this).find('.left').hide();
                $(this).find('.right').show();
            }
        });
    }
})(jQuery);