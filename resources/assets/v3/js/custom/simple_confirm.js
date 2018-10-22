
$('body').on('click', '*[data-confirm]', function(event) {
    var result = confirm($(this).attr('data-confirm'));
    if (result === false) {
        event.preventDefault();
        return false;
    }
});
