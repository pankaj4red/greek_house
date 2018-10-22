// $('body').on('click', '*[data-toggle-display]', function (event) {
//     event.preventDefault();
//     $($(this).attr('data-toggle-display')).toggle();
//
//     return false;
// });

$('body').on('change', '*[data-toggle-display]', function (event) {
    event.preventDefault();
    if ($(this).prop('checked')) {
        $($(this).attr('data-toggle-display')).show();
    } else {
        $($(this).attr('data-toggle-display')).hide();
    }

    return false;
});

