@extends('v2.layouts.app')

@section('title', 'OAuth for HubSpot')

@section('content')
    <div class="container">
        @if ($error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endif
        <form method="get" action="{{ App\Services\HubSpot::getOAuthURi(route('oauth::hubspot')) }}">
            <input type="hidden" name="client_id" value="{{ config('services.hubspot.api.client_id') }}"/>
            <input type="hidden" name="redirect_uri" value="{{ route('oauth::hubspot') }}"/>
            <input type="hidden" name="scope" value="{{ implode(' ',  App\Services\HubSpot::getScopes()) }}"/>

            <div class="form-group text-center mt-5">
                <button type="submit" class="btn btn-blue">Request OAuth Token</button>
            </div>
        </form>
    </div>
@endsection
