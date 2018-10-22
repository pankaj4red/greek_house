@extends ('customer')

@section ('title', 'Profile')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="page-header cancel-header-margin">
        <div class="container">
            <span class="pull-left page-title">Profile</span>
            <div class="pull-right new-order">
                <a role="button" href="{{ route('profile::add_address') }}" class="btn btn-default add-new-btn"
                   id="add-order">
                    <span>New Address</span>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (Auth::user()->isType('customer') || Auth::user()->isType('sales_rep'))
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 left-sec user-shipping-info margin-bottom-30">
                            <h3 class="content-title gold-user icon-bfor">Referral Link</h3>
                            <div class="customer-information">
                                <p class="form-control-static width80">
                                    <label for="referral" class="sr-only">Referral</label>
                                    <input type="text" id="referral" class="form-control" value="{{ route('work_with_us::index', ['sales', Auth::user()->id]) }}"/>
                                </p>
                                <script type="text/javascript">
                                    var addthis_config =
                                    {
                                        services_expanded: 'facebook,email,link',
                                        data_track_clickback: false
                                    }
                                </script>
                                <div class="social-icons addthis_toolbox social-icons-inline"
                                     addthis:url="{{  route('work_with_us::index', ['sales', Auth::user()->id]) }}"
                                     addthis:description="Register with Greek House!" addthis:title="Greek House">
                                    <a href="javascript:void(0)" class="social-thumb addthis_button_facebook at300b"
                                       title="Facebook"><span class="v-align-wrapper"><span class="v-align"><img
                                                        src="{{ asset('images/icon-social-1.png') }}"
                                                        alt="icon-social"></span></span></a>
                                    <a href="javascript:void(0)" class="social-thumb addthis_button_link at300b"
                                       title="{{ route('work_with_us::index', ['sales', Auth::user()->id]) }}"><span
                                                class="v-align-wrapper"><span class="v-align"><img
                                                        src="{{ asset('images/link.png') }}"
                                                        alt="icon-social"></span></span></a>
                                    <div class="atclear"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php register_js('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5416f2ad4d856633') ?>
                @endif
                @if (Auth::user()->account_manager)
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 left-sec user-shipping-info margin-bottom-30">
                            <h3 class="content-title gold-user icon-bfor">Campus Manager</h3>
                            <div class="customer-information">
                                <img src="{{ Auth::user()->account_manager->getAvatarLarge()  }}"
                                     class="customer-information-avatar"/>
                                <div class="customer-information-inner">
                                    <div class="customer-name">{{ Auth::user()->account_manager->getFullName() }}</div>
                                    <div class="customer-chapter">{{ Auth::user()->account_manager->chapter }}</div>
                                    <div class="customer-email">
                                        <img src="{{ asset('images/icon-mail-2.png') }}"/>
                                        {{ Auth::user()->account_manager->email }}
                                    </div>
                                    <div class="customer-phone">
                                        <img src="{{ asset('images/icon-phone.png') }}"/>
                                        {{ get_phone(Auth::user()->account_manager->phone)?get_phone(Auth::user()->account_manager->phone):Auth::user()->account_manager->phone }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 left-sec user-shipping-info margin-bottom-30">
                        <h3 class="content-title gold-user icon-bfor">Profile</h3>
                        <div class="profile-container">
                            <div class="profile-left">
                                <a href="{{ route('profile::edit_information') }}" class="profile-edit">EDIT</a>
                                <div class="customer-information">
                                    <img src="{{ Auth::user()->getAvatarLarge()  }}"
                                         class="customer-information-avatar"/>
                                    <div class="customer-information-inner">
                                        <div class="customer-name">{{ Auth::user()->getFullName() }}</div>
                                        <div class="customer-chapter">{{ Auth::user()->chapter }}</div>
                                        <div class="customer-email">
                                            <img src="{{ asset('images/icon-mail-2.png') }}"/>
                                            {{ Auth::user()->email }}
                                        </div>
                                        <div class="customer-phone">
                                            <img src="{{ asset('images/icon-phone.png') }}"/>
                                            {{ get_phone(Auth::user()->phone)?get_phone(Auth::user()->phone):Auth::user()->phone }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-right">
                                <div class="place-an-order">
                                    @if (!Auth::user()->isType('decorator'))
                                        <div class="place-an-order-title">PLACE AN ORDER</div>
                                        <p>Place an order now and receieve a proof within 24 hours!</p>
                                        <a href="{{ route('wizard::start') }}" class="btn btn-primary">PLACE AN
                                            ORDER</a>
                                    @else
                                        {!! Form::open(['route' => ['profile::toggle_decorator_status'], 'id' => 'form']) !!}
                                        <div class="place-an-order-title">DECORATOR STATUS</div>
                                        @if (Auth::user()->decorator_status == 'ON')
                                            <p><i>Accepting Campaigns</i></p>
                                        @else
                                            <p><i>Not Accepting Campaigns</i></p>
                                        @endif
                                        <button type="submit" class="btn btn-primary">Toggle</button>
                                        {!! Form::close() !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 left-sec user-shipping-info">
                        <h3 class="content-title gold-dir icon-bfor">Addresses</h3>
                        @foreach (Auth::user()->addresses as $address)
                            <span class="address-sec">
                                <a href="{{ route('profile::edit_address', [$address->id]) }}"
                                   class="profile-edit">EDIT</a>
                                <h4>{{ $address->name }}</h4>
                                {{ $address->line1 . ($address->line2?(', ' . $address->line2):'') }}<br/>
                                {{ $address->city }}, {{ $address->zip_code }} {{ $address->state }}<br/>
                                {{ country_name($address->country) }}
                            </span>
                        @endforeach
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 right-sec user-shipping-info">
                        <h3 class="content-title blu-dir icon-bfor">Shipping Address</h3>
                        @if (Auth::user()->address)
                            <span class="address-sec">
                                <h4>{{ Auth::user()->address->name }}</h4>
                                {{ Auth::user()->address->line1 . (Auth::user()->address->line2?(', ' . Auth::user()->address->line2):'') }}<br/>
                                {{ Auth::user()->address->city }}, {{ Auth::user()->address->zip_code }} {{ Auth::user()->address->state }}<br/>
                                {{ country_name(Auth::user()->address->country) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection