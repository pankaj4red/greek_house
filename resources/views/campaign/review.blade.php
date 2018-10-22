@extends ('customer')

@section ('title', 'Order - Review')

@section ('content')
    @if (config('services.crazy_egg.enabled'))
        <script type="text/javascript">
            setTimeout(function () {
                var a = document.createElement("script");
                var b = document.getElementsByTagName("script")[0];
                a.src = document.location.protocol + "//script.crazyegg.com/pages/scripts/0050/4238.js?" + Math.floor(new Date().getTime() / 3600000);
                a.async = true;
                a.type = "text/javascript";
                b.parentNode.insertBefore(a, b)
            }, 1);
        </script>
    @endif
    <div class="container">
        @include ('partials.progress')
        <div class="form-header">
            <h1><i class="icon icon-info"></i><span class="icon-text">Review Your Campaign</span></h1>
            <hr/>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default panel-minimalistic">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon icon-tshirt"></i><span
                                    class="icon-text">Garment Info</span></h3>
                        <a href="{{ route('campaign::step1') }}" class="profile-edit order-detail-page">EDIT</a>
                    </div>
                    <div class="panel-body">
                        <div class="colored-list">
                            <div class="colored-item blue">
                                <div class="colored-item-information">
                                    <h5 class="colored-item-title">{{ $product->name }}</h5>
                                    <p class="colored-item-text">Garment Name</p>
                                </div>
                            </div>
                            <div class="colored-item red">
                                <div class="colored-item-information">
                                    <h5 class="colored-item-title">{{ $product->category->name }}</h5>
                                    <p class="colored-item-text">Garment Style</p>
                                </div>
                            </div>
                            <div class="colored-item green">
                                <div class="colored-item-information">
                                    <h5 class="colored-item-title">{{ $product->style_number }}</h5>
                                    <p class="colored-item-text">Style Number</p>
                                </div>
                            </div>
                            <div class="colored-item orange">
                                <div class="colored-item-information">
                                    <h5 class="colored-item-title">{{ $color->name }}</h5>
                                    <p class="colored-item-text">Color</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default panel-minimalistic">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon icon-user"></i><span
                                    class="icon-text">Customer Info</span></h3>
                        <a href="{{ route('campaign::step7') }}" class="profile-edit order-detail-page">EDIT</a>
                    </div>
                    <div class="panel-body">
                        <div class="customer-information">
                            <div class="customer-name">{{ getFullName($model->contact_first_name, $model->contact_last_name, $model->contact_email) }}</div>
                            <div class="customer-chapter">{{ $model->contact_chapter }}</div>
                            <div class="customer-email">
                                <img src="{{ static_asset('images/icon-mail-2.png') }}"/>
                                {{ $model->contact_email }}
                            </div>
                            <div class="customer-phone">
                                <img src="{{ static_asset('images/icon-phone.png') }}"/>
                                {{ $model->contact_phone }}
                            </div>
                        </div>
                        <div class="customer-free-size">
                            <span class="customer-free-size-key pull-left">Budget</span>
                            <div class="customer-free-size-value pull-right">
                                <span>On a budget:</span> {{ $model->budget == 'yes' ? budget_caption($model->budget_range) : 'No' }}</div>
                        </div>
                        @if ($size)
                            <div class="customer-free-size">
                                <span class="customer-free-size-key pull-left">Free T-shirt</span>
                                <div class="customer-free-size-value pull-right">
                                    <span>Size:</span> {{ $size->size->name }}</div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel panel-default panel-minimalistic">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon icon-van"></i><span
                                    class="icon-text">Shipping Info</span></h3>
                        <a href="{{ route('campaign::step8') }}" class="profile-edit order-detail-page">EDIT</a>
                    </div>
                    <div class="panel-body">
                        <div class="shipping-information">
                            <div class="shipping-information-title">Address</div>
                            <div class="shipping-information-text">
                                {{ $model->address_line1 }}
                                @if (isset($model->address_line2))
                                    <br/>
                                    {{ $model->address_line2 }}
                                @endif
                            </div>
                            <div class="shipping-information-title">City</div>
                            <div class="shipping-information-text">{{ $model->address_city }}</div>
                            <div class="shipping-information-title">State</div>
                            <div class="shipping-information-text">{{ $model->address_state }}</div>
                            <div class="shipping-information-title">Zip Code</div>
                            <div class="shipping-information-text">{{ $model->address_zip_code }}</div>
                            <div class="shipping-information-title">Country</div>
                            <div class="shipping-information-text">{{ country_name($model->address_country) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default panel-minimalistic">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon icon-tshirt"></i><span
                                    class="icon-text">Order Quantity: {{ $model->estimated_quantity }}</span></h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <img src="{{ route('system::image', [$color->image_id]) }}" class="width-100"/>
                        </p>
                    </div>
                </div>
                <div class="panel panel-default panel-minimalistic">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon icon-shield"></i><span class="icon-text">Uploaded Reference Images</span>
                        </h3>
                        <a href="{{ route('campaign::step5') }}" class="profile-edit order-detail-page">EDIT</a>
                    </div>
                    <div class="panel-body">
                        @if (isset($design1Id))
                            <p>
                                <img src="{{ route('system::image', [$design1Id]) }}" class="width-100"/>
                            </p>
                        @endif
                        @if (isset($design2Id))
                            <p>
                                <img src="{{ route('system::image', [$design2Id]) }}" class="width-100"/>
                            </p>
                        @endif
                        @if (isset($design3Id))
                            <p>
                                <img src="{{ route('system::image', [$design3Id]) }}" class="width-100"/>
                            </p>
                        @endif
                        @if (!isset($design1Id) && !isset($design2Id) && !isset($design3Id))
                            <p>No designs were provided for this order</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {!! Form::open() !!}
        <div class="row {{  $model['flexible'] == 'yes' ? '' : 'hidden-override' }}">
            <div class="col-md-12">
                <div class="panel panel-default panel-box">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon icon-info"></i><span
                                    class="icon-text">Terms & Conditions</span></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group-checkbox">
                                    <label>
                                        {!! Form::checkbox('agree', 'yes', null) !!} I have read and agree to
                                        the <a href="{{ route('signup_account_manager::tos') }}" class="ajax-popup">Terms
                                            & Conditions.</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="action-row">
            <a href="{{ route('campaign::step8') }}" class="btn btn-default">Back</a>
            <button type="submit" id="submit-flexible" class="btn btn-primary i-agree {{ $model['flexible'] == 'yes' ? '' : 'hidden-override' }}">Submit Design Request</button>
            <button type="button" id="submit-date" name="next" value="next" href="#flexible-no-popup"
                    class="btn btn-primary next-flexible-no {{ $model['flexible'] != 'yes' ? '' : 'hidden-override' }}">
                Submit Design Request
            </button>
        </div>
        {!! Form::close() !!}
        <div id="flexible-no-popup" style="display: none">
            <div class="form-header margin-top">
                <h1><i class="icon icon-info"></i><span class="icon-text">Finalize Order Form</span></h1>
                <hr>
            </div>
            <p>Based on your Delivery Date you will need to meet the following deadlines in order to receive your order
                on time:</p>
            <ul>
                <li>Finalize the Design - <strong class="date-design">{{ date('m/d/Y', strtotime($bd12)) }}</strong>
                </li>
                <li>Submit Sizes & Payment - <strong class="date-payment">{{ date('m/d/Y', strtotime($bd10)) }}</strong>
                    by 2 PM Eastern
                </li>
            </ul>
            <br/>
            <p>By clicking ‘Agree’, you agree with the following:</p>
            <ul>
                <li>You agree to our <a href="{{ route('home::tos') }}" target="_blank">Terms and Conditions</a>.</li>
                <li class='i-agree-rush {{ $model['rush'] == true ? '' : 'hidden-override' }}'>I accept Rush
                    Shipping Fees.
                </li>
            </ul>
            <br/>
            <div class="action-row">
                {!! Form::open() !!}
                <button type="submit"
                        class="btn btn-primary i-agree i-agree-rush {{ $model['rush'] == true ? '' : 'hidden-override' }}">
                    I agree and accept Rush Shipping Fees
                </button>
                <button type="submit"
                        class="btn btn-primary i-agree i-agree-not-rush {{ $model['rush'] == false ? '' : 'hidden-override' }}">
                    I agree
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection


@section ('javascript')
    <script>
        $('.i-agree').click(function () {
            $('.next').click();
        });
    </script>
    <script>
        $('.next-flexible-no').fancybox({
            maxWidth: 800,
            maxHeight: 600,
            fitToView: false,
            width: '70%',
            height: 'auto',
            autoSize: true,
            closeClick: false,
            openEffect: 'none',
            closeEffect: 'none'
        });
        $('.next-flexible-yes').fancybox({
            maxWidth: 800,
            maxHeight: 600,
            fitToView: false,
            width: '70%',
            height: 'auto',
            autoSize: true,
            closeClick: false,
            openEffect: 'none',
            closeEffect: 'none'
        });
    </script>

    <script type="text/javascript">
        $(".ajax-popup").click(function (event) {
            event.preventDefault();
            $.fancybox({
                padding: 20,
                margin: 0,
                width: $(this).attr('data-width') ? $(this).attr('data-width') : '900px',
                height: 'auto',
                autoSize: false,
                href: $(this).attr('href'),
                type: 'ajax',
                scrolling: 'auto'
            });
            return false;
        });
    </script>
@append