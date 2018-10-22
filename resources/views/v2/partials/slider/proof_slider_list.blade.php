<div class="block-proofs" id="proof-slider-{{ $productColor->id }}">
    <div class="proofs__body">
        <div class="proof-list-slider-content">
            @include('v2.partials.slider.proof_slider_image', [
                'active' => $active,
                'productId' => $productColor->product_id,
                'colorId' => $productColor->id,
                'proofs' => $campaign->artwork_request->getProofsFromProductColor($productColor->id),
                'name' => $productColor->product->name . ' - ' . $productColor->name,
                'hideThumbs' => true,
            ])
        </div>
    </div>
</div>