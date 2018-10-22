@extends('v2.layouts.app')

@section('title', 'Work With Us - Thank You')

@section('content')
    <div class="container thanks-page">
        @include ('v2.partials.messages.all')
        <div class="row">
            <div class="col-12 text-center mt-5">
                <p class="font-regular-large">Welcome to Greek House</p>
                <h1 class="font-header-standard mt-3">Submit A Design Request & Get Your<br/>
                    Free Design By This Time Tomorrow</h1>
                <hr class="separator-small"/>
                <p class="font-regular-large">Here's How it Works</p>
                <ul class="numbered-image-list mt-5">
                    <li>
                        <div class="list-item-container">
                            <span class="list-number"><span class="list-number-inner">1</span></span>
                            <img class="list-image" src="{{ static_asset('images/homepage/step-1.png') }}"/>
                            <span class="list-caption">Pick a Product</span>
                        </div>
                    </li>
                    <li>
                        <div class="list-item-container">
                            <span class="list-number"><span class="list-number-inner">2</span></span>
                            <img class="list-image" src="{{ static_asset('images/homepage/step-2.png') }}"/>
                            <span class="list-caption">Tell A Designer What You Want</span>
                        </div>
                    </li>
                    <li>
                        <div class="list-item-container">
                            <span class="list-number"><span class="list-number-inner">3</span></span>
                            <img class="list-image" src="{{ static_asset('images/homepage/step-2.png') }}"/>
                            <span class="list-caption">Receive a Design Within 24 Hours</span>
                        </div>
                    </li>
                </ul>
                <div class="mt-5">
                    <a class="btn btn-green-large" href="{{ route('wizard::start') }}">Start Your Design Request</a>
                </div>
                <p class="font-regular-space mt-4">(By submitting a design request you are not committing to an order)</p>
            </div>
        </div>
    </div>
@endsection

@section ('javascript')
    @if (config('services.facebook_pixel.enabled') && isset($chapterSize))
        <script>
            fbq('track', "{{ 'Sign Up Form Submitted - '. $chapterSize . ' (Lead)' }}");
        </script>
    @endif
@append
