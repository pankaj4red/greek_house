var GHBlockExpand = {
    init: function () {
        $(document).on('click', '.block-toggle', function() {
            $(this).closest('.block-info-rounded').find('.block-info__body').slideToggle();
            $(this).toggleClass('closed');
        });
    }
};

GHBlockExpand.init();
window.GHBlockExpand = GHBlockExpand;


