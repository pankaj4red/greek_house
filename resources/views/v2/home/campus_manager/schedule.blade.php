@extends('v2.layouts.app')

@section('title', 'Campus Manager - Sign Up')

@section('content')
    <div class="container">
        @include ('v2.partials.messages.all')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-box">
                    <div class="panel-heading">
                        <h1 class="panel-title">
                            <i class="icon icon-user"></i>
                            <span class="icon-text">Schedule Your Welcome Call!</span>
                        </h1>
                    </div>
                    <div class="panel-body" id="container-w9">
                        <!-- Calendly inline widget begin -->
                        <div class="calendly-inline-widget" data-url="https://calendly.com/greekhouse/campus-manager" style="min-width:320px;height:580px;"></div>
                        <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
                        <!-- Calendly inline widget end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
