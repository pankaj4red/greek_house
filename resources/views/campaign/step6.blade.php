@extends ('customer')

@section ('title', 'Order - Step 6')

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
            <h1><i class="icon icon-info"></i><span class="icon-text">Tell Us When You Need It</span></h1>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p>Greek House delivers your order within 10 business days after sizes and payment
                                        have been collected.</p>
                                    <p>Rush Orders are available as soon as 6 Business Days after sizes and payment have
                                        been collected. Rush Shipping fees will apply.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::select('flexible', $flexibleOptions, null, ['class' => 'form-control', 'id' => 'flexible']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="flexible-yes {{ $model['flexible'] == 'yes' ? '' : 'hidden-override' }}">

                        </div>
                        <div class="flexible-no {{  $model['flexible'] == 'no' ? '' : 'hidden-override' }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">When would you ideally need this order delivered?<i
                                                    class="required">*</i></label>
                                        {!! Form::text('date', null, ['class' => 'form-control', 'placeholder' => 'Date', 'id' => 'date']) !!}
                                    </div>
                                    <p class="date-error red-text hidden-override">Oh no :(, we don’t think it’s feasible to get
                                        a design back to you and have it be turned around and meet the Rush Shipping
                                        deadline. Choose up more than 12 business days ahead of today’s date.</p>
                                    <p class="date-info hidden-override">It takes some time to finalize the design, collect the
                                        sizes and payment which could cause the Order to be Rushed. Do you accept Rush
                                        Shipping fees if they apply? <span class="tooltip"
                                                                           title="Rush Shipping Fees are charged to us by the deliver service and can vary starting at $100-200/order."></span>
                                    </p>
                                    <div class="date-rush
                                        @if (!($model['date'] && date('Y-m-d', strtotime($model['date'])) > date('Y-m-d', strtotime('+12d')) && date('Y-m-d', strtotime($model['date'])) <= date('Y-m-d', strtotime('+15d'))))
                                            hidden-override
                                        @endif
                                            ">
                                        <div class="form-group">
                                            {!! Form::select('rush', $rushOptions, null, ['class' => 'form-control', 'id' => 'rush']) !!}
                                        </div>
                                        <div class="rush-error red-text {{ $model['rush'] == 'no' ? '' : 'hidden-override' }}">
                                            Please input a later date where Rush Shipping Fees would not apply
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="action-row">
            <a href="{{ route('campaign::step5') }}" class="btn btn-default">Back</a>
            <button type="submit" name="next" value="next" class="btn btn-primary next">Next</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section ('javascript')
    <script>
        $(document).ready(function () {
            $('.tooltip').tooltipster({
                contentAsHTML: true,
                interactive: true
            });
        });
    </script>
    <script>
        function flexibleChanged() {
            $('.flexible-yes').addClass('hidden-override');
            $('.flexible-no').addClass('hidden-override');
            if ($('#flexible').val() === 'yes') {
                $('.flexible-yes').removeClass('hidden-override');

            }
            if ($('#flexible').val() === 'no') {
                $('.flexible-no').removeClass('hidden-override');
            }
            checkNext();
        }
        $('#flexible').change(flexibleChanged);
        $('#flexible').keydown(flexibleChanged);
        $('#flexible').click(flexibleChanged);
        function rushChanged() {
            $('.rush-yes').addClass('hidden-override');
            $('.rush-error').addClass('hidden-override');
            if ($('#rush').val() === 'yes') {
                $('.rush-yes').removeClass('hidden-override');
            }
            if ($('#rush').val() === 'no') {
                $('.rush-error').removeClass('hidden-override');
            }
            checkNext();
        }
        $('#rush').change(rushChanged);
        $('#rush').keydown(rushChanged);
        $('#rush').click(rushChanged);
    </script>
    <script>
        var bd10 = 0;
        var bd12 = 0;
        var bd12index = -1;
        var bd15 = 0;
        var bdcount = 0;
        var time = new Date().getTime();
        for (var i = 0; i < 30; i++) {
            if (new Date(time).getDay() >= 1 && new Date(time).getDay() <= 5) {
                bdcount++;
                if (bdcount === 10) {
                    bd10 = new Date(time);
                }
                if (bdcount === 12) {
                    bd12 = new Date(time);
                    bd12index = i;
                }
                if (bdcount === 15) {
                    bd15 = new Date(time);
                    break;
                }
            }
            time += 24 * 60 * 60 * 1000;
        }
        if (bd10 === 0 || bd12 === 0 || bd15 === 0) {
            // error
            console.log('Business day calculation failed');
        }
        $("#date").datepicker({
            inline: false,
            beforeShowDay: weekends,
            minDate: '+' + (bd12index + 1) + 'd',
            onSelect: dateSelected
        });
        $("#date").change(function () {
            var dateText = $('#date').val();
            if (dateText) {
                dateSelected(dateText);
            }
        });
        function weekends(date) {
            var day = date.getDay(), Sunday = 0, Saturday = 6;
            var closedDays = [[Saturday], [Sunday]];
            for (var i = 0; i < closedDays.length; i++) {
                if (day === closedDays[i][0]) {
                    return [false];
                }
            }
            return [true];
        }
        function dateSelected(dateText) {
            $('.date-error').addClass('hidden-override');
            $('.date-rush').addClass('hidden-override');
            $('.date-info').addClass('hidden-override');
            $('.date-ok').addClass('hidden-override');
            var date = toDate(new Date(dateText));
            var now = toDate(new Date());

            if (date < bd12) {
                $('.date-error').removeClass('hidden-override');
                checkNext();
                return;
            }
            if (date < bd15) {
                $('.date-rush').removeClass('hidden-override');
                $('.date-info').removeClass('hidden-override');
                checkNext();
                return;
            }
            $('.date-ok').removeClass('hidden-override');
            checkNext();
        }
        @if ($model['date'])
            dateSelected("{{ $model['date'] }}");
        @endif
        checkNext();
        function checkNext() {
            $('.next-flexible-no').addClass('hidden-override');
            $('.next-flexible-yes').addClass('hidden-override');
            $('.i-agree-rush').addClass('hidden-override');
            $('.i-agree-not-rush').addClass('hidden-override');
            if ($('#flexible').val() === 'yes') {
                $('.next-flexible-yes').removeClass('hidden-override');
                return;
            }
            if ($('#flexible').val() === 'no') {
                var dateText = $('#date').val();
                if (dateText) {
                    var date = toDate(new Date(dateText));
                    var now = toDate(new Date());
                    $('.date-design').text(toDateFormat(bd12));
                    $('.date-payment').text(toDateFormat(bd10));
                    if (date < bd12) {
                        return;
                    }
                    if (date < bd15) {
                        if ($('#rush').val() === 'yes') {
                            $('.i-agree-rush').removeClass('hidden-override');
                            $('.next-flexible-no').removeClass('hidden-override');
                        }
                        return;
                    }
                    $('.i-agree-not-rush').removeClass('hidden-override');
                    $('.next-flexible-no').removeClass('hidden-override');
                }
            }
        }
        function toDate(date) {
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            return new Date(month + '/' + day + '/' + year);
        }
        function toDateFormat(date) {
            return padLeft(date.getMonth() + 1) + "/" + padLeft(date.getDate()) + "/" + date.getFullYear();
        }
        function padLeft(text) {
            var str = "" + text;
            var pad = "00";
            return pad.substring(0, pad.length - str.length) + str
        }
    </script>
@append