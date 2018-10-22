@extends ('customer')

@section ('title', 'Referrals')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('metadata')
    <meta property="og:url"
          value="{{ route('work_with_us::index', ['sales', Auth::user()->id]) }}"/>
    <meta property="og:type" value="website"/>
    <meta property="og:title" value="Sign up to be a House Rep and get paid | Greek House"/>
    <meta property="og:site_name" value="Greek House"/>
    <meta property="og:description"
          value="Greek House is a T-shirt platform built specifically for Greek T-shirt Chairs. Click {{ route('work_with_us::index', ['sales', Auth::user()->id]) }} to sign up to be a House Rep and get paid for what you already do. If you go through with an order, we both get $50!"/>
    <meta property="og:image" value="{{ static_asset('images/home.png') }}"/>
    <meta name="p:domain_verify" content="205e0c139cd6a5d2093567a56916f331"/>
@append

@section ('content')
    <section class="ref-chair cancel-header-margin">
        <div class="container">
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            <p class="work_header"><img src="{{ static_asset('images/greek-white.png') }}" alt="Greek House"/></p>
            <h2>Refer a <strong>T-Shirt chair</strong> and earn <span>$50</span> <strong>$100</strong> <br/> for
                everyone referred before November 18th </h2>
        </div>
    </section>
    <script type="text/javascript">
        var addthis_config =
        {
            services_expanded: 'facebook,email,link',
            data_track_clickback: false
        }
    </script>
    <section class="how_work text-center">
        <div class="container">
            <h2>How Does It Work?</h2>
            <ul>
                <li>
                    <div class="numeric1 yellow-color">1</div>
                    <i><img src="{{ static_asset('images/ref_link_ico.png') }}" alt=""/></i>
                    <span>Grab Your Personal<br/> Referral Link<br/> From Your Profile Tab</span>
                </li>
                <li>
                    <div class="numeric1 blue-color">2</div>
                    <i><img src="{{ static_asset('images/share_ico.png') }}" alt=""/></i>
                    <span>Email, Text, or Share It With <br/>Friends on Facebook</span>
                </li>
                <li>
                    <div class="numeric1 green-color">3</div>
                    <i><img src="{{ static_asset('images/success_order_ico.png') }}" alt=""/></i>
                    <span>You Get Paid $100 and <br/>They Get Paid $50 + 6.5% of <br/>TheirFirst Successful Order"</span>
                </li>
            </ul>
        </div>
    </section>
    <section class="share_this text-center">
        <div class="container">
            <div class="share_links">
                <label for="referral-text">Share This</label>
                <textarea readonly id="referral-text">“Greek House is a T-shirt platform built specifically for Greek T-shirt Chairs. Click {{ route('work_with_us::index', ['sales', Auth::user()->id]) }} to sign up to be a House Rep and get paid for what you already do. If you go through with an order, we both get $50!”</textarea>
                <a href="javascript:void(0)" class="addthis_button"
                   addthis:url="{{ route('work_with_us::index', ['sales', Auth::user()->id]) }}"
                   addthis:description="Greek House is a T-shirt platform built specifically for Greek T-shirt Chairs. Click {{ route('work_with_us::index', ['sales', Auth::user()->id]) }} to sign up to be a House Rep and get paid for what you already do. If you go through with an order, we both get $50!"
                   addthis:title="Sign up to be a House Rep and get paid | Greek House">Share</a>
            </div>
        </div>
    </section>
    <section class="who_refer text-center">
        <div class="container">
            <h3>Who Should You Refer? </h3>
            <div class="share-link">
                <div class="group-input">
                    <label for="referral-value" class="sr-only">Referral</label>
                    <input type="text" id="referral-value" value="{{ route('work_with_us::index', ['sales', Auth::user()->id]) }}"
                           data-clipboard-action="copy" data-clipboard-target="#bar" id="clipboard-field"/>
                    <span class="cursor-hover"><img src="{{ static_asset('images/cursor_ico.png') }}" alt=""/></span>
                </div>
                <span><img src="{{ static_asset('images/friends_ico.png') }}" alt=""/></span>
            </div>
            <p>Send Your Referral Link to Friends in other chapters who are in charge of <br/> ordering custom apparel.
                This is usually the T-Shirt or Apparel Chair.</p>
        </div>
    </section>
    <section class="faq_sec">
        <div class="container">
            <div class="faq_title">
                <h1>FREQUENTLY ASKED QUESTIONS</h1>
                <div class="clear"></div>
                <span><img src="{{ static_asset('images/ques_ico.png') }}" alt=""/></span>
            </div>
            <ul>
                <li>
                    <label>Do I Have To Be A T-shirt Chair or Apparel Chair?</label>
                    <p>You need to have the authority to place and manage apparel orders for your chapter.
                        This is typically the T-Shirt or Apparel Chair in some cases it is other
                        positions.</p>
                </li>
                <li>
                    <label>What is A Successful Campaign?</label>
                    <p>A successful campaign is one that meets the minimum estimated quantity and has a
                        total value of at least $1,500.</p>
                </li>
                <li>
                    <label>What Happens If I Don’t Have A Successful Campaign?</label>
                    <p>As long as your campaign meets the order minimum we will still process it and pay you
                        commission. The total campaign value must exceed $1,500 in order to receive the
                        additional $50. However if it does not meet the minimum quantity we cannot process
                        the order and you will not get paid.</p>
                </li>
                <li>
                    <label>What Is A Welcome Call?</label>
                    <p>We like to welcome everyone to Greek House, give a brief background on the company,
                        go over the House Rep position, then answer any questions you may have. It’s a quick
                        call between 5-10 minutes.</p>
                </li>
            </ul>
        </div>
    </section>
    <section class="book-member book-member_new">
        <div class="container">
            <h5>SOO... Are You Ready To Start Referring Your Friends?</h5>
            <a href="javascript:void(0)" class="addthis_button"
               addthis:url="{{ route('work_with_us::index', ['sales', Auth::user()->id]) }}"
               addthis:description="Greek House is a T-shirt platform built specifically for Greek T-shirt Chairs. Click {{ route('work_with_us::index', ['sales', Auth::user()->id]) }} to sign up to be a House Rep and get paid for what you already do. If you go through with an order, we both get $50!"
               addthis:title="Sign up to be a House Rep and get paid | Greek House">
                <i><img src="{{ static_asset('images/next_ico.png') }}"></i>Take Me To My Personal Referral Link<i><img
                            src="{{ static_asset('images/pre_ico.png') }}"></i>
            </a>
        </div>
    </section>
    <?php register_js('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5416f2ad4d856633') ?>

    @include ('partials.expanded_footer')
@endsection

@section ('include')
    <?php register_css(static_asset('fonts/stylesheet.css')) ?>
    <?php register_css(static_asset('css/bootstrap-select.min.css')) ?>
    <?php register_js(static_asset('js/bootstrap-select.js')) ?>
@append

@section ('javascript')
    <script>
        $(document).ready(function () {
            $('#clipboard-field').click(function() {
                $('#clipboard-field').focus();
                $('#clipboard-field').get(0).setSelectionRange(0, $('#clipboard-field').val().length);
                document.execCommand("copy");
            });
        });
    </script>
@append
