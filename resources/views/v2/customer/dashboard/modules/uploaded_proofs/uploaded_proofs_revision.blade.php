@extends('v2.layouts.campaign')

@section('title', 'Make Changes')

@section('content_campaign')
    @component('v2.partials.slider.proof_slider', ['campaign' => $campaign])
    @endcomponent
    {{ Form::open() }}
    <div class="block-info-rounded">
        <div class="block-info__title">
            List your changes bellow
        </div>
        <div class="block-info__body">
            <div class="col col-12">
                <div class="form-group">
                    {{ Form::textarea('revision_text', $campaign->artwork_request->revision_text, ['class' => 'form-control', 'placeholder' => '1. Please add notes/changes need in a numbered list.
2. Please try to keep your notes concise.
3. Please refrain from adding unnecessary information.', 'id' => 'revision_text']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="form-group buttons">
        <a href="{{ $back }}" class="gh-btn grey-transparent btn-close">Back</a>
        <button type="submit" class="gh-btn blue"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Submit</button>
    </div>
    {{ Form::close() }}
@endsection
