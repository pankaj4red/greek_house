@foreach ($errors->getMessages() as $key => $errorList)
    @if (! in_array($key, $except))
        @if (is_array($errorList))
            @foreach ($errorList as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @else
            <div class="alert alert-danger">{{ $errorList }}</div>
        @endif
    @endif
@endforeach
