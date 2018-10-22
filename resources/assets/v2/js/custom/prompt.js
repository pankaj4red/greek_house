let GreekHousePrompt = {
    title: '',
    text: '',
    buttons: '',
    width: 600,
    height: 400,
    options: function (options) {
        if (options.title) GreekHousePrompt.title = options.title;
        if (options.text) GreekHousePrompt.text = options.text;
        if (options.width) GreekHousePrompt.width = options.width;
        if (options.height) GreekHousePrompt.height = options.height;
        if (options.buttons) {
            GreekHousePrompt.buttons = options.buttons;
        }

        return this;
    },
    normalizeOptions: function (options) {
        let normalizedOptions = {};
        normalizedOptions.title = options.title ? options.title : this.title;
        normalizedOptions.text = options.text ? options.text : this.text;
        normalizedOptions.width = options.width ? options.width : this.width;
        normalizedOptions.height = options.height ? options.height : this.height;
        normalizedOptions.buttons = options.buttons ? options.buttons : this.buttons;

        return normalizedOptions;
    },
    show: function (options) {
        let activeOptions = this.normalizeOptions(typeof options !== 'undefined' ? options : this.defaltOptions);
        $("#gh-prompt").find('.modal-dialog').css({'min-width': activeOptions.width + 'px', 'min-height': activeOptions.height + 'px'});

        $("#gh-prompt .modal-title").text(activeOptions.title);
        $("#gh-prompt .modal-body").html(activeOptions.text);

        $("#gh-prompt .modal-footer").html('');
        $.each(activeOptions.buttons, function (index, value) {
            var button = $('<button type="button" class="btn"></button>');
            if (value.text) button.text(value.text);
            if (value.class) button.addClass(value.class);
            if (value.callback) button.click(value.callback);
            $("#gh-prompt .modal-footer").append(button);
        });

        $('#gh-prompt').modal();
    },
    close: function () {
        $("#gh-prompt").modal('hide');
    },
    alert: function (title, text) {
        return this.show({
            title: title,
            text: text,
            buttons: [
                {
                    text: 'Ok',
                    'class': 'btn-blue-transparent',
                    callback: function () {
                        GreekHousePrompt.close();
                    }
                }
            ]
        });
    }
};

window.GreekHousePrompt = GreekHousePrompt;
