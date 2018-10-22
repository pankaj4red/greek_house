$('.quantity-counter .quantity-counter-minus').click(function (event) {
    event.preventDefault();

    var quantity = parseInt($(this).parent().find('input').val());
    quantity--;
    if (quantity < 1) {
        quantity = 1;
    }
    $(this).parent().find('input').val(quantity);
    $(this).parent().find('input').trigger('change');

    return false;
});

$('.quantity-counter .quantity-counter-plus').click(function (event) {
    event.preventDefault();

    var quantity = parseInt($(this).parent().find('input').val());
    quantity++;
    if (quantity < 1) {
        quantity = 1;
    }
    $(this).parent().find('input').val(quantity);
    $(this).parent().find('input').trigger('change');

    return false;
});