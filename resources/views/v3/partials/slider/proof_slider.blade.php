<?php $products = product_color_products($campaign->product_colors) ?>
<?php $id = uniqid() ?>
<div class="row">
    <div class="col-12 col-md-8">
        @foreach ($products as $product)
            <div data-group-container-group="c{{ $id }}-product" data-group-container-value="{{ $product->id }}" {!! $loop->index != 0 ? 'style="display: none"' : '' !!}>
                @foreach ($product->campaign_colors as $color)
                    <div data-group-container-group="c{{ $id }}-product-{{ $color->product_id }}" data-group-container-value="{{ $color->id }}"
                            {!! $loop->index != 0 ? 'style="display: none"' : '' !!}>
                        <div class="carousel slide" data-interval="10000" data-ride="carousel" id="c{{ $id }}-carousel-{{ $product->id }}-{{ $color->id }}">
                            <div class="carousel-inner shadow">
                                @foreach ($campaign->artwork_request->getProofsFromProductColor($color->id) as $proof)
                                    <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}" data-slide-number="{{ $loop->index }}">
                                        <img class="w-100 image-effect" src="{{ route('system::image', [$proof->file_id]) }}"
                                             alt="{{ $product->name }} {{ $color->name }} {{ $loop->index + 1 }}"/>
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#c{{ $id }}-carousel-{{ $product->id }}-{{ $color->id }}" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#c{{ $id }}-carousel-{{ $product->id }}-{{ $color->id }}" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                            <ol class="carousel-indicators" role="listbox">
                                @foreach ($campaign->artwork_request->getProofsFromProductColor($color->id) as $proof)
                                    <li class="{{ $loop->index == 0 ? 'active' : '' }}" data-slide-to="{{ $loop->index }}" data-target="#c{{ $id }}-carousel-{{ $product->id }}-{{ $color->id }}">
                                        <img src="{{ route('system::image', [$proof->file_id]) }}"/>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    <div class="col-12 col-md-4">
        <div class="mb-3">
            <div class="text-xl font-weight-semi-bold mb-3 color-slate">Products</div>
            @foreach ($products as $product)
                <button class="btn btn-sm w-100 overflow-ellipsis btn-slate {{ $loop->index == 0 ? 'active' : '' }} mb-3" data-group-trigger-group="c{{ $id }}-product"
                        data-group-trigger-value="{{ $product->id }}">{{ $product->name }}</button>
            @endforeach
        </div>
        <div>
            <div class="text-xl font-weight-semi-bold mb-3 color-slate">Colors</div>
            @foreach ($products as $product)
                <div class="mb-3" data-group-container-group="c{{ $id }}-product" data-group-container-value="{{ $product->id }}" {!! $loop->index != 0 ? 'style="display: none"' : '' !!}>
                    @foreach ($product->campaign_colors as $productColor)
                        <button class="btn btn-round-background {{ $loop->index == 0 ? 'active' : '' }}" data-group-trigger-group="c{{ $id }}-product-{{ $product->id }}"
                                data-group-trigger-value="{{ $productColor->id }}" style="background: transparent url({{ route('system::image', [$productColor->thumbnail_id]) }})"
                                title="{{ $productColor->name }}"></button>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
@if ($slot)
    <div class="row">
        <div class="col-12 text-center">
            {{ $slot }}
        </div>
    </div>
@endif
