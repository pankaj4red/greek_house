var AppStore = function() {

    //landing page: chapters tabs
    var initChaptersTabs  = function () {
        $('#chaptersTabs').on('shown.bs.tab', function (e) {
            $('li.nav-item').removeClass('active');
            $(e.target).closest('li.nav-item').addClass('active');
        })
    };

    //products page: search select
    var initProductsSearch  = function () {
        $('#products-search').select2({
            //placeholder: 'Filter By Categories/Collections'
            width: 'resolve'
        });
    };

    //products page: price range slider
    var initProductsPriceRange  = function () {

        var priceSlider = $("#slider-range");
        priceSlider.slider({
            range: true,
            min: 0,
            max: 120,
            values: [ 0, 80 ],
            slide: function( event, ui ) {
                $(ui.handle).text("$" + ui.values[ui.handleIndex]);
            },
            change: function( event, ui ) {

                //send ajax to get products filtered by price range
                priceSlider.slider( "disable" );
                var productsContainer = $('#filter-products');
                productsContainer.showLoading();
                setTimeout(function() {

                    $.ajax({
                        url: '/store/products/filter',
                        type: 'POST',
                        data: { filter: "price", min: ui.values[0], max: ui.values[1] },
                        dataType: 'json',
                        complete: function(data) {
                            if (data.responseJSON.products) {
                                productsContainer.html(data.responseJSON.products);
                            }
                            productsContainer.hideLoading();
                            priceSlider.slider( "enable" );
                        }
                    });
                }, 1000);
            },
            create: function() {
                //initialize handlers with starting values
                priceSlider.find('.ui-slider-handle').eq(0).text("$" + priceSlider.slider( "values",0));
                priceSlider.find('.ui-slider-handle').eq(1).text("$" + priceSlider.slider( "values",1));
            }
        });
    };

    //individual product page: add qty and size row
    var initProductAddRow = function() {
        $('#add-product-row').on('click', function() {
            $.ajax({
                url: '/store/products/add-product-row',
                type: 'GET',
                data: { product_id: 1},
                dataType: 'json',
                complete: function(data) {
                    if (data.responseJSON.productRow) {
                        $('#product-qty').find('tbody').append(data.responseJSON.productRow);
                    }
                }
            });
        });
    };

    //individual product page: remove qty and size row
    var initProductDeleteRow = function() {
        $(document).on('click', '.product__remove', function() {
            $(this).closest('tr').remove();
        });
    };

    //individual product page: countdown order
    var initCountDown = function() {
        if ($('#product-countdown').length) {
            var deadline = new Date(Date.parse(new Date()) + 1.5 * 24 * 60 * 60 * 1000);
            initializeClock('product-countdown', deadline);
        }
    };

    //private functions for countdown
    var getTimeRemaining = function(endtime) {
        var t = Date.parse(endtime) - Date.parse(new Date());
        var seconds = Math.floor((t / 1000) % 60);
        var minutes = Math.floor((t / 1000 / 60) % 60);
        var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        return {
            'total': t,
            'days': days,
            'hours': hours,
            'minutes': minutes,
            'seconds': seconds
        };
    };

    var initializeClock = function(id, endtime) {
        var clock = document.getElementById(id);
        var daysSpan = clock.querySelector('.days');
        var hoursSpan = clock.querySelector('.hours');
        var minutesSpan = clock.querySelector('.minutes');
        var secondsSpan = clock.querySelector('.seconds');

        function updateClock() {
            var t = getTimeRemaining(endtime);

            daysSpan.innerHTML = ('0' + t.days).slice(-2);
            hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
            minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
            secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

            if (t.total <= 0) {
                clearInterval(timeinterval);
            }
        }

        updateClock();
        var timeinterval = setInterval(updateClock, 1000);
    };

    return {
        init: function () {
            initChaptersTabs();
            initProductsSearch();
            initProductsPriceRange();
            initProductAddRow();
            initProductDeleteRow();
            initCountDown();
        }
    };

}();



$(document).ready(function () {
    AppStore.init();
});