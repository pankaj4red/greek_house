<div class="container">
    <div class="row no-gutters">
        <div class="col-12">
            <div class="products_items {{ $class }}">
                @foreach ($campaigns as $campaign)
                    @foreach (product_color_products($campaign->product_colors) as $product)
                        @if ($campaign->artwork_request->getProofsFromProductColor($product->campaign_colors->first()->id)->count() > 0)
                            <a href="{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name), $product->id]) }}" class="product__item">
                                <div class="product__image"
                                     style="background-image: url({{ route('system::image', [$campaign->artwork_request->getProofsFromProductColor($product->campaign_colors->first()->id)->first()->file_id]) }})"></div>
                                <div class="product__name">{{ $campaign->name }}</div>
                                <div class="product__price">{{ money($campaign->quotes->where('product_id', $product->id)->first()->quote_high * 1.07) }}</div>
                            </a>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>