<?php $sliderId = uniqid(); ?>
<div class="fotorama homepage-fotorama" id="{{ $sliderId }}" data-swipe="false" data-click="false" data-transition-duration="12000" data-width="100%" data-ratio="16/9" data-autoplay="true" data-arrows="always" >
 <div>
     <div class="block-container" id="homepage-header">
    <div class="homepage-foreground" id="first_slide">
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
   </div>

    @foreach($images as $image)
        <div>
            <a href="{{ add_url_scheme($image->url) }}" >
            <div class="homepage-slider" name="{{ add_url_scheme($image->url) }}" style="background:url({{ route('system::image', [$image->image]) }}) repeat center; background-size:cover ">

                {{Form::hidden('slider_height', '', ['id' => 'slider_height'])}}
            </div>
            </a>
        </div>
    @endforeach

</div>

@section ('include')
    <?php register_css(static_asset('css/fotorama.css')) ?>
    <?php register_js(static_asset('js/fotorama.js')) ?>
@append

@section ('javascript')
    <script src="{{ static_asset('js/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ static_asset('js/fotorama.js') }}"></script>
    <script type="text/javascript">

       $(document).ready(function(){
          $(function () {
            if($("#slider_height").val() == '') {
                var newHeight = parseInt($("#first_slide").height()) + parseInt($("#homepage-header").css('padding-top').replace('px', '')) + parseInt($("#homepage-header").css('padding-bottom').replace('px', ''));
                newHeight += parseInt($("#first_slide").css('padding-top').replace('px', ''));
                newHeight += parseInt($("#first_slide").css('padding-bottom').replace('px', ''));
                $("#slider_height").val(newHeight);
            }
            else{
                var newHeight = $("#slider_height").val();
            }


            var $fotoramaDiv = $('#{{$sliderId}}').fotorama({width:'100%', height: newHeight});
            var fotorama = $fotoramaDiv.data('fotorama');

              $('.fotorama').on('fotorama:startautoplay ' + 'fotorama:ready ' + 'fotorama:show ' + 'fotorama:load ', function () {
                  $(".homepage-slider").css('height', newHeight+"px");
                    fotorama.resize({
                        height: newHeight
                    });
                }).fotorama();

        });
        });
    </script>
    <link rel="stylesheet" href="{{ static_asset('css/fotorama.css') }}">
@append
