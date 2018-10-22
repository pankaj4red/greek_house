@extends('v2.layouts.app')

@section('title', 'Campus Manager')

@section('content')
    <div class="block-container" id="campus-manager-form-application">
        <div class="container">
            <h1>Campus Manager Application 2/2</h1>
            {{ Form::open(['method' => 'POST']) }}
            <div class="row justify-content-md-center">
                <div class="col-md-8 text-left">
                    @include ('v2.partials.messages.all', ['except' => ['name', 'email', 'phone', 'school', 'chapter', 'position', 'members', 'instagram']])
                    <div class="form-group">
                        <label>1. What year in college are you? (drop down)</label>
                        {{ Form::select('year', school_year_options(['' => 'Year in College']), null, ['class' => 'form-control select-placeholder color-filled ' . ($errors->get('year') ?  'is-invalid' : ''), 'data-placeholder' => '400', 'data-selected' => '500', 'data-color-filled' => '#ffffff']) }}
                        @if ($errors->get('year'))
                            <div class="invalid-feedback">
                                {{ $errors->first('year') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>2. What's your major?</label>
                        {{ Form::text('major', null, ['class' => 'form-control color-filled ' . ($errors->get('major') ?  'is-invalid' : ''), 'placeholder' => 'Major', 'data-color-filled' => '#ffffff']) }}
                        @if ($errors->get('major'))
                            <div class="invalid-feedback">
                                {{ $errors->first('major') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>3. Are you involved on campus and/or involved in your fraternity/sorority? Do you hold any exec positions? Please list all relevant positions. (short answer)</label>
                        {{ Form::text('positions', null, ['class' => 'form-control color-filled ' . ($errors->get('involved') ?  'is-invalid' : ''), 'placeholder' => 'Relevant Positions', 'data-color-filled' => '#ffffff']) }}
                        @if ($errors->get('positions'))
                            <div class="invalid-feedback">
                                {{ $errors->first('positions') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>4. Why do you think you'd be a good fit for the role? (short answer - max 500 characters)</label>
                        {{ Form::textarea('description', null, ['class' => 'form-control color-filled ' . ($errors->get('description') ?  'is-invalid' : ''), 'placeholder' => '', 'data-color-filled' => '#ffffff']) }}
                        @if ($errors->get('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>5. What are the top 5 top brands/people/Instagram accounts you follow?</label>
                        {{ Form::text('top_brands', null, ['class' => 'form-control color-filled ' . ($errors->get('top_brands') ?  'is-invalid' : ''), 'placeholder' => '', 'data-color-filled ' => '#ffffff']) }}
                        @if ($errors->get('top_brands'))
                            <div class="invalid-feedback">
                                {{ $errors->first('top_brands') }}
                            </div>
                        @endif
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
