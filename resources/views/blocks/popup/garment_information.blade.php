@extends ('customer')

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">GARMENT INFORMATION</div>
        <div class="popup-body">
            @include('partials.garment_information', ['redirect' => true])
        </div>
    </div>
    @if (!Request::ajax())
        {!! '</div>' !!}
    @endif
@endsection