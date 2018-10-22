var AppGallery = function() {

    var initProductGallery = function() {
        $(document).on('click', '.image__thumb', function() {
            var $this = $(this);
            $this.closest('.product__image-gallery').find('.image__main .main__bg').css('background-image', "url('" + $this.data('image') + "')");
        });
    };

    var initChangeColorImages = function() {
        $(document).on('click', '.product__color', function() {
            var $this = $(this);
            $('.product__image-gallery').removeClass('active');
            $('.product__image-gallery.' + $this.data('color')).addClass('active');

            $('.product__color').removeClass('active');
            $this.addClass('active');

        });
    };

    return {
        init: function () {
            initProductGallery();
            initChangeColorImages();
        }
    };

}();

$(document).ready(function () {
    AppGallery.init();
});