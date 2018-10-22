@extends('v3.layouts.campaign')

@section('title', 'Shipping Types')

@section('content_campaign')
    {{ Form::open() }}
    <div class="form-group">
        <label class="form-checkbox">
            Group Shipping
            {{ Form::checkbox('shipping_group', 1, $campaign->shipping_group, ['class' => '', 'placeholder' => 'Group Shipping']) }}
            <span></span>
        </label>
    </div>
    <div class="form-group">
        <label class="form-checkbox">
            Individual Shipping
            {{ Form::checkbox('shipping_individual', 1, $campaign->shipping_individual, ['class' => '', 'placeholder' => 'Individual Shipping']) }}
            <span></span>
        </label>
    </div>
    <div class="text-right">
        <a href="{{ $back }}" class="btn btn-default btn-back">Back</a>
        <button type="submit" class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Submit</button>
    </div>
    {{ Form::close() }}
@endsection
