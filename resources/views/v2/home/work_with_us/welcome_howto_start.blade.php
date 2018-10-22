@extends('v2.layouts.app')

@section('title', 'Work With Us - Thank You')
@section('content')
    <div class="container thanks-page">
        @include ('v2.partials.messages.all')
        <div class="row">
            <div class="col-md-8 centered">
                <p class="font-regular-large heading">Welcome to Greek House</p>
                <h1 class="font-header-standard mt-3 text-center">here’s three ways you can get started!</h1>
                <hr class="separator-medium-gray  text-center"/>
                <div class="row" id="homepage-how-it-works-content">
                    <div class="col-12 col-md-4 pull-left mt-5 mb-5">
                        <a href="{{url('designs-gallery')}}">
                            <div class="numbered-container">
                                <img class="list-image fixed-size-image img-responsive" src="{{ static_asset('images/lead-signup/browse_designs.png') }}"/>
                                <span class="list-caption gray">Browse Design Gallery</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 pull-left mt-5 mb-5">
                        <a href="{{url('start-here')}}">

                            <div class="numbered-container">
                                <img class="list-image fixed-size-image img-responsive" src="{{ static_asset('images/lead-signup/submit_design.png') }}"/>
                                <span class="list-caption gray">Submit a Design Request</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 pull-left mt-5 mb-5">
                        <a href="{{route('work_with_us::schedule',['sales'])}}">

                            <div class="numbered-container">
                                <img class="list-image fixed-size-image img-responsive" src="{{ static_asset('images/lead-signup/talk_with_someone.png') }}"/>
                                <span class="list-caption gray">Talk with Someone</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 centered">
                <div class="panel panel-default panel-box">
                    <div class="panel-heading">
                        <h3 class="font-regular-large text-center blue-heading">Watch How It Works</h3>
                    </div>
                    <div class="panel-body text-center">
                        <iframe width="100%" height="400" id="youtube_iframe"
                                src="https://www.youtube.com/embed/n_o4KrjMO_U" frameborder="0" allow="autoplay; encrypted-media" frameborder="0"
                                allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="row"><div class="col-md-6 centered">
               <p class="info-text text-center">Thanks for letting us know, we'll have someone reach out to help you create the perfect design for your event.
               </p>
                   <p class="info-text text-center">In the meantime, feel free to head over to our design gallery to see what other chapters are creating on Greek House.</p>
                <div class="action-row text-center">
                    <a href="{{url('designs-gallery')}}">
                    <button type="button" class="btn btn-success" id="step-five-btn-submit">View Design Gallery</button>
                    </a>

                </div>
            </div> </div>

    </div>
@endsection

