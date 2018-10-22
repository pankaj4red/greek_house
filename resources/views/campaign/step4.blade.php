@extends ('customer')

@section ('title', 'Order - Step 4')

@section ('content')
    @if (config('services.crazy_egg.enabled'))
        <script type="text/javascript">
            setTimeout(function(){var a=document.createElement("script");
                var b=document.getElementsByTagName("script")[0];
                a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0050/4238.js?"+Math.floor(new Date().getTime()/3600000);
                a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
        </script>
    @endif
    <img src="{{ static_asset('images/download.gif') }}" class="image-preload"/>
    <div class="container">
        @include ('partials.progress')
        <div class="form-header">
            <h1><i class="icon icon-tshirt"></i><span class="icon-text">Choose Color</span></h1>
            <hr/>
        </div>
        <form method="post" id="form">
            {!! csrf_field() !!}
            <div class="row margin-bottom">
                <div class="col-md-8">
                    <div class="panel panel-default panel-minimalistic">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon icon-tshirt"></i><span
                                        class="icon-text">{{ $product->name }}</span></h3>
                            <p class="pull-right style-number">Style Number:
                                <strong>{{ $product->style_number }}</strong></p>
                        </div>
                        <div class="panel-body">
                            <img src="{{ route('system::image', [$product->active_colors[0]->image_id]) }}"
                                 id="product-image" class="image-product-large width-70"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default panel-minimalistic">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon icon-info"></i><span class="icon-text">Garment Description</span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="box">
                                <p><strong>Description: </strong> {{ $product->description }}</p>
                                <p><strong>Sizes: </strong> {{ $product->sizes_text }}</p>
                                <p><strong>Features: </strong> {{ $product->features }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-minimalistic">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon icon-color"></i><span
                                        class="icon-text">Select Color</span></h3>
                        </div>
                        <div class="panel-body">
                            <div class="color-list">
                                @foreach ($product->active_colors as $productColor)
                                    <a href="#" class="color-selection" data-id="{{ $productColor['id'] }}"><img
                                                src="{{ route('system::image', [$productColor['thumbnail']['id']]) }}"
                                                title="{{ $productColor['name'] }}" class="image-color"/></a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="action-row">
                <input type="hidden" id="color-id" name="color-id" value="{{ $product->active_colors[0]->id }}"/>
                <a href="{{ route('campaign::step3', [$genderId, $categoryId]) }}" class="btn btn-default">Back</a>
                <button type="submit" name="next" value="next" class="btn btn-primary">Next</button>
            </div>
        </form>
    </div>
@endsection

@section ('include')
    <?php register_css(static_asset('css/atooltip.css')) ?>
    <?php register_js(static_asset('js/jquery.atooltip.min.js')) ?>
@append

@section ('javascript')
    <!--suppress JSCheckFunctionSignatures -->
    <script>
        $('.color-selection').click(function (event) {
            event.preventDefault();
            $('#product-image').attr('src', '/images/transparent.png');
            $.ajax('{{ route('campaign::ajax_image', ['']) }}/' + $(this).attr('data-id')).done(function (data) {
                $('#product-image').attr('src', '//{{ config('app.domain.content') }}/image/' + data.image + '.png');
                $('#color-id').val(data.id);
            });
            return false;
        });
    </script>
    <script>
        $('.color-selection img').aToolTip();
    </script>
@append