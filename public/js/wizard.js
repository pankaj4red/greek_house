var GreekHouse = {
        wizardPage: {
            PRODUCTS_ENDPOINT: '/wizard/ajax/products',
            MAX_PRODUCTS_COUNT: 4,
            DATA_SUBMIT_ENDPOINT: '',

            enabledTabs: {
                tab1: true,
                tab2: false,
                tab3: false,
                tab4: false,
                tab5: false,
            },

            products: [],
            types: {},

            printType: null,
            totalEstimatedQuantity: null,

            print: {
                front: {
                    selected: false,
                    desc: null,
                    colors: 1,
                },
                back: {
                    selected: false,
                    desc: null,
                    colors: 1,
                },
                sleeve: {
                    selected: false,
                    desc: null,
                    colors: 1,
                },
                pocket: {
                    selected: false,
                    desc: null,
                    colors: 1,
                },
            },
            original_product_id: 1,
            original_color_id: 1,
            color: '',
            color_id: null,
            product: '',
            product_type: '',
            img: null,
            name: null,
            style: null,
            type: null,
            campaignName: null,
            description: '',
            size: '',
            pricing: '',
            additionalColors: [],

            delivery: {
                name: null,
                addressLine1: null,
                addressLine2: null,
                city: null,
                state: null,
                zipCode: null,
                orderDeliveryTimeframe: '10_business_days',
                orderDeliveryDate: null,
                orderDeliveryAcceptFees: null,
            },

            setColor: function (id, color) {
                GreekHouse.wizardPage.color_id = id;
                GreekHouse.wizardPage.color = color;
            },
            getColor: function (color) {
                return GreekHouse.wizardPage.color
            },

            tab1: {
                modal: {
                    element: $('#modalLargeProducts'),
                    title: $('#modalLargeProducts').find('#productsModalLargeTitle'),
                    titleColor: $('#modalLargeProducts').find('#productModalLargeTitleColor'),
                    titleStyle: $('#modalLargeProducts').find('#productModalLargeTitleStyle'),
                    img: $('#modalLargeProducts img.design-preview-image'),
                    description: $('#modalLargeProducts p.product-desc-p'),
                    pricing: $('#modalLargeProducts p.pricing-range-p'),
                    size: $('#modalLargeProducts p.size-range-p'),
                    colors: $('#modalLargeProducts ul#product-color-list')
                }
            },

            util: {
                showLoading: function () {
                    $('#loading').removeClass('hide');
                    $('#section4x4').addClass('hide');
                },
                hideLoading: function () {
                    setTimeout(function () {
                        $('#loading').addClass('hide');
                        $('#section4x4').removeClass('hide');
                        $('body').delay(10).animate({
                            scrollTop: $('#gender-section').offset().top
                        }, 1000);
                    }, 1000);
                },
                fetchData: function ($category = '', $query = '') {
                    $compiledRequestUri = GreekHouse.wizardPage.PRODUCTS_ENDPOINT;
                    $.ajaxSetup({
                        beforeSend: function (xhr) {
                            if (xhr.overrideMimeType) {
                                xhr.overrideMimeType("application/json");
                            }
                        },
                        async: false
                    });

                        $categoryUriComponent = 'category=' + $category;

                    $queryUriComponent = 'query=' + $query;

                    if ($category && !$query) {
                        $compiledRequestUri += '?' + $categoryUriComponent;
                    } else if ($query && !$category) {
                        $compiledRequestUri += '?' + $queryUriComponent;
                    } else {
                        $compiledRequestUri += '?' + $categoryUriComponent + '&' + $queryUriComponent;
                    }

                    var result = {"foo": "bar"};
                    $.getJSON($compiledRequestUri, function (data) {
                        result = data;
                    });

                    return result.data;
                }
            },

            openModal: function (element) {
                GreekHouse.wizardPage.name = element.attr('data-name');
                GreekHouse.wizardPage.img = element.attr('data-img');
                GreekHouse.wizardPage.style = element.attr('data-style');
                GreekHouse.wizardPage.type = element.attr('data-type');
                GreekHouse.wizardPage.size = element.attr('data-size');
                GreekHouse.wizardPage.description = element.attr('data-description');
                GreekHouse.wizardPage.tab1.modal.title.text(GreekHouse.wizardPage.name);
                GreekHouse.wizardPage.tab1.modal.titleColor.text('');
                GreekHouse.wizardPage.tab1.modal.titleStyle.text(element.attr('data-style'));
                GreekHouse.wizardPage.tab1.modal.img.attr('src', GreekHouse.wizardPage.img);
                GreekHouse.wizardPage.tab1.modal.description.text(GreekHouse.wizardPage.description);
                GreekHouse.wizardPage.tab1.modal.pricing.text(GreekHouse.wizardPage.pricing);
                GreekHouse.wizardPage.tab1.modal.size.text(GreekHouse.wizardPage.size);
                GreekHouse.wizardPage.tab1.modal.colors.html('');
                var colors = JSON.parse(element.attr('data-colors'));
                var entry;
                for (var i = 0; i < colors.length; i++) {
                    entry = $('<a href="#" class="color-picker-modal-anchor" data-toggle="tooltip" data-placement="top" title=""><li class="inline-color-picker-modal"></li></a>');
                    entry.attr('title', colors[i].name);
                    entry.find('li').css('background-image', 'url(' + colors[i].thumbnail + ')');
                    entry.attr('data-image', colors[i].image);
                    entry.attr('data-id', colors[i].id);
                    entry.attr('data-colors', colors[i].colors);
                    GreekHouse.wizardPage.tab1.modal.colors.append(entry);

                    if (GreekHouse.wizardPage.original_color_id == colors[i].id) {
                        entry.trigger('click');
                    }
                }
                GreekHouse.wizardPage.tab1.modal.element.modal('show');
                history.pushState('data', '', '/wizard/product/' + element.attr('data-id'));
            },

            updateReviewPrintLocations:

                function () {
                    var locations = [];
                    if (GreekHouse.wizardPage.print.front.selected) locations.push('Front');
                    if (GreekHouse.wizardPage.print.back.selected) locations.push('Back');
                    if (GreekHouse.wizardPage.print.pocket.selected) locations.push('Pocket');
                    if (GreekHouse.wizardPage.print.sleeve.selected) locations.push('Sleeve');
                    console.log(locations);

                    $('#review_print_locations').text(locations.join(', '));
                }

            ,

            filterProductsByGender: function (gender) {
                $productAnchors = $('.product-item-anchor');

                if (!gender) {
                    $productAnchors.parent().parent().show();
                    return;
                }

                $productAnchors.each(function () {
                    productGender = $(this).attr('data-gender');
                    if (gender == 'u') {
                        $(this).parent().parent().show();
                    } else {
                        if (productGender == 'u' || productGender == gender) {
                            $(this).parent().parent().show();
                        } else {
                            $(this).parent().parent().hide();
                        }
                    }
                });
            }
            ,

            renderProductList: function (products) {
                $list = $('#product_list');
                //$list.empty();
                $("#product_list > *").remove();

                $.each(products, function (productKey, product) {
                    GreekHouse.wizardPage.renderProduct(productKey, product);
                });
                GreekHouse.wizardPage.updateProductTree();
            }
            ,

            renderProduct: function (productKey, product) {
                $product = $('<div class="cart_product"> \
										<div class="row row-position"> \
											<div class="col-md-3 col-sm-3"> \
												<img class="img img-responsive img-thumbnail" src="" alt="..."> \
											</div> \
											<div class="col-md-7 col-sm-7"> \
												<h4 class="media-heading step3_product_title"></h4> \
											</div> \
											<div class="col-md-2 col-sm-2 edit_options"> \
												<!--<a href="#" class="edit_product_btn"><i class="fa fa-pencil"></i></a>--> \
												<a href="#" class="remove_product_btn trash-product"><i class="fa fa-trash"></i></a> \
											</div> \
										</div> \
										<div class="row"> \
											<div class="col-md-12"> \
												<div class="colorboxes"> \
													<a href="#" data-slot="1" class="color_slot color_slot_1 color_box btn-baseColor"><span class="fa fa-trash"></span></a>  \
													<a href="#" data-slot="2" class="color_slot color_slot_2 color_box btn-baseColor"><span class="fa fa-trash"></span></a>  \
													<a href="#" data-slot="3" class="color_slot color_slot_3 color_box btn-baseColor"><span class="fa fa-trash"></span></a>  \
													<a href="#" data-slot="4" class="color_slot color_slot_4 color_box btn-baseColor"><span class="fa fa-trash"></span></a>  \
													<a href="#" class="color_box colorpicker dropdown-toggle btn-baseColor" data-toggle="dropdown" aria-expanded="false">&nbsp;</a> \
													<ul class="colorpicker_popup colors-available dropdown-menu" role="menu" aria-labelledby="color_1" > \
													</ul> \
												</div> \
											</div> \
										</div> \
									</div>');
                $product.attr('data-key', productKey);
                $product.attr('data-id', product.id);
                $product.attr('data-style', product.style);
                $product.find('img.img-thumbnail').attr('src', product.img);
                $product.find('h4.step3_product_title').text(product.name);
                for (var key in product.colors) {
                    var colorEntry = $('<li class="color thumbnail" style="color: black"></li>');
                    colorEntry.attr('data-id', product.colors[key].id);
                    colorEntry.attr('title', product.colors[key].name);
                    colorEntry.attr('data-thumbnail', product.colors[key].image);
                    colorEntry.attr('style', "color:black; background-image: url(" + product.colors[key].image + ")");
                    $product.find('.colors-available').append(colorEntry);
                }
                $('#product_list').append($product);
                $.each(product.additionalColors, function (i, color) {
                    var slot = i + 1;
                    $('.cart_product[data-key="' + productKey + '"] .color_slot_' + slot.toString()).css('background-image', 'url(' + color.image + ')');
                    $('.cart_product[data-key="' + productKey + '"] .color_slot_' + slot.toString()).addClass('active');
                });
                if ($('#product_list > .cart_product').length < 2) {
                    $('#product_list .trash-product').hide();
                } else {
                    $('#product_list .trash-product').show();
                }
            }
            ,

            populateProducts: function (products) {
                $('#products').empty();
                $.each(products, function (i, product) {
                    $option = $('<option />');
                    $option.val(product.name).text(product.name);
                    $option.attr('data-id', product.id);
                    $option.attr('data-img', product.img);
                    $('#products').append($option);
                });

            }
            ,

            resetProducts: function () {
                $('#products').empty();
                $('#style option[value=""]').prop('selected', true);
            }
            ,

            addProduct: function (newProduct, render) {
                if (GreekHouse.wizardPage.products.length >= GreekHouse.wizardPage.MAX_PRODUCTS_COUNT) {
                    sweetAlert('Cannot add more!', 'You cannot add more products!', "warning");
                    return;
                }

                if (GreekHouse.wizardPage.isAlreadyAddedProduct(newProduct)) {
                    console.error('Duplicate!');
                    alert('Duplicate!');
                    return;
                }

                GreekHouse.wizardPage.products.push(newProduct);
                if (render) {
                    GreekHouse.wizardPage.renderProduct(GreekHouse.wizardPage.products.length - 1, newProduct);
                    $('#add_new_product_control').hide('fast');
                    GreekHouse.wizardPage.updateAddNewProductBox();
                    GreekHouse.wizardPage.updateAddProductColors();
                }
            }
            ,

            addColor: function (productKey, color, render) {
                for (var key in GreekHouse.wizardPage.products[productKey].additionalColors) {
                    if (GreekHouse.wizardPage.products[productKey].additionalColors[key].id == color.id) {
                        sweetAlert("Picking a color", "This color is already picked!", "warning");
                        return false;
                    }
                }

                var count = 0;
                for (var productKey in GreekHouse.wizardPage.products) {
                    for (var key in GreekHouse.wizardPage.products[productKey].additionalColors) {
                        count++;
                    }
                }

                if (count >= 4) {
                    sweetAlert("Picking a color", "You have reached the 4 color limit!", "warning");
                    return false;
                }

                GreekHouse.wizardPage.products[productKey].additionalColors.push(color);
                GreekHouse.wizardPage.updateProductTree();

                if (render) {
                    $.each(GreekHouse.wizardPage.products[productKey].additionalColors, function (i, color) {
                        var slot = i + 1;
                        $('.cart_product[data-key="' + productKey + '"] .color_slot_' + slot.toString()).attr('title', color.name);
                        $('.cart_product[data-key="' + productKey + '"] .color_slot_' + slot.toString()).css('background-image', 'url(' + color.image + ')');
                        $('.cart_product[data-key="' + productKey + '"] .color_slot_' + slot.toString()).addClass('active');
                    });
                    GreekHouse.wizardPage.updateAddProductColors();
                }
            },

            updateProductTree: function () {
                $('#product_color_tree').val(JSON.stringify(GreekHouse.wizardPage.getProductColorTree()));
            },

            getProductColorTree: function () {
                var products = {};
                for (var productKey in GreekHouse.wizardPage.products) {
                    var colors = [];
                    for (var key in GreekHouse.wizardPage.products[productKey].additionalColors) {
                        colors.push(GreekHouse.wizardPage.products[productKey].additionalColors[key].id);
                    }
                    products[GreekHouse.wizardPage.products[productKey].id] = colors;
                }

                return products;
            },

            deleteProduct: function (key) {
                GreekHouse.wizardPage.products.splice(key, 1);
                GreekHouse.wizardPage.updateAddNewProductBox();
                GreekHouse.wizardPage.updateAddProductColors();
            },

            updateAddNewProductBox: function () {
                $addNewProductsBox = $('#add_new_product_box');
                if (GreekHouse.wizardPage.products.length >= GreekHouse.wizardPage.MAX_PRODUCTS_COUNT) {
                    $addNewProductsBox.hide();
                    $('.color_box.dropdown-toggle').hide();
                } else {
                    $addNewProductsBox.show();
                    $('.color_box.dropdown-toggle').show();
                }
            },

            updateAddProductColors: function () {
                var count = 0;
                for (var productKey in GreekHouse.wizardPage.products) {
                    for (var key in GreekHouse.wizardPage.products[productKey].additionalColors) {
                        count++;
                    }
                }

                if (count >= 4) {
                    $('#add_new_product_box').hide();
                    $('.color_box.dropdown-toggle').hide();
                } else {
                    $('#add_new_product_box').show();
                    $('.color_box.dropdown-toggle').show();
                }
            },

            isAlreadyAddedProduct: function (newProduct) {
                $.each(GreekHouse.wizardPage.products, function (i, product) {
                    if (product.id == newProduct.id) {
                        return true;
                    }

                });

                return false;
            }
            ,

            initProduct: function () {
                //GreekHouse.wizardPage.img = $('#modalLargeProducts img.design-preview-image').attr('src');
                // etc...
            }
            ,

            tab1ShowErrors: function () {
                var errorMessage = "<strong>Oh snap!</strong> In order to proceed, please select a product!";

                $(".tab-1-error-message")
                    .html(errorMessage)
                    //.show('fast');
                    .fadeTo(2000, 500)
                    .slideUp(500, function () {
                        $(".tab-1-error-message").slideUp(500);
                    });
                console.log('done showing alert');
            }
            ,

            validateForTab2: function () {
                wp = GreekHouse.wizardPage;
                if (!wp.color || !wp.img || !wp.name || !wp.style || !wp.type)
                    return false;
                else
                    return true;
            }
            ,

            validateForTab3: function () {

            }
            ,

            initTab2: function () {
                console.log('Init tab 2');
                GreekHouse.wizardPage.campaignName = $('#campaign-name').val();
                $('img.tab2-img-display').attr('src', GreekHouse.wizardPage.img);
                // validate other stuff

                if (!GreekHouse.wizardPage.validateForTab2()) {
                    // show error message
                    GreekHouse.wizardPage.tab1ShowErrors();
                    GreekHouse.wizardPage.toStep1();
                }

                $('a[href="#tabTwo"]').tab('show');
            }
            ,

            initTab3: function () {
                console.log('Init tab 3');

                $mainProduct = $('#product_1');
                $mainProduct.find('h4').text(GreekHouse.wizardPage.name);
                $mainProduct.find('img.img-thumbnail').attr('src', GreekHouse.wizardPage.img);

                $reviewMainProduct = $('#product-one-fifth-step');
                $reviewMainProduct.find('h4').text(GreekHouse.wizardPage.name);
                $reviewMainProduct.find('img.img-thumbnail').attr('src', GreekHouse.wizardPage.img);

                $('a[href="#tabThree"]').tab('show');
            }
            ,

            initTab4: function () {
                console.log('Init tab 4');

                $('a[href="#tabFour"]').tab('show');
            }
            ,

            initTab5: function () {
                console.log('Init tab 5');
                $('h2.product-name-big').text(GreekHouse.wizardPage.campaignName);


                $('a[href="#tabFive"]').tab('show');
            }
            ,

            toStep1: function () {
                $('a[href="#tabOne"]').tab('show');
            }
            ,

            toStep2: function (e) {
                if (!GreekHouse.wizardPage.color) {
                    sweetAlert("Pick a color", "Please choose a color to continue!", "warning");
                    e.preventDefault();
                    return false;
                }
                $('#wizard_color_id').val(GreekHouse.wizardPage.color_id);
                GreekHouse.wizardPage.tab1.modal.element.modal('hide');
            }
            ,

            toStep3: function (e) {
                if (!$('#campaign-name').val()) {
                    sweetAlert("Name Your Campaign", "Please give a name to your campaign!", "warning");
                    e.preventDefault();
                    return false;
                }

                if (!$('#print_location_front').prop('checked') && !$('#print_location_pocket').prop('checked') && !$('#print_location_back').prop('checked') && !$('#print_location_sleeve').prop('checked')) {
                    sweetAlert("Select a design area", "Please select a design area for your garment!", "warning");
                    e.preventDefault();
                    return false;
                }
            }
            ,

            toStep4: function (e) {
                if (!$('#design_type').val()) {
                    sweetAlert("Print Type", "Please select print type!", "warning");
                    e.preventDefault();
                    return false;
                }

                if (!$('#estimated_quantity').val()) {
                    sweetAlert("Total Est. Quantity", "Please select total estimated quantity!", "warning");
                    e.preventDefault();
                    return false;
                }
            }
            ,

            toStep5: function () {
                // validate stuff on tab 4
                //
                // $('a[href="#tabFive"]').attr('data-toggle', 'tab');
                // GreekHouse.wizardPage.initTab5();
            },

            dateFieldsVisibility: function () {
                var weekday12 = null;
                var weekday15 = null;

                var currentDate = new Date();
                var count = 0;
                while (count < 15) {
                    currentDate.setDate(currentDate.getDate() + 1);
                    if (currentDate.getDay() != 0 && currentDate.getDay() != 6) {
                        count++;
                    }
                    if (count == 12) {
                        weekday12 = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1 + "").lpad("0", 2) + '-' + ('' + currentDate.getDate()).lpad("0", 2);
                    }
                    if (count == 15) {
                        weekday15 = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1 + "").lpad("0", 2) + '-' + ('' + currentDate.getDate()).lpad("0", 2);
                    }
                }

                var eDate = new Date($('#delivery-date').val());
                var date = eDate.getFullYear() + '-' + (eDate.getMonth() + 1 + "").lpad("0", 2) + '-' + ('' + eDate.getDate()).lpad("0", 2);

                var dateObject = new Date(date);
                GreekHouse.wizardPage.delivery.orderDeliveryDate = date;
                console.log(GreekHouse.wizardPage.delivery.orderDeliveryDate);
                if (date < weekday12) {
                    // show minimum time
                    $('#weekday_required').hide();
                    $('#minimum_time').show();
                    $('#extra_fee').hide();
                    $('#toStep5container').hide();

                } else if (dateObject.getDay() == 0 || dateObject.getDay() == 6) {
                    $('#weekday_required').show();
                    $('#minimum_time').hide();
                    $('#extra_fee').hide();
                    $('#toStep5container').hide();
                    return;
                } else if (date < weekday15) {
                    // show fees picker
                    $('#rush option:selected').removeAttr('selected');
                    $('#weekday_required').hide();
                    $('#minimum_time').hide();
                    $('#extra_fee').show();
                    $('#toStep5container').hide();

                } else {
                    // show next btn
                    $('#weekday_required').hide();
                    $('#minimum_time').hide();
                    $('#extra_fee').hide();
                    $('#toStep5container').show();
                }

            }
        }
    }
