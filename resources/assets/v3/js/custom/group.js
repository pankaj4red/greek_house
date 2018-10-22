let GreekHouseGroup = {
    init: function () {
        $('body').on('click', 'button[data-group-trigger-group][data-group-trigger-value]', this.trigger);
        $('body').on('click', 'input[data-group-trigger-group][data-group-trigger-value]', this.trigger);
    },
    trigger: function (event) {
        event.preventDefault();

        let group = $(this).attr('data-group-trigger-group');
        let value = $(this).attr('data-group-trigger-value');

        $('*[data-group-container-group="' + group + '"]').each(function () {
            if (value == $(this).attr('data-group-container-value')) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        $('*[data-group-trigger-group="' + group + '"]').each(function () {
            $(this).removeClass('active');
        });

        $(this).addClass('active');

        return false;
    },
};

window.GreekHouseGroup = GreekHouseGroup;
GreekHouseGroup.init();
