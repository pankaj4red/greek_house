@extends ('customer')

@section ('title', 'Prints Information')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        <div class="container">
            @endif
            <div class="popup">
                <div class="popup-title">UPLOAD PRINTS</div>
                <div class="popup-body">
                    <div class="ajax-messages"></div>
                    @if (messages_exist())
                        {!! messages_output() !!}
                    @endif
                    {!! Form::model($model, ['id' => 'ajax-form']) !!}
                    <div class="row">
                        <div class="col-md-12">
                            @for($i = 1; $i <= 10; $i++)
                                <div class="form-group">
                                    <label for="print{{ $i }}">Print File #{{ $i }}</label>
                                    @if (isset($prints[$i]))
                                        <div class="file-entry">
                                            <div class="file-entry-file">
                                                <a href="{{ $prints[$i]['url'] }}"
                                                   target="_blank">{{ $prints[$i]['filename'] }}</a>
                                            </div>
                                            <input type="hidden" value="{{ $prints[$i]['url'] }}"
                                                   name="print{{ $i }}_url"/>
                                            <input type="hidden" value="{{ $prints[$i]['filename'] }}"
                                                   name="print{{ $i }}_filename"/>
                                            <input type="hidden" value="{{ $prints[$i]['id'] }}"
                                                   name="print{{ $i }}_id"/>
                                            <input type="hidden" value="existing" name="print{{ $i }}_action"/>
                                            <a href="#" class="btn btn-danger file-remove" data-target="print{{ $i }}">Remove</a>
                                        </div>
                                    @endif
                                    <div class="filepicker-file">
                                        <a href="#" class="filepicker" data-type="image" id="print{{ $i }}">Browse</a>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="action-row">
                        <a href="{{ URL::previous() }}" class="button-back btn btn-default back-btn">Cancel</a>
                        <button type="submit" name="save" value="save" class="btn btn-primary" id="ajax-button">Save
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            @if (!Request::ajax())
        </div>
    @endif
@endsection

@section ('include')
    @include ('partials.enable_filepicker')
@append

@section ('javascript')
    @if (Request::ajax())
        <script>
            $('#ajax-button').click(function (event) {
                event.preventDefault();
                var formData = $("#ajax-form").serialize();
                $(this).prop('disabled', true);
                $(this).append('<div class="ajax-progress ajax-progress-throbber"><i class="glyphicon glyphicon-refresh glyphicon-spin"></i></div>');
                var that = this;
                $.ajax({
                    url: '{{ Request::url() }}',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        if (data.success) {
                            $('.ajax-messages').empty();
                            for (var i = 0; i < data.successes.length; i++) {
                                $('.ajax-messages').append($('<div class="alert alert-success" role="alert">' + data.successes[i] + '</div>'));
                            }
                            $('.ajax-messages').append($('<div class="alert alert-success" role="alert">Submit Successful. Redirecting...</div>'));
                            window.location = data.intended;
                        } else {
                            $('.ajax-messages').empty();
                            var errorText = $('<ul></ul>');
                            for (var j = 0; j < data.errors.length; j++) {
                                errorText.append($('<li>' + data.errors[j] + '</li>'));
                            }
                            var alert = $('<div class="alert alert-danger" role="alert"></div>');
                            alert.append(errorText);
                            $('.ajax-messages').append(alert);
                            for (var k = 0; k < data.successes.length; k++) {
                                $('.ajax-messages').append($('<div class="alert alert-success" role="alert">' + data.successes[k] + '</div>'));
                            }
                        }
                    },
                    error: function (data) {
                        $('.ajax-messages').empty();
                        $('.ajax-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
                    },
                    complete: function () {
                        $(that).find('.ajax-progress').remove();
                        $(that).prop('disabled', false);
                    }
                });
                return false;
            });
        </script>
    @endif
@append
