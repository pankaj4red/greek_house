var GHScroll = {
    scroll: function (selector) {
        $('html, body').animate({
            scrollTop: $(selector).offset().top
        }, 200);
    }
};

window.GHScroll = GHScroll;
