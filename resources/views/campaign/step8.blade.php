@extends ('customer')

@section ('title', 'Order - Step 8')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (config('services.crazy_egg.enabled'))
        <script type="text/javascript">
            setTimeout(function(){var a=document.createElement("script");
                var b=document.getElementsByTagName("script")[0];
                a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0050/4238.js?"+Math.floor(new Date().getTime()/3600000);
                a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
        </script>
    @endif
    <div class="container">
        @include ('partials.progress')
        <div class="form-header">
            <h1><i class="icon icon-info"></i><span class="icon-text">Tell us where to send your order</span></h1>
            <hr/>
        </div>
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        {!! Form::model($model, ['id' => 'form']) !!}
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default panel-box">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon icon-tshirt"></i><span
                                    class="icon-text">{{ $product->name }}</span></h3>
                        <p class="pull-right style-number">Style Number: <strong>{{ $product->style_number }}</strong>
                        </p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address_id">Choose From Previous Addresses</label>
                                    {!! Form::select('address_id', $addressOptions, null, ['class' => 'form-control', 'id' => 'address']) !!}
                                </div>
                                <div class="form-group" id="save-address">
                                    {!! Form::checkbox('address_save', 'yes', null, []) !!}
                                    <label for="address_save">save this address</label>
                                </div>
                                <div class="form-group">
                                    <label for="address_name">Name this address<i class="required">*</i></label>
                                    {!! Form::text('address_name', null, ['class' => 'form-control address-field', 'placeholder' => 'Address Name', 'data-address' => 'name', 'id' => 'address_name']) !!}
                                </div>
                                @if (config('services.google_places.enabled'))
                                    <div class="form-group">
                                        <label for="address_address">Search Address</label>
                                        {!! Form::text('address_search', null, ['class' => 'form-control', 'id' => 'autocomplete', 'placeholder' => 'Enter your address', 'onFocus' => 'geolocate()']) !!}
                                    </div>
                                    @include ('partials.enable_address')
                                @endif
                                <div class="form-group">
                                    <label for="address_line1">Address Line 1<i class="required">*</i></label>
                                    {!! Form::text('address_line1', old('address_line1'), ['class' => 'form-control address-field', 'placeholder' => 'Line 1', 'data-address' => 'line1', 'id' => 'route']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="address_line2">Address Line 2</label>
                                    {!! Form::text('address_line2', old('address_line2'), ['class' => 'form-control address-field', 'placeholder' => 'Line 2', 'data-address' => 'line2', 'id' => 'street_number']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="address_city">City<i class="required">*</i></label>
                                    {!! Form::text('address_city', null, ['class' => 'form-control address-field', 'placeholder' => 'City', 'data-address' => 'city', 'id' => 'locality']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="address_state">State<i class="required">*</i></label>
                                    {!! Form::text('address_state', null, ['class' => 'form-control address-field', 'placeholder' => 'State', 'data-address' => 'state', 'id' => 'administrative_area_level_1']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="address_zip_code">Zip Code<i class="required">*</i></label>
                                    {!! Form::text('address_zip_code', null, ['class' => 'form-control address-field', 'placeholder' => 'Zip Code', 'data-address' => 'zip_code', 'id' => 'postal_code']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="address_country">Country<i class="required">*</i></label>
                                    {!! Form::select('address_country', country_options(), null, ['class' => 'form-control address-field', 'data-address' => 'country', 'id' => 'country']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="action-row">
            <a href="{{ route('campaign::step7') }}" class="btn btn-default">Back</a>
            <button type="submit" name="next" value="next" class="btn btn-primary">Next</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section ('javascript')
    <script>
        var addressList = JSON.parse("{!! slashes(json_encode($addresses)) !!}");
        $('#address').change(function () {
            refreshAddresses(true)
        });
        refreshAddresses(false);
        function refreshAddresses(empty) {
            if ($('#address').val() !== '') {
                $('.address-field').each(function () {
                    $(this).prop('readonly', true);
                    var address = {};
                    for (var i = 0; i < addressList.length; i++) {
                        if (addressList[i].id === parseInt($('#address').val())) {
                            $('#address_name').val(addressList[i].name);
                            $('#route').val(addressList[i].line1);
                            $('#street_number').val(addressList[i].line2);
                            $('#locality').val(addressList[i].city);
                            $('#administrative_area_level_1').val(addressList[i].state);
                            $('#postal_code').val(addressList[i].zip_code);
                            $('#country').val(addressList[i].country);
                        }
                    }
                    $('#save-address').hide();
                });
            } else {
                $('.address-field').each(function () {
                    $(this).prop('readonly', false);
                });
                if (empty) {
                    $('#address_name').val('');
                    $('#street_number').val('');
                    $('#route').val('');
                    $('#locality').val('');
                    $('#administrative_area_level_1').val('');
                    $('#postal_code').val('');
                    $('#country').val('');
                }
                $('#save-address').show();
            }
        }
    </script>
@append