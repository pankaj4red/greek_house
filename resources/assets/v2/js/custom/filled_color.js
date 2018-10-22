var GHFilledColor = {
    init: function () {
        $('.color-filled').keyup(this.change);
        $('.color-filled').change(this.change);
        $('.color-filled').each(function () {
            $(this).attr('data-color-filled-original', $(this).css('background-color'));
            GHFilledColor.update($(this));
        });
    },
    change: function () {
        GHFilledColor.update($(this));
    },
    update: function (element) {
        if (element.val()) {
            element.css('background-color', element.attr('data-color-filled'));
        } else {
            element.css(element.attr('data-color-filled-original'));
        }
    }
};

GHFilledColor.init();
window.GHFilledColor = GHFilledColor;

