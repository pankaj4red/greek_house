function initCarousel(productCarousel) {
    var flag = false;
    var duration = 300;


    var $sync1 = productCarousel.find('.proofs__images');
    var $sync2 = productCarousel.find('.proofs__thumbs').find('.owl-carousel');

    $sync1
        .owlCarousel({
            items: 1,
            nav: true,
            animateOut: 'fadeOut',
            lazyLoad: true
        })
        .on('changed.owl.carousel', function (e) {
            if (!flag) {
                flag = true;
                $sync2.trigger('to.owl.carousel', [e.item.index, duration, true]);
                $sync2.find('.owl-item').removeClass('proof-active');
                $sync2.find('.owl-item').eq(e.item.index).addClass('proof-active');
                flag = false;
            }
        })
    ;

    $sync2
        .on('initialized.owl.carousel', function() {
            $sync2.find('.owl-item').eq(0).addClass('proof-active');
        })
        .owlCarousel({
            margin: 20,
            nav: false,
            autoWidth: true,
            items: 4
        })
        .on('click', '.owl-item', function () {
            $sync1.trigger('to.owl.carousel', [$(this).index(), duration, true]);

        })
        .on('changed.owl.carousel', function (e) {
            if (!flag) {
                flag = true;
                $sync1.trigger('to.owl.carousel', [e.item.index, duration, true]);
                flag = false;
            }
        })
    ;
}

var initProductCarousel = function(productCarousel) {
    return {
        init: function() {
            initCarousel(productCarousel);
        }
    }
};

var AppCampaign = function() {

    var initProductCarousels = function() {
        $( ".product-carousel" ).each(function() {
            var productCarousel = initProductCarousel($(this));
            productCarousel.init();
        });
    };

    var initColorChange = function() {
        $('.proof__color').on('click', function() {
            $('.proof__color').removeClass('active');
            //$(this).addClass('active');

            var product = $(this).data('product');
            var color = $(this).data('color');

            $('.product-color-' + product + '.' + color).addClass('active');

            $('.product-carousel').removeClass('active');
            $('.product-' + product + '-' + color).addClass('active');

        });
    };

    var initProductChange = function() {
        $('.proof__product').on('click', function() {
            $('.proof__product').removeClass('active');
            //$(this).addClass('active');

            var product = $(this).data('product');
            $('.product-' + product).addClass('active');

            $('.proof__colors').removeClass('active');
            $('.proof__color').removeClass('active');

            var colorsContainer = $('.product-colors-' + product);
            colorsContainer.addClass('active');
            colorsContainer.find('.proof__color').eq(0).trigger('click');

        });
    };

    //purchase page proof section - arrows to change product/color
    var initPurchaseCarousel = function() {

    };

    var purchaseCarouselNav = function(direction) {

    };

    //upload design pop up - show/hide location when click on checkbox
    var initLocationsToggler = function() {
        $('.js-toggle-location').click(function() {
            var location = $(this).data('location');
            $('#' + location + 'Location').toggle();

            if ($('.js-toggle-location:checked').length == 0) {
                $('.design__locations').hide();
            } else {
                $('.design__locations').show();
            }

        });
    };

    //upload design pop up - delete color
    var initDeleteColor = function() {
        $('.js-delete-color').click(function() {
            $(this).closest('.location__color').remove();
        });
    };

    return {
        init: function () {
            initProductCarousels();
            initColorChange();
            initProductChange();
            initPurchaseCarousel();
            initLocationsToggler();
            initDeleteColor();
        }
    };

}();

$(document).ready(function () {
    AppCampaign.init();
});
