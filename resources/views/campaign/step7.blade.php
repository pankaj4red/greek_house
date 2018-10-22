@extends ('customer')

@section ('title', 'Order - Step 7')

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
            <h1><i class="icon icon-info"></i><span class="icon-text">Contact Information</span></h1>
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
                                    <label for="contact_first_name">First Name<i class="required">*</i></label>
                                    {!! Form::text('contact_first_name', null, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name<i class="required">*</i></label>
                                    {!! Form::text('contact_last_name', null, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_email">Email<i class="required">*</i></label>
                                    {!! Form::text('contact_email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_phone">Phone (Format: (555) 555-5555)<i class="required">*</i></label>
                                    {!! Form::text('contact_phone', null, ['class' => 'form-control', 'placeholder' => 'Phone']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_school">School<i class="required">*</i></label>
                                    {!! Form::text('contact_school', null, ['class' => 'form-control school', 'placeholder' => 'School']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_chapter">Chapter or Organization Name<i class="required">*</i></label>
                                    {!! Form::text('contact_chapter', null, ['class' => 'form-control chapter', 'placeholder' => 'Chapter']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="promo_code">Enter Promo Code (if any)</label>
                                    {!! Form::text('promo_code', null, ['class' => 'form-control', 'placeholder' => 'Promo Code']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="action-row">
            <a href="{{ route('campaign::step6') }}" class="btn btn-default">Back</a>
            <button type="submit" name="next" value="next" class="btn btn-primary">Next</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section ('include')
    @include ('partials.enable_school_chapter')
@append

@section ('javascript')
    <script>
        schoolAndChapter('.school', '.chapter');
    </script>
@append