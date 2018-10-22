let GreekHouseModal = {
    init: function () {
        $("#gh-modal").on("show.bs.modal", function (e) {
            $(this).find('.modal-ajax-content').html('<img class="modal-loading" src="/images/download.gif"/>');

            let link = $(e.relatedTarget);

            let width = "600px";
            let height = "400px";

            if (link.attr('data-modal-width')) {
                width = link.attr('data-modal-width');
            }
            if (link.attr('data-modal-height')) {
                height = link.attr('data-modal-height');
            }

            $("#gh-modal").find('.modal-dialog').css({'min-width': width, 'min-height': height});
            $(this).find('.modal-ajax-content img').css({top: GreekHouseModal.sizeHalf(height, -15), left: GreekHouseModal.sizeHalf(width, -15)});

            $(this).find(".modal-ajax-content").load(link.attr("href"));
        });
    },
    sizeHalf: function (size, offset = 0) {
        if (size.endsWith('px')) {
            return (Math.round(parseInt(size) / 2) + offset) + 'px';
        }

        return size / 2;
    }
};

GreekHouseModal.init();
