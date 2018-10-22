@extends('v3.layouts.app')

@section('title', $user->chapter ? $user->chapter . ' Store': 'Greek House Custom Store')

@section('content')
    <div class="color-slate">
        <div class="content-block drawn-map-background pt-120px pb-120px">
            <div class="container">
                <h1 class="h1 title-blue">{{ $user->school }} - {{ $user->chapter }}</h1>
                <p class="font-lg mw-700px m-center">Shop products created by this organization below. Orders ship 7-10 business days after Campaign Link Closes.</p>
            </div>
        </div>
        <div class="content-block v-padding-60">
            <div class="container">
                <h2 class="h3 title-blue">Your Organization's Products</h2>
                <div class="row mt-5">
                    @foreach ($campaigns as $campaign)
                        @foreach ($campaign->product_colors as $productColor)
                            @if ($campaign->artwork_request->getProofsFromProductColor($productColor->id)->count() > 0)
                                <div class="col-12 col-sm-6 col-md-4">
                                    <a href="{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name), $productColor->id]) }}" class="text-no-underline">
                                        <img class="d-block w-100"
                                             src="{{ route('system::image', [$campaign->artwork_request->getProofsFromProductColor($productColor->id)->first()->file_id]) }}"/>
                                        <p class="mt-3 mb-0 sub-title">{{ $campaign->name }}</p>
                                        <p class="mt-0 mb-4 color-blue">{{ money($campaign->quotes->where('product_id', $productColor->product_id)->first()->quote_high * 1.07) }}</p>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
        <div class="content-block v-padding-60">
            <div class="container">
                <h2 class="h3 title-blue">Get Featured</h2>
                <p>Tag @mygreekhouse to get featured</p>
                <div class="mt-5 no-text">
                    <img src="{{ static_asset('images/store/landing/1-2.jpg') }}" class="wh-240px"/>
                    <img src="{{ static_asset('images/store/landing/2-2.jpg') }}" class="wh-240px"/>
                    <img src="{{ static_asset('images/store/landing/3-2.jpg') }}" class="wh-240px"/>
                    <img src="{{ static_asset('images/store/landing/4-2.jpg') }}" class="wh-240px"/>
                    <img src="{{ static_asset('images/store/landing/5-2.jpg') }}" class="wh-240px"/>
                    <img src="{{ static_asset('images/store/landing/6-2.jpg') }}" class="wh-240px"/>
                    <img src="{{ static_asset('images/store/landing/7-2.jpg') }}" class="wh-240px"/>
                    <img src="{{ static_asset('images/store/landing/8-2.jpg') }}" class="wh-240px"/>
                </div>
            </div>
        </div>
        <div class="content-block v-padding-60">
            <div class="container">
                <h2 class="h3 title-blue">Get Involved</h2>
                <div class="row mt-5">
                    <div class="col-12 col-lg-4">
                        <a href="http://go.greekhouse.org/merch" target="_blank" class="text-no-underline">
                            <div style="background-image: url({{ static_asset('/images/store/landing/merch_team_2.jpg') }})" class="image-background w-100 pb-260px image-hover-effect" title="Join Our Merch Team"></div>
                            <p class="h5 sub-title mt-3">Join Our Merch Team</p>
                            <p class="color-slate">Submit ideas for products and designs</p>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="http://go.greekhouse.org/influencer" target="_blank" class="text-no-underline">
                            <div style="background-image: url({{ static_asset('/images/store/landing/influencer_2.jpg') }})" class="image-background w-100 pb-260px image-hover-effect" title="Join Our Merch Team"></div>
                            <p class="h5 sub-title mt-3">Become an Influencer</p>
                            <p class="color-slate">Get early access to products to post on Social Media</p>
                        </a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="{{ route('campus_manager::index') }}" target="_blank" class="text-no-underline">
                            <div style="background-image: url({{ static_asset('/images/store/landing/ambassador_2.jpg') }})" class="image-background w-100 pb-260px image-hover-effect" title="Join Our Merch Team"></div>
                            <p class="h5 sub-title mt-3">Become an Campus Rep</p>
                            <p class="color-slate">Be the face of Greek House on your campus</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('v3.partials.expanded_footer')
@endsection
