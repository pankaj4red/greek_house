@extends('v2.layouts.app')

@section('title', 'Ambassador - Thank You')

@section('content')
    <div class="container">
        @include ('v2.partials.messages.all')
        <div class="row">
            <div class="confirmation-box">
                <img src="{{ static_asset('images/thumbs-up-icon.png') }}" alt="image">
                <h1><span>Congrats</span> You Did it!</h1>
            </div>
        </div>
    </div>
@endsection
