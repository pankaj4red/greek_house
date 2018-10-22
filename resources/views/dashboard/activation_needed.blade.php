@extends ('customer')

@section ('title', 'Activation Needed')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="container">
        <div class="form-header">
            <h1><i class="icon icon-squares"></i><span class="icon-text">Activation needed</span></h1>
            <hr/>
        </div>
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        <p class="text-center margin-top-100">
            The account needs to be activated before accessing this content.
        </p>
        <p class="text-center">
            Please contact us at support@greekhouse.org
        </p>
    </div>
@endsection