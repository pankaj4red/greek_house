window.GreekHouseAutoComplete = {
    init: function (element, url) {
        if (element.attr('data-auto-selected')) {
            element.autocomplete({
                source: url,
                minLength: 1,
                delay: 200,
                select: function(event, ui) {
                    setTimeout(function() {
                        element.val(ui.item.value);
                        var e = $.Event( "keydown", { which: 13 } );
                        element.trigger(e);
                    }, 0);
                    event.preventDefault();
                    return false;
                }
            });

            return;
        }

        element.autocomplete({
            source: url,
            minLength: 1,
            delay: 200,
        });
    },
};
