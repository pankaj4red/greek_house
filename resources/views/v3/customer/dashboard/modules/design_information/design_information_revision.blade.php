@extends('v3.layouts.campaign')

@section('title', 'Make Changes')

@section('content_campaign')
    @component('v3.partials.slider.proof_slider', ['campaign' => $campaign])
    @endcomponent

    {{ Form::open() }}
    <div class="form-group required">
        <label>List your changes bellow</label>
        {{ Form::textarea('revision_text', $campaign->artwork_request->revision_text, ['class' => 'form-control', 'placeholder' => '1. Please add notes/changes need in a numbered list.
2. Please try to keep your notes concise.
3. Please refrain from adding unnecessary information.', 'required']) }}
    </div>
    <div class="form-group">
        @include ('v3.partials.filepicker', ['class' => 'file-block', 'url' => '', 'filename' => '', 'id' => 0, 'fieldName' => 'image', 'type' => 'image'])
        @include ('v3.partials.filepicker', ['class' => 'file-block', 'url' => '', 'filename' => '', 'id' => 0, 'fieldName' => 'image2', 'type' => 'image'])
        @include ('v3.partials.filepicker', ['class' => 'file-block', 'url' => '', 'filename' => '', 'id' => 0, 'fieldName' => 'image3', 'type' => 'image'])
    </div>
    <div class="mt-3 text-right">
        <a href="{{ $back }}" class="btn btn-default btn-back">Back</a>
        <button type="submit" class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Submit</button>
    </div>
    {{ Form::close() }}
@endsection
