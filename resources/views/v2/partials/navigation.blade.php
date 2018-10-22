<header id="gh-header">
    <div class="container">
        <nav class="navbar navbar-light navbar-expand-lg">
            <a class="navbar-brand" href="{{ route('home::index') }}">
                @include ('v2.partials.logo')
                <span> Greek House</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="nav navbar-nav ml-auto">
                    @guest
                    <li class="nav-item {{ Request::is('/')?'active':'' }}">
                        <a class="nav-link" href="{{ route('home::index') }}" title="Home">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Join Our House {!! Request::is('work-with-us') || Request::is('campus_manager')?'<span class="sr-only">(current)</span>':'' !!}</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('work_with_us::index') }}">AS A MEMBER</a>
                            <a class="dropdown-item" href="{{ route('campus_manager::index') }}">AS A CAMPUS MANAGER</a>
                        </div>
                    </li>
                    <li class="nav-item {{ Request::is('design-gallery')?'active':'' }}">
                        <a class="nav-link" href="{{ route('home::design_gallery') }}" title="Designs">Designs</a>
                    </li>
                    <li class="nav-item {{ Request::is('about-us')?'active':'' }}">
                        <a class="nav-link" href="{{ route('home::about_us') }}" title="About">About</a>
                    </li>
                    <li class="nav-item {{ Request::is('login')?'active':'' }}">
                        <a class="nav-link" href="{{ route('login') }}" data-toggle="modal" data-target="#gh-modal" data-modal-width="285px" data-modal-height="185px">
                            Login {!! Request::is('login')?'<span class="sr-only">(current)</span>':'' !!}
                        </a>
                    </li>
                    <li class="nav-item {{ Request::is('wizard*')?'active':'' }}">
                        <a class="btn btn-green-transparent-square" href="{{ route('wizard::start') }}" title="Start Here">Start Here</a>
                    </li>
                    <li class="nav-item {{ Request::is('/store/cart/')?'active':'' }}">
                        <a class="nav-link navbar-cart" href="{{ route('custom_store::cart') }}">
                            <div class="navbar-cart-counter">{{ get_cart_counter() }}</div>
                            <img src="/images/store/icons/store_cart.svg"> {!! Request::is('/')?'<span class="sr-only">(current)</span>':'' !!}
                        </a>
                    </li>
                    @endguest
                    @auth
                        <li class="nav-item {{ Request::is('wizard*')?'active':'' }}">
                            <a class="nav-link" href="{{ route('wizard::start') }}" title="Start Here">Start Here</a>
                        </li>
                        <li class="nav-item {{ Request::is('design-gallery')?'active':'' }}">
                            <a class="nav-link" href="{{ route('home::design_gallery') }}" title="Designs">Designs</a>
                        </li>
                        <li class="nav-item {{ Request::is('custom-store')?'active':'' }}">
                            <a class="nav-link" href="{{ route('custom_store::campaigns', [Auth::user()->id]) }}">My Store {!! Request::is('/')?'<span class="sr-only">(current)</span>':'' !!}</a>
                        </li>
                        <li class="nav-item {{ Request::is('dashboard*')?'active':'' }}">
                            <a class="nav-link" href="{{ route('dashboard::index') }}" title="Dashboard">Dashboard</a>
                        </li>
                        @if (Auth::user()->isType(['account_manager']))
                            <li class="nav-item {{ Request::is('account_manager')?'active':'' }}">
                                <a class="nav-link" href="{{ route('account_manager::accounts') }}" title="Manager">Manager</a>
                            </li>
                        @endif
                        @if (Auth::user()->isType(['art_director', 'admin']))
                            <li class="nav-item {{ Request::is('art_director')?'active':'' }}">
                                <a class="nav-link" href="{{ route('art_director::index') }}" title="Art Director">Art Director</a>
                            </li>
                        @endif
                        <li class="nav-item {{ Request::is('profile')?'active':'' }}">
                            <a class="nav-link" href="{{ route('profile::index') }}" title="Profile">Profile</a>
                        </li>
                        @if (Auth::user()->isType(['admin', 'product_qa', 'product_manager', 'support']))
                            <li class="nav-item {{ Request::is('wizard*')?'active':'' }}">
                                <a class="nav-link" href="{{ route('admin::index') }}" title="Admin">Admin</a>
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
                                <div class="navbar-cart-counter">{{ get_cart_counter() }}</div>
                                <img src="/images/store/icons/store_cart.svg"> {!! Request::is('/')?'<span class="sr-only">(current)</span>':'' !!}
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
</header>
