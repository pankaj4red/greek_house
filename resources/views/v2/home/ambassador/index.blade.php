@extends('v2.layouts.app')

@section('title', 'Ambassador')

@section('content')
    <div class="block-container" id="ambassador-program">
        <div class="container">
            <h1>Campus Ambassador Program</h1>
            <p>Campus Ambassadors are the heart and soul of our company. Become the face of Greek House at your campus and help change the way Greeks make custom apparel. Earn rewards for your chapter
                and build up your resume with one of the country’s fastest growing startups!</p>
            <a href="{{ route('ambassador::index') }}#ambassador-form" class="btn btn-blue slide-scroll" data-slide-scroll="#ambassador-form" data-slide-focus="#form-full-name">Join The
                Team</a>
        </div>
    </div>
    <div class="block-container" id="ambassador-join-team">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ static_asset('images/ambassador/platform-mobile.png') }}"/>
                </div>
                <div class="col-md-8">
                    <h2>Hundreds of Campuses,<br/>Thousands of Shirts,<br/>Millions of Memories.</h2>
                    <p>Greek House is the easiest way for Fraternities and Sororities to get custom apparel with awesome designs, no mistakes and the fastest turnaround in the industry.</p>
                    <p>Help your friends help themselves.</p>
                    <a href="{{ route('ambassador::index') }}#ambassador-form" class="btn btn-white-transparent slide-scroll" data-slide-scroll="#ambassador-form" data-slide-focus="#form-full-name">Join The
                        Team</a>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="ambassador-why">
        <div class="container">
            <div class="ambassador-why-section">
                <h2>Why become a Greek House Campus Ambassador?</h2>
                <hr/>
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/ambassador/professional_experience.gif') }}"/>
                        <h3>Professional Experience</h3>
                        <p>Stand out from your peers upon graduation to top employers!</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/ambassador/save_time.gif') }}"/>
                        <h3>Save Time</h3>
                        <p>Use the Greek House platform to get your orders done in half the time.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/ambassador/earn_rewards.gif') }}"/>
                        <h3>Earn Rewards</h3>
                        <p>Past reps have earned Yeti Coolers, GoPro’s, Round-Trip flights, and money for their philanthropy in a semester!</p>
                    </div>
                </div>
            </div>
            <div class="ambassador-why-section">
                <h2>What you do</h2>
                <hr/>
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/ambassador/make_awesome_apparel.gif') }}"/>
                        <h3>Make Awesome Apparel</h3>
                        <p>Earn rewards for your chapter for what you’re already doing.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/ambassador/chapter_spotlight.gif') }}"/>
                        <h3>Chapter Spotlight</h3>
                        <p>Send us pictures of your chapter wearing our products and get featured to over 60,000 viewers across the country.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/ambassador/network.gif') }}"/>
                        <h3>Network</h3>
                        <p>Connect with Ambassadors not only at your campus, but all over the country</p>
                    </div>
                </div>
            </div>
            <div class="ambassador-why-section">
                <h2>Who we are looking for</h2>
                <hr/>
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/ambassador/tshirt_chairs.gif') }}"/>
                        <h3>T-Shirts Chairs</h3>
                        <p>If you’ve ever ordered custom apparel for your chapter, you already know what we do. Your experience will help ensure your success.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/ambassador/well_connected.gif') }}"/>
                        <h3>Well Connected</h3>
                        <p>We are looking for individuals who are social, outgoing and fun!</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/ambassador/for_starters.gif') }}"/>
                        <h3>Self Starters</h3>
                        <p>As a Campus Ambassador, you will be the face of Greek House on campus. Make us proud by being awesome and self motivated.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="ambassador-form">
        <div class="container">
            <h2>Apply to become a Greek House Campus Ambassador Today!</h2>
            {{ Form::open(['method' => 'POST']) }}
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    @include ('v2.partials.messages.all', ['except' => ['name', 'email', 'phone', 'school', 'chapter', 'position', 'members', 'instagram']])
                    <div class="form-group">
                        {{ Form::text('name', null, ['class' => 'form-control ' . ($errors->get('name') ?  'is-invalid' : ''), 'placeholder' => 'Full Name', 'id' => 'form-full-name']) }}
                        @if ($errors->get('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::text('email', null, ['class' => 'form-control ' . ($errors->get('email') ?  'is-invalid' : ''), 'placeholder' => 'Email']) }}
                        @if ($errors->get('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::text('phone', null, ['class' => 'form-control ' . ($errors->get('phone') ?  'is-invalid' : ''), 'placeholder' => 'Phone']) }}
                        @if ($errors->get('phone'))
                            <div class="invalid-feedback">
                                {{ $errors->first('phone') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::text('school', null, ['class' => 'form-control ' . ($errors->get('school') ?  'is-invalid' : ''), 'placeholder' => 'School']) }}
                        @if ($errors->get('school'))
                            <div class="invalid-feedback">
                                {{ $errors->first('school') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::text('chapter', null, ['class' => 'form-control ' . ($errors->get('chapter') ?  'is-invalid' : ''), 'placeholder' => 'Fraternity or Sorority']) }}
                        @if ($errors->get('chapter'))
                            <div class="invalid-feedback">
                                {{ $errors->first('chapter') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::select('position', chapter_position_options(['' => 'Your position in your chapter']), null, ['class' => 'form-control select-placeholder ' . ($errors->get('position') ?  'is-invalid' : ''), 'data-placeholder' => '400', 'data-selected' => '500']) }}
                        @if ($errors->get('position'))
                            <div class="invalid-feedback">
                                {{ $errors->first('position') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::select('members', chapter_member_count_options(['' => '# of members in your organization']), null, ['class' => 'form-control select-placeholder ' . ($errors->get('members') ?  'is-invalid' : ''), 'data-placeholder' => '400', 'data-selected' => '500']) }}
                        @if ($errors->get('members'))
                            <div class="invalid-feedback">
                                {{ $errors->first('members') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::text('instagram', null, ['class' => 'form-control ' . ($errors->get('instagram') ?  'is-invalid' : ''), 'placeholder' => 'Instagram Handle']) }}
                        @if ($errors->get('instagram'))
                            <div class="invalid-feedback">
                                {{ $errors->first('instagram') }}
                            </div>
                        @endif
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Sign Up</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="block-container" id="ambassador-meet">
        <div class="container">
            <h2>Meet part of the FAM</h2>
            <hr/>
            <div class="row">
                <div class="col-lg-4">
                    <img src="{{ static_asset('images/ambassador/nina_romans.gif') }}"/>
                    <h3>Nina Romans</h3>
                    <p>“I am basically doing what I have always done, talking to my friends and other students about a company that I love. I am so happy I found them and glad to see how happy all the
                        chapters are too!”</p>
                    <div class="ambassador-meet-footer">
                        <p class="smaller">Kappa Kappa Gamma - UCLA</p>
                        <small>Ambassador Since ‘16</small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="{{ static_asset('images/ambassador/pedro_escobar.gif') }}"/>
                    <h3>Pedro Escobar</h3>
                    <p>“The greatest aspect of being a Campus Ambassador is getting to see people wearing the apparel that has gone through my dashboard, as it brings about an internal satisfaction
                        and pride that I had never experienced before.”</p>
                    <div class="ambassador-meet-footer">
                        <p class="smaller">Delta Phi - University of Virginia</p>
                        <small>Ambassador Since ‘16</small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="{{ static_asset('images/ambassador/quinn_heinrich.gif') }}"/>
                    <h3>Quinn Heinrich</h3>
                    <p>“One of the amazing things about working as a Campus Ambassador at Greek House is that I am able to work around my busy schedule. The easy-to-use dashboard and the endless
                        resources set you up for success.”</p>
                    <div class="ambassador-meet-footer">
                        <p class="smaller">Delta Gamma - Loyola Marymount University</p>
                        <small>Ambassador Since ‘16</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="ambassador-work">
        <div class="container">
            <h2>A few places our Campus Ambassadors have gone on to work</h2>
            <div class="ambassador-work-section">
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ static_asset('images/ambassador/amazon.gif') }}"/>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ static_asset('images/ambassador/salesforce.gif') }}"/>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ static_asset('images/ambassador/merrill_lynch.gif') }}"/>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ static_asset('images/ambassador/bacardi.gif') }}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section ('javascript')
    @if ($errors->any() || Session::get('success'))
        <script>
            GHScroll.scroll('#ambassador-form')
        </script>
    @endif
@append