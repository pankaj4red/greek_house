@extends('v3.layouts.app2')

@section('title', 'Testing')

@section('content')
    @component('v3.partials.slider.proof_slider', ['campaign' => campaign_repository()->find(24)])
    @endcomponent
@endsection
