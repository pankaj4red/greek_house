
function initCarousel(productCarousel) {
    var flag = false;
    var duration = 300;

    var $sync1 = productCarousel.find('.proofs-images');
    var $sync2 = productCarousel.find('.proofs-thumbs').find('.owl-carousel');

    $sync1.owlCarousel({
        items: 1,
        nav: true,
        animateOut: 'fadeOut',
        lazyLoad: true
    }).on('changed.owl.carousel', function (e) {
        if (!flag) {
            flag = true;
            $sync2.trigger('to.owl.carousel', [e.item.index, duration, true]);
            $sync2.find('.owl-item').removeClass('proof-active');
            $sync2.find('.owl-item').eq(e.item.index).addClass('proof-active');
            flag = false;
        }
    });

    $sync2.on('initialized.owl.carousel', function () {
        $sync2.find('.owl-item').eq(0).addClass('proof-active');
    }).owlCarousel({
        margin: 20,
        nav: false,
        autoWidth: true,
        items: 4
    }).on('click', '.owl-item', function () {
        $sync1.trigger('to.owl.carousel', [$(this).index(), duration, true]);
    }).on('changed.owl.carousel', function (e) {
        if (!flag) {
            flag = true;
            $sync1.trigger('to.owl.carousel', [e.item.index, duration, true]);
            flag = false;
        }
    });
}

var initProductCarousel = function initProductCarousel(productCarousel) {
    return {
        init: function init() {
            initCarousel(productCarousel);
        }
    };
};

var AppCampaign = function () {

    //hide/show section if click on arrow next to block title
    var initToggler = function initToggler() {
        $(document).on('click', '.js-toggle', function () {
            var $this = $(this);
            $this.closest('.block-info-rounded').find('.block-info__body').slideToggle();
            $this.toggleClass('closed');
        });
    };

    var initProductCarousels = function initProductCarousels() {
        $(".product-carousel").each(function () {
            var productCarousel = initProductCarousel($(this));
            productCarousel.init();
        });
    };

    var initColorChange = function initColorChange() {
        $('.proof__color').on('click', function () {
            $('.proof__color').removeClass('active');
            //$(this).addClass('active');

            var product = $(this).data('product');
            var color = $(this).data('color');

            $('.product-color-' + product + '.' + color).addClass('active');

            $('.product-carousel').removeClass('active');
            $('.product-' + product + '-' + color).addClass('active');
        });
    };

    var initProductChange = function initProductChange() {
        $('.proof__product').on('click', function () {
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
    var initPurchaseCarousel = function initPurchaseCarousel() {
        $('#purchaseCarouselNext').click(function () {
            purchaseCarouselNav('next');
        });
        $('#purchaseCarouselPrev').click(function () {
            purchaseCarouselNav('prev');
        });
    };

    var purchaseCarouselNav = function purchaseCarouselNav(direction) {
        var nextIndex;
        var carouselContainer = $('#purchaseCarousel');
        var totalItems = carouselContainer.find('.product-carousel').length;
        var activeIndex = carouselContainer.find('.product-carousel.active').index();

        if (direction == 'next') {
            nextIndex = activeIndex + 1;
            if (nextIndex >= totalItems) nextIndex = 0;
        } else if (direction == 'prev') {
            if (activeIndex == 0) nextIndex = totalItems - 1;else nextIndex = activeIndex - 1;
        }

        carouselContainer.find('.product-carousel').removeClass('active');
        carouselContainer.find('.product-carousel').eq(nextIndex).addClass('active');
    };

    //upload design pop up - show/hide location when click on checkbox
    var initLocationsToggler = function initLocationsToggler() {
        $('.js-toggle-location').click(function () {
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
    var initDeleteColor = function initDeleteColor() {
        $('.js-delete-color').click(function () {
            $(this).closest('.location__color').remove();
        });
    };

    return {
        init: function init() {
            initToggler();
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

window.AppCampaign = AppCampaign;
