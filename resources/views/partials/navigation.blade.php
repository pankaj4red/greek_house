<header id="gh-header">
    <div class="container">
        <nav class="navbar navbar-default">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home::index') }}">
                @include ('v2.partials.logo')
                <span> Greek House</span>
            </a>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="nav navbar-nav ml-auto">
                    @guest
                        <li class="nav-item {{ Request::is('/')?'active':'' }}">
                            <a class="nav-link" href="{{ route('home::index') }}">Home {!! Request::is('/')?'<span class="sr-only">(current)</span>':'' !!}</a>
                        </li>
                        <li class="nav-item dropdown {{ (Request::is('work-with-us') || Request::is('campus_manager'))?'active':'' }}">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Join Our House {!! Request::is('work-with-us')?'<span class="sr-only">(current)</span>':'' !!}</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('work_with_us::index') }}">AS A MEMBER</a>
                                <a class="dropdown-item" href="{{ route('campus_manager::index') }}">AS A CAMPUS MANAGER</a>
                            </div>
                        </li>
                        <li class="nav-item {{ Request::is('design-gallery')?'active':'' }}">
                            <a class="nav-link" href="{{ route('home::design_gallery') }}">Designs {!! Request::is('design-gallery')?'<span class="sr-only">(current)</span>':'' !!}</a>
                        </li>
                        <li class="nav-item {{ Request::is('about-us')?'active':'' }}">
                            <a class="nav-link" href="{{ route('home::about_us') }}">About {!! Request::is('about-us')?'<span class="sr-only">(current)</span>':'' !!}</a>
                        </li>
                        <li class="nav-item {{ Request::is('login')?'active':'' }}">
                            <a class="nav-link fancybox" href="{{ route('login') }}" data-toggle="modal" data-target="#gh-modal" data-modal-width="585px" data-modal-height="405px">
                                Login {!! Request::is('login')?'<span class="sr-only">(current)</span>':'' !!}
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('wizard*')?'active':'' }}">
                            <a class="btn btn-green-transparent" href="{{ route('wizard::start') }}">Start Here {!! Request::is('wizard*')?'<span class="sr-only">(current)</span>':'' !!}</a>
                        </li>
                        <li class="nav-item {{ Request::is('/store/cart/')?'active':'' }}">
                            <a class="nav-link navbar-cart" href="{{ route('custom_store::cart') }}">
                                <div class="navbar-cart-counter">0</div>
                                @if (!isset($print) || $print == false)
                                    <img src="/images/store/icons/store_cart.svg"> {!! Request::is('/')?'<span class="sr-only">(current)</span>':'' !!}
                                @endif
                            </a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item {{ Request::is('wizard*')?'active':'' }}">
                            <a class="nav-link" href="{{ route('wizard::start') }}">Start Here {!! Request::is('wizard*')?'<span class="sr-only">(current)</span>':'' !!}</a>
                        </li>
                        <li class="nav-item {{ Request::is('design-gallery')?'active':'' }}">
                            <a class="nav-link" href="{{ route('home::design_gallery') }}">Designs {!! Request::is('design-gallery')?'<span class="sr-only">(current)</span>':'' !!}</a>
                        </li>
                        <li class="nav-item {{ Request::is('dashboard*')?'active':'' }}">
                            <a class="nav-link" href="{{ route('dashboard::index') }}">Dashboard {!! Request::is('dashboard*')?'<span class="sr-only">(current)</span>':'' !!}</a>
                        </li>
                        <li class="nav-item {{ Request::is('custom-store')?'active':'' }}">
                            <a class="nav-link" href="{{ route('custom_store::campaigns', [Auth::user()->id]) }}">My Store {!! Request::is('/')?'<span class="sr-only">(current)</span>':'' !!}</a>
                        </li>
                        @if (Auth::user()->isType(['account_manager']))
                            <li class="nav-item {{ Request::is('account_manager')?'active':'' }}">
                                <a class="nav-link" href="{{ route('account_manager::accounts') }}">Manager {!! Request::is('account_manager')?'<span class="sr-only">(current)</span>':'' !!}</a>
                            </li>
                        @endif
                        @if (Auth::user()->isType(['art_director', 'admin']))
                            <li class="nav-item {{ Request::is('art_director')?'active':'' }}">
                                <a class="nav-link" href="{{ route('art_director::index') }}">Art Director {!! Request::is('art_director')?'<span class="sr-only">(current)</span>':'' !!}</a>
                            </li>
                        @endif
                        <li class="nav-item {{ Request::is('profile')?'active':'' }}">
                            <a class="nav-link" href="{{ route('profile::index') }}">Profile {!! Request::is('profile')?'<span class="sr-only">(current)</span>':'' !!}</a>
                        </li>
                        @if (Auth::user()->isType(['admin', 'product_qa', 'product_manager', 'support']))
                            <li class="nav-item {{ Request::is('wizard*')?'active':'' }}">
                                <a class="nav-link" href="{{ route('admin::index') }}">Admin {!! Request::is('wizard*')?'<span class="sr-only">(current)</span>':'' !!}</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <div class="navbar-user-entry">
                                <img src="{{ Auth::user()->getAvatar() }}"/>
                                <div class="navbar-user-information">
                                    <p class="navbar-username">{{ Auth::user()->getFullName(true) }}</p>
                                    {{ Form::open(['url' => route('logout')]) }}
                                    <button type="submit" class="btn-logout">Logout</button>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </li>
                        <li class="nav-item {{ Request::is('/store/cart/')?'active':'' }}">
                            <a class="nav-link navbar-cart" href="{{ route('custom_store::cart') }}">
                                <div class="navbar-cart-counter">0</div>
                                @if (!isset($print) || $print == false)
                                    <img src="/images/store/icons/store_cart.svg"> {!! Request::is('/')?'<span class="sr-only">(current)</span>':'' !!}
                                @endif
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
</header>
