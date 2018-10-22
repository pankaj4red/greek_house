<script>
    function attachAjax(selector, callback) {
        $(selector).click(function (event) {
            event.preventDefault();
            var formData = $(this).closest('form').serialize();
            $(this).prop('disabled', true);
            $(this).append('<div class="ajax-progress ajax-progress-throbber"><i class="glyphicon glyphicon-refresh glyphicon-spin"></i></div>');
            var that = this;
            $.ajax({
                url: $(this).closest('form').attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        $(that).closest('form').find('.ajax-messages').empty();
                        if (data.successes) {
                            for (var i = 0; i < data.successes.length; i++) {
                                $('.ajax-messages').append($('<div class="alert alert-success" role="alert">' + data.successes[i] + '</div>'));
                            }
                        }
                        $(that).closest('form').find('.ajax-messages').append($('<div class="alert alert-success" role="alert">Submit Successful. Redirecting...</div>'));
                        if (!callback || callback() !== false) {

                            if (data.intended) {
                                window.location = data.intended;
                            }
                        }
                    } else {
                        $(that).closest('form').find('.ajax-messages').empty();
                        var errorText = $('<ul></ul>');
                        if (data.errors) {
                            for (var index in data.errors) {
                                if (data.errors[index] instanceof Array) {
                                    data.errors[index].forEach(function (errorEntry, index2) {
                                        errorText.append($('<li>' + errorEntry + '</li>'));
                                    });
                                } else {
                                    data.errors[index].append($('<li>' + error + '</li>'));
                                }
                            }
                        }
                        var alert = $('<div class="alert alert-danger" role="alert"></div>');
                        alert.append(errorText);
                        $(that).closest('form').find('.ajax-messages').append(alert);
                        if (data.successes) {
                            for (i = 0; i < data.successes.length; i++) {
                                $('.ajax-messages').append($('<div class="alert alert-success" role="alert">' + data.successes[i] + '</div>'));
                            }
                        }
                    }
                },
                error: function (data) {
                    $(that).closest('form').find('.ajax-messages').empty();
                    $(that).closest('form').find('.ajax-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
                },
                complete: function () {
                    $(that).find('.ajax-progress').remove();
                    $(that).prop('disabled', false);
                }
            });
            return false;
        });
    }
    attachAjax('#popup-ajax-button');
</script>