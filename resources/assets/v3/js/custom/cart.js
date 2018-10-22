function updateCartQuantity() {
    var price = $(this).closest('.cart-entry').find('.cart-entry-price').val();
    var quantity = parseInt($(this).closest('.cart-entry').find('.quantity-counter-quantity').val());

    if (quantity <= 1 || !quantity) {
        quantity = 1;
    }
    var subtotal = price * quantity;

    $(this).closest('.cart-entry').find('.cart-entry-pricing-details').text(quantity + 'x $' + number_format(price));
    $(this).closest('.cart-entry').find('.cart-entry-pricing-subtotal').text('$' + number_format(subtotal));
    updateCartData();
}

function updateCartData() {
    var subtotal = 0;
    var quantity = 0;
    $('.cart-entry').each(function () {
        var entryQuantity = parseInt($(this).find('.quantity-counter-quantity').val());
        if (! entryQuantity || entryQuantity < 1) {
            entryQuantity = 1;
        }
        subtotal += $(this).find('.cart-entry-price').val() * entryQuantity;
        quantity += entryQuantity;
    });

    var shipping = $(this).find('.cart-shipping').length > 0 ? $(this).find('.cart-shipping').val() : 0;
    var total = subtotal + shipping;

    $('.cart-subtotal').text('$' + number_format(subtotal));
    $('.cart-shipping').text('$' + number_format(shipping));
    $('.cart-total').text('$' + number_format(total));
}

function deleteCartEntry(event) {
    event.preventDefault();
    var cartId = $('.cart-id').val();
    var entryContainer = $(this).closest('.cart-entry');
    var name = entryContainer.find('.cart-entry-description-details').text();
    if (confirm('Are you sure you want to remove "' + name + '" from cart?')) {

        var entryId = entryContainer.find('.cart-entry-id').val();

        $.ajax({
            url: '/store/cart/ajax/delete-item/' + cartId,
            type: 'POST',
            data: { id: entryId },
            dataType: 'json',
            complete: function complete(data) {
                if (data.responseJSON.success) {
                    entryContainer.remove();
                    updateCartData();
                } else {
                    alert(data.responseJSON.message);
                }
            }
        });
    }

    return false;
}

$('.cart-entry input[type=text]').change(updateCartQuantity);
$('.cart-entry input[type=text]').keyup(updateCartQuantity);
$('.cart-entry .cart-entry-remove').click(deleteCartEntry);
