<div class="block-info-rounded block-proofs big-paddings">
    <div class="block-info__title">
        Uploaded Proofs
        <a href="javascript: void(0)" class="title__button block-toggle"></a>
    </div>
    <div class="block-info__body proofs__body">
        <div class="row proofs__carousel-info">
            <div class="col-md-8">
                <div class="proofs__carousels">
                    @foreach ($campaign->product_colors as $productColor)
                        @if ($campaign->getProductColorProofs($productColor->id)->count() > 0)
                            @if (! isset($activeProductColor))
                                <?php $activeProductColor = $productColor ?>
                                <?php $first = true; ?>
                            @endif
                            @include('v2.partials.slider.proof_slider_image', [
                                'active' => $activeProductColor->id == $productColor->id,
                                'productId' => $productColor->product_id,
                                'colorId' => $productColor->id,
                                'proofs' => $campaign->getProductColorProofs($productColor->id),
                                'name' => $productColor->product->name . ' - ' . $productColor->name,
                            ])
                        @endif
                        @if ($loop->index == 0 && $campaign->getProofs('generic')->count() > 0)
                            @if (! isset($activeProductColor))
                                <?php $activeProductColor = $productColor ?>
                                <?php $first = true; ?>
                            @endif
                            @include('v2.partials.slider.proof_slider_image', [
                                    'active' => $activeProductColor,
                                    'productId' => $campaign->product_colors->first()->product_id,
                                    'colorId' => $campaign->product_colors->first()->id,
                                    'proofs' => $campaign->getProofs('generic'),
                                    'name' => $activeProductColor->product->name,
                                ])
                        @endif
                    @endforeach
                    @if (! isset($activeProductColor))
                        <?php $activeProductColor = $campaign->product_colors->first() ?>
                        <?php $first = true; ?>
                    @else
                        <?php $first = false; ?>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="proofs__info">
                    <h3>Products</h3>
                    <div class="proof__products">
                        @foreach (product_color_products($campaign->product_colors) as $product)
                            @if ($product->campaign_colors->count() > 0 && $campaign->getProductProofs($product->id)->count() > 0 || ($loop->index == 0 && $campaign->getProofs('generic')->count() > 0))
                                <div class="proof__product {{ $activeProductColor->product_id == $product->id ? 'active': '' }} product-{{ $product->id }}"
                                     data-product="{{ $product->id }}">{{ $product->name }}</div>
                            @endif
                        @endforeach
                    </div>

                    <h3>Colors</h3>
                    @foreach (product_color_products($campaign->product_colors) as $product)
                        <div class="proof__colors {{ $activeProductColor->product_id == $product->id ? 'active' : '' }} product-colors-{{ $product->id }}">

                            @foreach ($product->campaign_colors as $productColor)
                                @if (! isset($colorSelected))
                                    <?php $colorSelected = $productColor->id ?>
                                @endif
                                @include('v2.partials.slider.proof_slider_color', [
                                    'active' => $colorSelected == $productColor->id,
                                    'productId' => $product->id,
                                    'colorId' => $productColor->id,
                                    'imageId' => $productColor->image_id,
                                ])
                            @endforeach
                            <?php unset($colorSelected) ?>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{ $slot }}
    </div>
</div>

@if (Request::ajax())
    <script>
        AppCampaign.init();
    </script>
@endif