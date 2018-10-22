var GHPlaceholder = {
    init: function () {
        GHPlaceholder.updateAll();
        $('select.select-placeholder').on('change', GHPlaceholder.event);
    },
    updateAll: function () {
        $('select.select-placeholder').each(function () {
            GHPlaceholder.updateOne($(this));
        });
    },
    updateOne: function (select) {
        if (select.val()) {
            return select.css('font-weight', select.attr('data-selected'));
        } else {
            return select.css('font-weight', select.attr('data-placeholder'));
        }
    },
    event: function () {
        GHPlaceholder.updateOne($(this));
    }
};

GHPlaceholder.init();
window.GHPlaceholder = GHPlaceholder;
