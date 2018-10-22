$(".js-datepicker").datepicker({
    onSelect: function (dateText, object) {
        $(object.input.attr('data-input')).val(dateText);
    },
    dateFormat: "mm/dd/y"
});


$('.ui-datepicker').addClass('greekhouse-datepicker');
