@extends ('customer')

@section ('title', 'Referrals')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="container">
        <div class="form-header">
            <h1><span class="icon-text">Greek House Referrals</span></h1>
            <hr/>
        </div>
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        {!! Form::open([]) !!}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default panel-minimalistic-box">
                    <div class="panel-body border-grey">
                        <div class="panel-body-content">
                            <div class="panel-content">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="name">Referral Name (First & Last)</label>
                                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="email">Referral Email</label>
                                        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone">Referral Phone Number</label>
                                        {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="school">Referral College</label>
                                        {!! Form::text('school', null, ['class' => 'form-control school', 'placeholder' => 'School']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="chapter">Referral Fraternity/Sorority Name</label>
                                        {!! Form::text('chapter', null, ['class' => 'form-control chapter', 'placeholder' => 'Fraternity or Sorority']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="chapter_position">Referral Position in Chapter</label>
                                        {!! Form::select('chapter_position', $chapterOptions, null, ['class' => 'selectpicker', 'placeholder' => 'Position in Chapter']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="member_count">Referral Number of Members</label>
                                        {!! Form::select('member_count', $memberCountOptions, null, ['class' => 'selectpicker', 'placeholder' => 'Number of Members']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="chapter_position">Referred By</label>
                                        {!! Form::text('referred_by', null, ['class' => 'form-control', 'placeholder' => 'Referred By']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="action-row">
            <button type="submit" name="save" value="save" class="btn btn-primary">Submit</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section ('include')
    @include ('partials.enable_school_chapter')
    <?php register_css(static_asset('css/bootstrap-select.min.css')) ?>
    <?php register_js(static_asset('js/bootstrap-select.js')) ?>
@append

@section ('javascript')
    <script>
        schoolAndChapter('.school', '.chapter');
    </script>
@append