<div class="panel panel-default panel-minimalistic">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-tshirt"></i><span class="icon-text">Products</span></h3>
    </div>
    <div class="panel-body">
        @foreach (product_color_products($campaign->product_colors) as $product)
            <div class="colored-list margin-bottom-30">
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
                        <h5 class="colored-item-title">
                        @foreach ($product->campaign_colors as $color)
                            {{ $color->name }}{{ ! $loop->last ? ',' : '' }}
                        @endforeach
                        </h5>
                        <p class="colored-item-text">Colors</p>
                    </div>
                </div>
                @foreach ($campaign->quotes as $quote)
                    @if ($quote->product_id == $product->id)
                        <div class="colored-item blue">
                            <div class="colored-item-information">
                                <h5 class="colored-item-title">{{ quote_range($quote->quote_low * 1.07, $quote->quote_high * 1.07, $quote->quote_final * 1.07) }}</h5>
                                <p class="colored-item-text">Quote</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
</div>