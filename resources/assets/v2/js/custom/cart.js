var AppCart = function() {


    // add number input with plus/minus buttons - see example in store/cart view
    var initInputButtons  = function () {
        $(document).on('click', '.qty-plus', function(e) { changeInputValue(e, 'plus'); });
        $(document).on('click', '.qty-minus', function(e) { changeInputValue(e, 'minus'); });
    };

    var initShippingChange = function() {
        $(document).on('change', 'input[name="shipping"]', function() {
            changeCartQty();
        });
    };

    var initQtyChange = function() {
        $(document).on('change', 'input[name="quantity[]"]', function() {
            changeCartQty();
        });
    };

    var initDeleteProduct = function() {
        $(document).on('click', '.product__delete', function() {
            var productContainer = $(this).parent('.cart__product');
            if(confirm('Are you sure you want to delete product "' + productContainer.find('.product__name a').text() +'"?')) {

                var entryId = productContainer.find('.entry_id').val();

                $.ajax({
                    url: '/store/cart/ajax/delete-item/' + entryId,
                    type: 'GET',
                    //data: { id: entryId },
                    dataType: 'json',
                    complete: function(data) {
                        console.log(data);
                        productContainer.remove();
                        changeCartQty();
                    }
                });
            }
        });
    };


    //private functions
    var changeInputValue  = function (e, operation) {
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).parent('div');
        var inputElement = parent.find('input[name="' + fieldName + '"]');
        var currentVal = parseInt(inputElement.val(), 10);

        if (!isNaN(currentVal)) {
            if (operation == "plus") {
                inputElement.val(currentVal + 1);
                inputElement.change();
            } else if (operation == "minus" && currentVal > 1) {
                inputElement.val(currentVal - 1);
                inputElement.change();
            }
        }
    };

    var changeCartQty = function() {
        var cartTotal = 0;
        $('.cart__product:not(.subtotal)').each(function( index, element) {
            var productPrice = parseFloat($(element).find('input[name="price[]"]').val());
            var productQty = parseInt($(element).find('input[name="quantity[]"]').val(), 10);
            var productTotal = productPrice*productQty;
            $(element).find('.product__price').text("$" + productTotal.toFixed(2));
            cartTotal = cartTotal + productTotal;
        });

        $('#cart-subtotal').text("$" + cartTotal.toFixed(2));

        var shipping = parseFloat($('input[name="shipping"]:checked').val());
        var total = cartTotal + shipping;

        $('#cart-shipping').text("$" + shipping.toFixed(2));
        $('#cart-total').text("$" + total.toFixed(2));

    };


    return {
        init: function () {
            initInputButtons();
            initQtyChange();
            initDeleteProduct();
            initShippingChange();
            changeCartQty();
        }
    };

}();

$(document).ready(function () {
    AppCart.init();
});