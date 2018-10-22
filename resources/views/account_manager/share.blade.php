@extends ('customer')

@section ('title', 'Campus Manager - Share')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="page-header cancel-header-margin">
        <div class="container">
            <span class="pull-left page-title">Campus Manager - Share</span>
            <div class="pull-right new-order">
                <a role="button" href="{{ route('account_manager::accounts') }}" class="btn btn-default add-new-btn"
                   id="account-manager-accounts">
                    <span>Accounts</span>
                </a>
            </div>
            <div class="pull-right new-order">
                <a role="button" href="{{ route('account_manager::share') }}" class="btn btn-default add-new-btn"
                   id="account-manager-share">
                    <span>Share</span></a>
            </div>
        </div>
    </div>
    <div class="container">
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="title">
                    <h4>Link to register Customers</h4>
                </div>
                <p class="form-control-static width80">
                    <label for="referral" class="sr-only">Sign up</label>
                    <input type="text" class="form-control" id="referral" value="{{ route('signup_customer::step1', [Auth::user()->id]) }}"/>
                </p>
                <script type="text/javascript">
                    var addthis_config =
                    {
                        services_expanded: 'facebook,email,link',
                        data_track_clickback: false
                    }
                </script>
                <div class="social-icons addthis_toolbox social-icons-inline"
                     addthis:url="{{  route('signup_customer::step1', [Auth::user()->id]) }}"
                     addthis:description="Register with Greek House!" addthis:title="Greek House">
                    <a href="javascript:void(0)" class="social-thumb addthis_button_facebook at300b"
                       title="Facebook"><span class="v-align-wrapper"><span class="v-align"><img
                                        src="{{ static_asset('images/icon-social-1.png') }}"
                                        alt="icon-social"></span></span></a>
                    <a href="javascript:void(0)" class="social-thumb addthis_button_link at300b"
                       title="{{ route('signup_customer::step1', [Auth::user()->id]) }}"><span
                                class="v-align-wrapper"><span class="v-align"><img
                                        src="{{ static_asset('images/link.png') }}" alt="icon-social"></span></span></a>
                    <div class="atclear"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="title">
                    <h4>Link to register Campus Ambassador</h4>
                </div>
                <p class="form-control-static width80">
                    <label for="referral_campus" class="sr-only">Sign up</label>
                    <input type="text" class="form-control" id="referral_campus" value="{{ route('work_with_us::index', ['campus', Auth::user()->id]) }}"/>
                </p>
                <div class="social-icons addthis_toolbox social-icons-inline"
                     addthis:url="{{  route('work_with_us::index', ['campus', Auth::user()->id]) }}"
                     addthis:description="Register with Greek House!" addthis:title="Greek House">
                    <a href="javascript:void(0)" class="social-thumb addthis_button_facebook at300b"
                       title="Facebook"><span class="v-align-wrapper"><span class="v-align"><img
                                        src="{{ static_asset('images/icon-social-1.png') }}"
                                        alt="icon-social"></span></span></a>
                    <a href="javascript:void(0)" class="social-thumb addthis_button_link at300b"
                       title="{{ route('work_with_us::index', ['campus', Auth::user()->id]) }}"><span
                                class="v-align-wrapper"><span class="v-align"><img
                                        src="{{ static_asset('images/link.png') }}" alt="icon-social"></span></span></a>
                    <div class="atclear"></div>
                </div>
            </div>
        </div>
    </div>
    <?php register_js('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5416f2ad4d856633') ?>
@endsection