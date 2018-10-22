
function imageLoadingEvent(element) {
    if ($(element).hasClass('image-loading')) {
        $(element).on('load', function () {
            $(this).removeClass('image-loading');
        });
    }
}

window.imageLoadingEvent = imageLoadingEvent;

$(document).ready(function () {
    $('.image-loading').on('load', function () {
        $(this).removeClass('image-loading');
    });
});
