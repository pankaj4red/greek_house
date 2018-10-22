let GreekHouseModalAjax = {
    formSubmit: function (event) {
        let formData = $(this).serialize();

        // Disable Buttons
        $('.modal-popup button[type=button], .modal-popup input[type=button], .modal-popup input[type=submit]').prop('disabled', true);

        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: formData,
            success: GreekHouseModalAjax.formSubmitSuccess,
            error: GreekHouseModalAjax.formSubmitFail,
            complete: GreekHouseModalAjax.formSubmitComplete,
            dataType: 'json'
        });

        event.preventDefault();
        return false;
    },
    formSubmitSuccess: function (data) {
        $('.modal-popup .ajax-messages').empty();

        // Display Successes
        if (data.successes) {
            for (let i = 0; i < data.successes.length; i++) {
                $('.modal-popup .ajax-messages').append($('<div class="alert alert-success" role="alert">' + data.successes[i] + '</div>'));
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
            $('.modal-popup .ajax-messages').append(errorDiv);
        }

        // Callback
        let callbackResult = (typeof callback !== 'undefined' && callback()) || typeof callback === 'undefined';
        if (data.success) {
            if (data.intended && callbackResult) {
                $('.modal-popup .ajax-messages').append($('<div class="alert alert-success" role="alert">Submit Successful. Redirecting...</div>'));
                window.location = data.intended;
            } else {
                $('.modal-popup .ajax-messages').append($('<div class="alert alert-success" role="alert">Submit Successful.</div>'));
            }
        }
    },
    formSubmitFail: function (data) {
        $('.modal-popup .ajax-messages').empty();
        $('.modal-popup .ajax-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
    },
    formSubmitComplete: function (data) {
        // Enable Buttons
        $('.modal-popup button[type=button], .modal-popup input[type=button], .modal-popup input[type=submit]').prop('disabled', false);
    },
    formClose: function (event) {
        event.preventDefault();
        $('#gh-modal').modal('hide');

        return false;
    }
};
window.GreekHouseModalAjax = GreekHouseModalAjax;
$('body').on('click', '.modal-popup .btn-back', GreekHouseModalAjax.formClose);
$('body').on('submit', '.modal-popup form', GreekHouseModalAjax.formSubmit);
