let GreekHouseModule = {
    width: 800,
    height: 600,
    options: function (options) {
        if (options.width) GreekHousePrompt.width = options.width;
        if (options.height) GreekHousePrompt.height = options.height;

        return this;
    },
    normalizeOptions: function (options) {
        let normalizedOptions = {};
        normalizedOptions.width = options.width ? options.width : this.width;
        normalizedOptions.height = options.height ? options.height : this.height;

        return normalizedOptions;
    },
    open: function (url, options) {
        let activeOptions = this.normalizeOptions(typeof options !== 'undefined' ? options : {});
        var width = activeOptions.width;
        if (parseInt(width) == width) {
            width += "px";
        }
        var height = activeOptions.height;
        if (parseInt(height) == height) {
            height += "px";
        }
        $("#gh-module-popup").find('.modal-dialog').css({'min-width': width, 'min-height': height});

        $("#gh-module-popup .modal-body").addClass('loading');
        $("#gh-module-popup .modal-body").html('');
        $("#gh-module-popup .modal-body").load(url, function (response, status, xhr) {
            if (status === "error") {
                $("#gh-module-popup .modal-body").html("<div class=\"module-popup\">\n" +
                    "    <div class=\"module-header\">\n" +
                    "        <div class=\"module-title\">\n" +
                    "            Module Error\n" +
                    "            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\n" +
                    "                <span aria-hidden=\"true\">×</span>\n" +
                    "            </button>\n" +
                    "        </div>\n" +
                    "    </div>\n" +
                    "    <div class=\"module-body\">\n" +
                    "        <div class=\"module-content\">\n" +
                    "<p class=\"mb-0\">" + xhr.statusText + ": " + xhr.status + "</p>\n" +
                    "        </div>\n" +
                    "    </div>\n" +
                    "</div>");
            }
            $("#gh-module-popup .modal-body").removeClass('loading');
        });

        $('#gh-module-popup').modal();
    },
    close: function () {
        $("#gh-module-popup").modal('hide');
    },
    moduleLink: function (event) {
        let options = {};
        if ($(this).attr('data-width')) {
            options.width = $(this).attr('data-width');
        }
        if ($(this).attr('data-height')) {
            options.height = $(this).attr('data-height');
        }

        GreekHouseModule.open($(this).attr('href'), options);

        event.preventDefault();
        return false;
    },
    formSubmit: function (event) {
        let formData = $(this).serialize();

        // Disable Buttons
        $('#gh-module-popup button').prop('disabled', true);

        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: formData,
            success: GreekHouseModule.formSubmitSuccess,
            error: GreekHouseModule.formSubmitFail,
            complete: GreekHouseModule.formSubmitComplete,
            dataType: 'json'
        });

        event.preventDefault();
        return false;
    },
    formSubmitSuccess: function (data) {
        $('#gh-module-popup .ajax-messages').empty();

        // Display Successes
        if (data.successes) {
            for (let i = 0; i < data.successes.length; i++) {
                $('#gh-module-popup .ajax-messages').append($('<div class="alert alert-success" role="alert">' + data.successes[i] + '</div>'));
            }
        }

        // Display errors
        if (data.errors) {
            let errorText = $('<ul></ul>');
            for (let index in data.errors) {
                if (data.errors[index] instanceof Array) {
                    data.errors[index].forEach(function (errorEntry, index2) {
                        errorText.append($('<li>' + errorEntry + '</li>'));
                    });
                } else {
                    errorText.append($('<li>' + data.errors[index] + '</li>'));
                }
            }

            let errorDiv = $('<div class="alert alert-danger" role="alert"></div>');
            errorDiv.html(errorText);
            $('#gh-module-popup .ajax-messages').append(errorDiv);
        }

        // Callback
        let callbackResult = (typeof callback !== 'undefined' && callback()) || typeof callback === 'undefined';
        if (data.success) {
            if (data.intended && callbackResult) {
                $('#gh-module-popup .ajax-messages').append($('<div class="alert alert-success" role="alert">Submit Successful. Redirecting...</div>'));
                window.location = data.intended;
            } else {
                $('#gh-module-popup .ajax-messages').append($('<div class="alert alert-success" role="alert">Submit Successful.</div>'));
            }
        }
    },
    formSubmitFail: function (data) {
        $('#gh-module-popup .ajax-messages').empty();
        $('#gh-module-popup .ajax-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
    },
    formSubmitComplete: function (data) {
        // Enable Buttons
        $("#gh-module-popup button").prop('disabled', false);
    },
    formClose: function (event) {
        event.preventDefault();
        $("#gh-module-popup").modal('hide');

        return false;
    }
};

$('body').on('click', '.module-link', GreekHouseModule.moduleLink);
$('body').on('submit', '#gh-module-popup form', GreekHouseModule.formSubmit);
$('body').on('click', '.btn-close', GreekHouseModule.formClose);

window.GreekHouseModule = GreekHouseModule;
