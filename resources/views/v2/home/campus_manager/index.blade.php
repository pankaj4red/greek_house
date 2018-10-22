@extends('v2.layouts.app')

@section('title', 'Campus Manager')

@section('content')
    <div class="block-container" id="campus-manager-program">
        <div class="container">
            <h1>Campus Manager Program</h1>
            <p>Campus Managers are the backbone of our company. Become the face of Greek House at your campus and help change the way Greeks make custom apparel. Make money, get professional
                experience, and build up your resume with one of the nation’s fastest growing startups.</p>
            <a href="{{ route('campus_manager::index') }}#campus-manager-form" class="btn btn-blue slide-scroll" data-slide-scroll="#campus-manager-form" data-slide-focus="#form-full-name">Join The
                Team</a>
        </div>
    </div>
    <div class="block-container" id="campus-manager-join-team">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ static_asset('images/campus-manager/platform-mobile.png') }}"/>
                </div>
                <div class="col-md-8">
                    <h2>Hundreds of Campuses,<br/>Thousands of Shirts,<br/>Millions of Memories.</h2>
                    <p>Greek House is the easiest way for Fraternities and Sororities to get custom apparel with awesome designs, no mistakes and the fastest turnaround in the industry.</p>
                    <p>Want the best job on campus?</p>
                    <a href="{{ route('campus_manager::index') }}#campus-manager-form" class="btn btn-white-transparent slide-scroll" data-slide-scroll="#campus-manager-form" data-slide-focus="#form-full-name">Join
                        The
                        Team</a>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="campus-manager-why">
        <div class="container">
            <div class="campus-manager-why-section">
                <h2>Why become a Greek House Campus Manager?</h2>
                <hr/>
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/campus-manager/get_paid.gif') }}"/>
                        <h3>Get Paid</h3>
                        <p>Our Campus Managers on average make $5,000 per semester, and our best ones make upwards of $15,000.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/campus-manager/professional_experience.gif') }}"/>
                        <h3>Professional Experience</h3>
                        <p>Develop Sales and Marketing skills that help you stand out and get a job once you graduate.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/campus-manager/flexible_schedule.gif') }}"/>
                        <h3>Flexible Schedule</h3>
                        <p>Typically, our Campus Managers work 5-10 hours per week on their own time.</p>
                    </div>
                </div>
            </div>
            <div class="campus-manager-why-section">
                <h2>What you do</h2>
                <hr/>
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/campus-manager/collect_contacts.gif') }}"/>
                        <h3>Collect Contacts</h3>
                        <p>Work with our Executive Team to find decision makers of Sororities, Fraternities, and Student Orgs on Campus.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/campus-manager/reach_out.gif') }}"/>
                        <h3>Reach Out</h3>
                        <p>Use the same tactics from companies like Amazon, Salesforce, and Google to get sales.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/campus-manager/network.gif') }}"/>
                        <h3>Network</h3>
                        <p>Connect with Campus Manager not only at your campus, but all over the country</p>
                    </div>
                </div>
            </div>
            <div class="campus-manager-why-section">
                <h2>Who we are looking for</h2>
                <hr/>
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/campus-manager/exec_members.gif') }}"/>
                        <h3>Exec Members</h3>
                        <p>If you've ever held a position in your organization, you know what it takes to be a leader. Your experience will help ensure your success.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/campus-manager/well_connected.gif') }}"/>
                        <h3>Well Connected</h3>
                        <p>We are looking for individuals who are social, outgoing and fun!</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/campus-manager/self_starters.gif') }}"/>
                        <h3>Self Starters</h3>
                        <p>As a Campus Manager, you will be the face of Greek House on campus. Make us proud by being awesome and self motivated.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="campus-manager-form">
        <div class="container">
            <h2>Apply to become a Greek House Campus Manager Today!</h2>
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
                        <button type="submit" class="btn btn-success">Apply</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="block-container" id="campus-manager-meet">
        <div class="container">
            <h2>Meet part of the FAM</h2>
            <hr/>
            <div class="row">
                <div class="col-lg-4">
                    <img src="{{ static_asset('images/campus-manager/nina_romans.gif') }}"/>
                    <h3>Nina Romans</h3>
                    <p>“I am basically doing what I have always done, talking to my friends and other students about a company that I love. I am so happy I found them and glad to see how happy all the
                        chapters are too!”</p>
                    <div class="campus-manager-meet-footer">
                        <p class="smaller">Kappa Kappa Gamma - UCLA</p>
                        <small>Campus Manager Since ‘16</small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="{{ static_asset('images/campus-manager/pedro_escobar.gif') }}"/>
                    <h3>Pedro Escobar</h3>
                    <p>“The greatest aspect of being a Campus Manager is getting to see people wearing the apparel that has gone through my dashboard, as it brings about an internal satisfaction
                        and pride that I had never experienced before.”</p>
                    <div class="campus-manager-meet-footer">
                        <p class="smaller">Delta Phi - University of Virginia</p>
                        <small>Campus Manager Since ‘16</small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="{{ static_asset('images/campus-manager/quinn_heinrich.gif') }}"/>
                    <h3>Quinn Heinrich</h3>
                    <p>“One of the amazing things about working as a Campus Manager at Greek House is that I am able to work around my busy schedule. The easy-to-use dashboard and the endless
                        resources set you up for success.”</p>
                    <div class="campus-manager-meet-footer">
                        <p class="smaller">Delta Gamma - Loyola Marymount University</p>
                        <small>Campus Manager Since ‘16</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="campus-manager-work">
        <div class="container">
            <h2>A few places our Campus Managers have gone on to work</h2>
            <div class="campus-manager-work-section">
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ static_asset('images/campus-manager/amazon.gif') }}"/>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ static_asset('images/campus-manager/salesforce.gif') }}"/>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ static_asset('images/campus-manager/merrill_lynch.gif') }}"/>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ static_asset('images/campus-manager/bacardi.gif') }}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section ('javascript')
    @if ($errors->any() || Session::get('success'))
        <script>
            GHScroll.scroll('#campus-manager-form')
        </script>
    @endif
@append