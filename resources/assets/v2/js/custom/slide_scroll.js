var GHSlideScroll = {
    init: function () {
        $('.slide-scroll').on('click', GHSlideScroll.event);
    },
    event: function (event) {
        $('html, body').animate({
            scrollTop: $($(this).attr('data-slide-scroll')).offset().top
        }, 500);
        if ($(this).attr('data-slide-focus')) {
            $($(this).attr('data-slide-focus')).focus();
        }
        event.preventDefault();
        return false;
    }
};

GHSlideScroll.init();
window.GHSlideScroll = GHSlideScroll;