;

$(".select2-multiple").select2({
    allowClear: true
});

String.prototype.lpad = function (padString, length) {
    var str = this;
    while (str.length < length)
        str = padString + str;
    return str;
};

var weekday12 = null;
var weekday15 = null;

var currentDate = new Date();
var count = 0;
while (count < 15) {
    currentDate.setDate(currentDate.getDate() + 1);
    if (currentDate.getDay() != 0 && currentDate.getDay() != 6) {
        count++;
    }
    if (count == 12) {
        weekday12 = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1 + "").lpad("0", 2) + '-' + ('' + currentDate.getDate()).lpad("0", 2);
    }
    if (count == 15) {
        weekday15 = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1 + "").lpad("0", 2) + '-' + ('' + currentDate.getDate()).lpad("0", 2);
    }
}

$(document).ready(function () {
    // $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    $('.datepicker-here')
        .datepicker({
            daysOfWeekDisabled: [0, 6],
            autoclose: true,
            startDate: new Date(weekday12),
            endDate: '+3M',
            todayHighlight: false,
            beforeShowDay: function (date) {
                var formattedDate = date.getFullYear() + '-' + (date.getMonth() + 1 + "").lpad("0", 2) + '-' + ('' + date.getDate()).lpad("0", 2);
                return formattedDate >= weekday12;
            },
        })
        .on('changeDate', function (e) {
            GreekHouse.wizardPage.dateFieldsVisibility();
        });

    var textAreas = document.getElementsByTagName('textarea');


    // tab control
    $('a[href="#tabTwo"]').on('show.bs.tab', function (e) {
        if (!GreekHouse.wizardPage.validateForTab2()) {
            GreekHouse.wizardPage.tab1ShowErrors();

            return false;
        }
    });


    // Tab switching logic
    $('#toStep2').on('click', GreekHouse.wizardPage.toStep2);
    $('#toStep3').on('click', GreekHouse.wizardPage.toStep3);
    $('#toStep4').on('click', GreekHouse.wizardPage.toStep4);
    $('#toStep5').on('click', GreekHouse.wizardPage.toStep5);

    // Step 4 selects
    $('#print_type_select').on('change', function (e) {
        GreekHouse.wizardPage.printType = $(this).val();
        $('#review_print_type').text($(this).val());
    });

    $('#print_type_select_two').on('change', function (e) {
        GreekHouse.wizardPage.totalEstimatedQuantity = $(this).val();
        $('#review_total_est_qty').text($(this).val());
    });

    $('div#modalLargeProducts').on('hidden.bs.modal', function (event) {
        history.pushState('data', '', '/wizard/product');
    });

    // carousel apparel categories
    $('a.carousel-apparel-anchor').on('click', function (e) {
        e.preventDefault();

        GreekHouse.wizardPage.util.showLoading();

        var category = $(this).attr('data-category');
        var data = GreekHouse.wizardPage.util.fetchData(category);

        $container = $('#section4x4');
        $container.empty();
        $row = $container.append('<div class="row" />');

        $.each(data, function (i, item) {
            $element = $('<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" />');
            $thumbWrapper = $('<div class="thumb-wrapper" />');
            $anchor = $('<a href="#" class="product-item-anchor no-decoration" />');
            $anchor.attr('data-id', item.id);
            $anchor.attr('data-name', item.name);
            $anchor.attr('data-img', item.img);
            $anchor.attr('data-style', item.style);
            $anchor.attr('data-type', item.type);
            $anchor.attr('data-size', item.size);
            $anchor.attr('data-description', item.description);
            $anchor.attr('data-gender', item.gender);
            $anchor.attr('data-colors', item.colors);
            $productImgWrapper = $('<div class="product-wrapper"><img class="designs-img products-img" src="' + item.img + '"></div>');
            $productTextWrapper = $('<div class="text-wrapper"><p class="description-product">' + item.name + '</p></div>');
            $anchor
                .append($productImgWrapper)
                .append($productTextWrapper);
            $thumbWrapper.append($anchor);
            $element.append($thumbWrapper);
            $row.append($element);

            if (GreekHouse.wizardPage.original_product_id == item.id) {
                $thumbWrapper.addClass('active');
            }
        });

        GreekHouse.wizardPage.util.hideLoading();
        $('body').animate({
            scrollTop: $('#gender-section').offset().top
        }, 1000);
    });

    $('form.tab-one-search-box').on('submit', function (e) {
        e.preventDefault();
        console.log('Search fired ...');
        GreekHouse.wizardPage.util.showLoading();

        var query = $('#search-query').val();
        var data = GreekHouse.wizardPage.util.fetchData('', query);

        $container = $('#section4x4');
        $container.empty();
        $row = $container.append('<div class="row" />');

        $.each(data, function (i, item) {
            $element = $('<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" />');
            $thumbWrapper = $('<div class="thumb-wrapper" />');
            $anchor = $('<a href="#" class="product-item-anchor no-decoration" />');
            $anchor.attr('data-id', item.id);
            $anchor.attr('data-name', item.name);
            $anchor.attr('data-img', item.img);
            $anchor.attr('data-style', item.style);
            $anchor.attr('data-type', item.type);
            $anchor.attr('data-size', item.size);
            $anchor.attr('data-description', item.description);
            $anchor.attr('data-gender', item.gender);
            $anchor.attr('data-colors', item.colors);
            $productImgWrapper = $('<div class="product-wrapper"><img class="designs-img products-img" src="' + item.img + '"></div>');
            $productTextWrapper = $('<div class="text-wrapper"><p class="description-product">' + item.name + '</p></div>');
            $anchor
                .append($productImgWrapper)
                .append($productTextWrapper);
            $thumbWrapper.append($anchor);
            $element.append($thumbWrapper);
            $row.append($element);

            if (GreekHouse.wizardPage.original_product_id == item.id) {
                $thumbWrapper.addClass('active');
            }
        });

        GreekHouse.wizardPage.util.hideLoading();
    });


    $(".filter-button").click(function () {
        var value = $(this).attr('data-filter');

        // get in next carousel via ajax

        if ($(".filter-button").removeClass("active")) {
            $(this).removeClass("active");
        }
        $(this).addClass("active");
    });

    $('.btn-search-gender').on('click', function (e) {
        e.preventDefault();
        var gender = $(this).attr('data-gender');
        $('.btn-search-gender').removeClass('active');
        $(this).addClass('active');

        GreekHouse.wizardPage.filterProductsByGender(gender);
    });

    $('body').on('click', 'a.product-item-anchor', function (e) {
        e.preventDefault();
        GreekHouse.wizardPage.openModal($(this));
    });


    $('.print-location-checkbox').on('change', function (e) {
        var id = $(this).attr('id');
        var checked = $(this).prop('checked');
        console.log(id + " is " + checked);

        // check for collisions, and return false/message if collision
        // TODO: this is missing!

        // show corresponding box
        if (checked) {
            if ('print_location_front' === id) {
                $('#location_front').removeClass('hide');
                $('#print_location_pocket').prop('checked', false);
                $('#print_location_pocket').trigger('change');
            }
            if ('print_location_back' === id) $('#location_back').removeClass('hide');
            if ('print_location_sleeve' === id) $('#location_sleeve').removeClass('hide');
            if ('print_location_pocket' === id) {
                $('#location_pocket').removeClass('hide');
                $('#print_location_front').prop('checked', false);
                $('#print_location_front').trigger('change');
            }
        } else {
            if ('print_location_front' === id) $('#location_front').addClass('hide');
            if ('print_location_back' === id) $('#location_back').addClass('hide');
            if ('print_location_sleeve' === id) $('#location_sleeve').addClass('hide');
            if ('print_location_pocket' === id) $('#location_pocket').addClass('hide');
        }

    });


// step 3 add new product
    $('#style').on('change', function () {
        var data = GreekHouse.wizardPage.types[$(this).val()];
        GreekHouse.wizardPage.populateProducts(data);
    });

    $('#add').on('click', function (e) {
        e.preventDefault();
        var selected = $('#products').find('option:selected');

        if (!selected.val()) {
            sweetAlert('', 'Please select a product!', 'error');
            return;
        }
        $("#categories option:selected").prop("selected", false);

        // fetch information
        $.getJSON('/wizard/ajax/product-detail/' + selected.val(), function (data) {
            var newProduct = {
                id: data.id,
                img: data.image,
                name: data.name,
                colors: data.colors,
                additionalColors: [],
            };
            GreekHouse.wizardPage.addProduct(newProduct, true);
            GreekHouse.wizardPage.resetProducts();

            var img = selected.attr('data-img');
            var id = selected.attr('data-id');

        });
    });

    $('#add_new_product_box').on('click', function (e) {
        e.preventDefault();
        if (GreekHouse.wizardPage.products.length >= GreekHouse.wizardPage.MAX_PRODUCTS_COUNT) {
            sweetAlert("Cannot add more", "You cannot have more than " + GreekHouse.wizardPage.MAX_PRODUCTS_COUNT + " products!", "error");
            return;
        }

        $('#add_new_product_control').show('fast');
    });

    $('body').on('click', 'a.trash-product', function (e) {
        e.preventDefault();
        //$product = $(this).parent();
        $product = $(this).closest('.cart_product');
        key = $product.attr('data-key');
        GreekHouse.wizardPage.deleteProduct(key);
        GreekHouse.wizardPage.renderProductList(GreekHouse.wizardPage.products);
        return false;
    });

    $('#campaign-name').on('keyup', function () {
        GreekHouse.wizardPage.campaignName = $(this).val();
        $('h2.product-name-big').text($(this).val());
    });

// delivery on tab4
    $('input[name="delivery_name"]').on('keyup', function () {
        GreekHouse.wizardPage.delivery.name = $(this).val();
        $('input[name="review_name"]').val($(this).val());
    });
    $('input[name="delivery_address_line1"]').on('keyup', function () {
        GreekHouse.wizardPage.delivery.addressLine1 = $(this).val();
        $('input[name="review_address_line1"]').val($(this).val());
    });
    $('input[name="delivery_address_line2"]').on('keyup', function () {
        GreekHouse.wizardPage.delivery.addressLine2 = $(this).val();
        $('input[name="review_address_line2"]').val($(this).val());
    });
    $('input[name="delivery_city"]').on('keyup', function () {
        GreekHouse.wizardPage.delivery.city = $(this).val();
        $('input[name="review_city"]').val($(this).val());
    });
    $('input[name="delivery_state"]').on('keyup', function () {
        GreekHouse.wizardPage.delivery.state = $(this).val();
        $('input[name="review_state"]').val($(this).val());
    });
    $('input[name="delivery_zip"]').on('keyup', function () {
        GreekHouse.wizardPage.delivery.zipCode = $(this).val();
        $('input[name="review_zip"]').val($(this).val());
    });
    $('#order-delivery').on('change', function () {
        var selected = $(this).val()
        GreekHouse.wizardPage.delivery.orderDeliveryTimeframe = selected;

        if (!selected) {
            $('#toStep5container').hide();
            $('#needed_date').hide();
            $('#extra_fee').hide();
            return;
        } else if (selected == 'yes') {
            $('#toStep5container').show();
            $('#needed_date').hide();
            $('#extra_fee').hide();
        } else {
            // show date etc..
            $('#toStep5container').hide();
            $('#needed_date').show();
            $('#extra_fee').hide();
            GreekHouse.wizardPage.dateFieldsVisibility();
        }
    });
    $('#extra_fee select').on('change', function () {
        var selected = $(this).val();
        GreekHouse.wizardPage.delivery.orderDeliveryAcceptFees = selected;

        if (!selected) {
            return;
        } else if (selected == 'yes') {
            $('#toStep5container').show();
        } else {
            $('#toStep5container').hide();
        }
    });


// print location control
    $('#print_location_front').on('change', function () {
        if (this.checked) {
            $('#location_front').show();
            GreekHouse.wizardPage.print.front.selected = true;
        } else {
            $('#location_front').hide();
            GreekHouse.wizardPage.print.front.selected = false;
        }
        GreekHouse.wizardPage.updateReviewPrintLocations();
    });
    $('#print_location_back').on('change', function () {
        if (this.checked) {
            $('#location_back').show();
            GreekHouse.wizardPage.print.back.selected = true;
        } else {
            $('#location_back').hide();
            GreekHouse.wizardPage.print.back.selected = false;
        }
        GreekHouse.wizardPage.updateReviewPrintLocations();
    });
    $('#print_location_sleeve').on('change', function () {
        if (this.checked) {
            $('#location_sleeve').show();
            GreekHouse.wizardPage.print.sleeve.selected = true;
        } else {
            $('#location_sleeve').hide();
            GreekHouse.wizardPage.print.sleeve.selected = false;
        }
        GreekHouse.wizardPage.updateReviewPrintLocations();
    });
    $('#print_location_pocket').on('change', function () {
        if (this.checked) {
            $('#location_pocket').show();
            GreekHouse.wizardPage.print.pocket.selected = true;
        } else {
            $('#location_pocket').hide();
            GreekHouse.wizardPage.print.pocket.selected = false;
        }
        GreekHouse.wizardPage.updateReviewPrintLocations();
    });

    $('#print_front_desc').on('change', function () {
        GreekHouse.wizardPage.print.front.desc = $(this).val();
        $('#review_print_front p').text($(this).val());
    });
    $('#print_front_nr_colors').on('change', function () {
        GreekHouse.wizardPage.print.front.colors = $(this).val();
        $('#review_print_front_nr_colors').text($(this).val());
    });
    $('#print_back_desc').on('change', function () {
        GreekHouse.wizardPage.print.back.desc = $(this).val();
        $('#review_print_back p').text($(this).val());
    });
    $('#print_back_nr_colors').on('change', function () {
        GreekHouse.wizardPage.print.back.colors = $(this).val();
        $('#review_print_back_nr_colors').text($(this).val());
    });
    $('#print_sleeve_desc').on('change', function () {
        GreekHouse.wizardPage.print.sleeve.desc = $(this).val();
        $('#review_print_sleeve p').text($(this).val());
    });
    $('#print_sleeve_nr_colors').on('change', function () {
        GreekHouse.wizardPage.print.sleeve.colors = $(this).val();
        $('#review_print_sleeve_nr_colors').text($(this).val());
    });
    $('#print_pocket_desc').on('change', function () {
        GreekHouse.wizardPage.print.pocket.desc = $(this).val();
        $('#review_print_pocket p').text($(this).val());
    });
    $('#print_pocket_nr_colors').on('change', function () {
        GreekHouse.wizardPage.print.pocket.colors = $(this).val();
        $('#review_print_pocket_nr_colors').text($(this).val());
    });

    $('#edit_shipping_info').on('click', function (e) {
        e.preventDefault();
        GreekHouse.wizardPage.initTab4();
        $('html, body').animate({
            scrollTop: $("#tabFour").offset().top
        }, 500);
    });


    $('#modalLargeProducts').on('click', '.color-picker-modal-anchor', function (e) {
        e.preventDefault();
        $('#modalLargeProducts .color-picker-modal-anchor').attr('style', '');
        GreekHouse.wizardPage.setColor($(this).attr('data-id'), this.title);
        $('#productModalLargeTitleColor').text(' - ' + this.title);
        $('#modalLargeProducts').find('.color-picker-modal-anchor').each(function () {
            $(this).removeClass('active');
            $(this).css('border-color', 'transparent').css('border-radius', '0px');
        });
        $(this).css('border-color', '#3a3939').css('border-radius', '10px');
        $(this).addClass('active');
        GreekHouse.wizardPage.tab1.modal.img.attr('src', '/images/download.gif');
        var that = this;
        setTimeout(function () {
            GreekHouse.wizardPage.tab1.modal.img.attr('src', $(that).attr('data-image'));
        }, 100);
        return false;
    });


// color picker for products
    $('body').on('click', '.cart_product .colorpicker_popup .color', function (e) {
        e.preventDefault();
        var selectedColor = {
            id: $(this).attr('data-id'),
            name: $(this).attr('title'),
            image: $(this).attr('data-thumbnail'),
        };
        var productKey = $(this).closest('.cart_product').attr('data-key');

        GreekHouse.wizardPage.addColor(productKey, selectedColor, true);
    });

    $('body').on('click', '.color_slot .fa', function (e) {
        e.preventDefault();
        var slotNumber = $(this).closest('.color_slot').attr('data-slot');
        var key = slotNumber - 1;

        $product = $(this).closest('.cart_product');
        var productKey = $product.attr('data-key');
        if (key in GreekHouse.wizardPage.products[productKey].additionalColors) {
            GreekHouse.wizardPage.products[productKey].additionalColors.splice(key, 1);
            GreekHouse.wizardPage.updateProductTree();
            GreekHouse.wizardPage.updateAddProductColors();
        }

        $product.find('.color_slot').each(function () {
            $(this).removeClass('active');
            $(this).css('background-image', '');
        });

        var slot = 1;
        for (var key in GreekHouse.wizardPage.products[productKey].additionalColors) {
            $product.find('.color_slot_' + slot).css('background-image', 'url(' + GreekHouse.wizardPage.products[productKey].additionalColors[key].image + ')');
            $product.find('.color_slot_' + slot).addClass('active');
            slot++;
        }
    });

})
;