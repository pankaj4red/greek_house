@extends('v2.layouts.app')

@section('title', 'Home')

@section('content')
    @include('v2.partials.messages.all')
    <div class="block-container" id="homepage-header">
        <div class="homepage-foreground">
            <h1>The Most Advanced Greek Apparel Company, Ever.</h1>
            <p class="upper">Get a Free, Professional Design Your Chapter Will Love Back Within 24 Hours.</p>
            <div class="row">
                <div class="col">
                    <a class="btn btn-blue mb-4 btn-large" href="{{ route('home::design_gallery') }}">View Designs</a>
                    <p>Start with one of ours.<br/>Everything is 100% customizable</p>
                </div>
                <div class="or-separator">
                    <hr/>
                    Or
                    <hr/>
                </div>
                <div class="col">
                    <a class="btn btn-blue mb-4 btn-large" href="{{ route('wizard::start') }}">Create Design</a>
                    <p>Have our designers bring your<br/> idea to life</p>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="homepage-how-it-works">
        <div class="container">
            <h2>How it works</h2>
            <hr/>
            <div class="row" id="homepage-how-it-works-content">
                <div class="col-12 col-md-4 pull-left mt-5 mb-5">
                    <div class="numbered-container">
                        <div class="numbered-image">
                            <div class="numbered-image-number">
                                <span>1</span>
                            </div>
                            <img src="{{ asset('images/homepage/step-1.png') }}">
                        </div>
                        <h3 class="text-subtitle">Pick a Product</h3>
                    </div>
                </div>
                <div class="col-12 col-md-4 pull-left mt-5 mb-5">
                    <div class="numbered-container">
                        <div class="numbered-image">
                            <div class="numbered-image-number">
                                <span>2</span>
                            </div>
                            <img src="{{ asset('images/homepage/step-2.png') }}">
                        </div>
                        <h3 class="text-subtitle">Tell A Designer What You Want</h3>
                    </div>
                </div>
                <div class="col-12 col-md-4 pull-left mt-5 mb-5">
                    <div class="numbered-container">
                        <div class="numbered-image">
                            <div class="numbered-image-number">
                                <span>3</span>
                            </div>
                            <img src="{{ asset('images/homepage/step-3.png') }}">
                        </div>
                        <h3 class="text-subtitle">Receive a Design Within 24 Hours</h3>
                    </div>
                </div>
                <div class="col-12 col-md-4 pull-right mt-5 mb-5">
                    <div class="numbered-container">
                        <div class="numbered-image">
                            <div class="numbered-image-number">
                                <span>4</span>
                            </div>
                            <img src="{{ asset('images/homepage/step-4.png') }}">
                        </div>
                        <h3 class="text-subtitle">Easy Individual & Group Payments</h3>
                    </div>
                </div>
                <div class="col-12 col-md-4 pull-right mt-5 mb-5">
                    <div class="numbered-container">
                        <div class="numbered-image">
                            <div class="numbered-image-number">
                                <span>5</span>
                            </div>
                            <img src="{{ asset('images/homepage/step-5.png') }}">
                        </div>
                        <h3 class="text-subtitle">Receive Your Order Quickly</h3>
                    </div>
                </div>
                <div class="col-12 col-md-4 pull-right mt-5 mb-5">
                    <div class="numbered-container">
                        <div class="numbered-image">
                            <div class="numbered-image-number">
                                <span>6</span>
                            </div>
                            <img src="{{ asset('images/homepage/step-6.png') }}">
                        </div>
                        <h3 class="text-subtitle">Look Great</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="homepage-platform">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>The Platform</h2>
                    <hr/>
                    <p>Easily control the entire order process from start to finish in one place. Get exactly what your chapter wants in less time.</p>
                    <ul>
                        <li>Live chat</li>
                        <li>Instant quotes</li>
                        <li>Real time order updates</li>
                        <li>Collaborate directly with designers</li>
                        <li>5000+ Designs that can be customized</li>
                        <li>Text updates</li>
                    </ul>
                </div>
                <div class="offset-md-1 col-md-4">
                    <img src="{{ asset('images/ambassador/platform-mobile.png') }}"/>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="homepage-membership">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('images/membership/member-greek.png') }}"/>
                </div>
                <div class="col-md-6 text-left">
                    <h2>Membership</h2>
                    <hr/>
                    <p>Ask about our exclusive membership program for T-shirt Chairs, Apparel Chairs, and other awesome people who are dedicated to getting their organization shirts they’ll love.
                        Membership is free and packed with benefits for qualified candidates.</p>
                    <a href="/membership" class="btn btn-white-black">Learn More</a>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="homepage-custom-designs">
        <div class="container">
            <h2>The Community</h2>
            <hr/>
            <p class="mb-5">See what members are saying about Greek House</p>
            <div class="gallery gallery-small">
                @forelse ($designs->chunk(4) as $chunk)
                    <div class="gallery-row">
                        @foreach ($chunk as $design)
                            <div class="gallery-item">
                                <div class="gallery-item-inner">
                                    <a href="{{ route('system::image', [get_image_id($design->enabled_images->first()->file_id, true)]) }}"
                                       title="{{ $design->name }}" class="gallery-entry colorbox">
                                        <img src="{{ route('system::image', [get_image_id($design->getThumbnail(),true)]) }}"
                                             alt="#"/>
                                    </a>
                                    <div class="gallery-caption">
                                        {{ $design->name }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <p class="text-center">No designs available at this time.</p>
                @endforelse
            </div>
            <a href="{{ route('home::design_gallery') }}" class="btn btn-info">Access Design Vault</a>
        </div>
    </div>
    <div class="block-container" id="homepage-community">
        <div class="container">
            <h2>The Community</h2>
            <p class="mb-5">See what members are saying about Greek House</p>

            <div class="row">
                <div class="col-lg-4">
                    <img src="{{ asset('images/work-with-us/kiera.jpg') }}"/>
                    <h3>Nina Romans</h3>
                    <p>“I love that the shirts are bagged and tagged, it's always super easy to hand out. The customer service always responds super fast, and overall it's a really easy and fast
                        process.”</p>
                    <div class="homepage-community">
                        <p class="smaller">Delta Gamma - UF</p>
                        <small>Ambassador Since ‘14</small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="{{ asset('images/work-with-us/shyan.jpg') }}"/>
                    <h3>Pedro Escobar</h3>
                    <p>“This is the best t-shirt company we've ever worked with, period.”</p>
                    <div class="homepage-community">
                        <p class="smaller">Alpha Tau Omega - UF</p>
                        <small>Ambassador Since ‘13</small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="{{ asset('images/work-with-us/sarah.jpg') }}"/>
                    <h3>Quinn Heinrich</h3>
                    <p>“Ya'll have made it so easy for me to communicate to designers and share proofs. It has taken so much stress off of my job!”</p>
                    <div class="homepage-community">
                        <p class="smaller">Kappa Kappa Gamma - UT</p>
                        <small>Ambassador Since ‘15</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="homepage-blog">
        <div class="container">
            <h2>Blog</h2>
            <hr/>
            <p>See what others are saying about Greek House</p>
            <div class="blog-container">
                <div class="blog-half background-darkgray">
                    <figure><img src="https://static.greekhouse.org/images/homepage/blog_pic3_1.png" alt="Blog Pic"></figure>
                    <div>
                        <h3 class="text-title">Taking Advantage of the Push for […]</h3>
                        <span>2 weeks ago</span>
                        <p>When Jack Chang invested in an apparel business in 1988, a good number of California labels were still making their clothes in California. Then the North American Free Trade
                            Agreement came along in 1994, and many of those clothing labels—particularly California surfwear—headed south of the border to Mexico, where apparel production costs were
                            lower
                            and […]</p>
                    </div>
                </div>
                <div class="blog-half background-blue">
                    <div>
                        <h3 class="text-title">Spring T-shirt Trends</h3>
                        <span>2 weeks ago</span>
                        <p>The motto for forecasting T-shirt trends for teenagers and young women might as well be “Here today, gone tomorrow,” said Barbara Fields, president of the Barbara Fields
                            Buying
                            Office in Los Angeles. She’s been in the forecasting game for three decades now. […]</p>
                    </div>
                    <figure><img src="https://static.greekhouse.org/images/homepage/blog_pic4_1.png" alt="Blog Pic"></figure>
                </div>
                <div class="double-margin-top">
                    <a href="http://blog.greekhouse.org" class="btn btn-white-black mt-4">View Blog</a>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="homepage-timeline">
        <div class="container">
            <h2>Timeline</h2>
            <hr/>
            <div class="timeline-now">
                <h3>now</h3>
            </div>
            <ul class="timeline">
                <li>
                    <div class="timeline-badge"><i><img src="{{ asset('images/homepage/chat_ico.png') }}"></i>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">September 2016 </h4>
                        </div>
                    </div>
                    <div class="timeline-panel panel-rht pull-right">
                        <div class="timeline-heading">
                            <h5>Introduced Intelligent Pricing and Live Chat</h5>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-badge"><i><img src="{{ asset('images/homepage/wide-ico.png') }}"></i>
                    </div>
                    <div class="timeline-panel pull-right">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">March 2016 </h4>
                        </div>
                    </div>
                    <div class="timeline-panel panel-rht pull-left">
                        <div class="timeline-heading">
                            <h5>Greek House Becomes Available Nation Wide</h5>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="timeline-badge"><i><img src="{{ asset('images/homepage/launch-ico.png') }}"></i>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">january 2016 </h4>
                        </div>
                    </div>
                    <div class="timeline-panel panel-rht pull-right">
                        <div class="timeline-heading">
                            <h5>Launched Campus Manager Program.</h5>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-badge"><i><img src="{{ asset('images/homepage/loc-ico.png') }}"></i>
                    </div>
                    <div class="timeline-panel pull-right">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">December 2015</h4>
                        </div>
                    </div>
                    <div class="timeline-panel panel-rht pull-left">
                        <div class="timeline-heading">
                            <h5>Team relocates to LA.</h5>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="timeline-badge"><i><img src="{{ asset('images/homepage/house-ico.png') }}"></i>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">january 2015</h4>
                        </div>
                    </div>
                    <div class="timeline-panel panel-rht pull-right">
                        <div class="timeline-heading">
                            <h5>Greek House becomes a thing.</h5>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-badge"><i><img src="{{ asset('images/homepage/chair-co.png') }}"></i>
                    </div>
                    <div class="timeline-panel pull-right">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">january 2014</h4>
                        </div>
                    </div>
                    <div class="timeline-panel panel-rht pull-left">
                        <div class="timeline-heading">
                            <h5>Karthik &amp; Luke Struggle As T-Shirt Chairs</h5>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    @include ('v2.partials.expanded_footer')
@endsection

@section ('javascript')

@append