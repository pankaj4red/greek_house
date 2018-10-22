@extends('v2.layouts.app')

@section('title', 'OAuth for HubSpot')

@section('content')
    <div class="container">
        <div class="alert alert-success">{{ $refreshToken }}</div>
    </div>
@endsection
