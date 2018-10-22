<div class="product-carousel {{ $active ? 'active' : '' }} product-{{ $productId }}-{{ $colorId }}">
    <h5>{{ $productColor->product->name }} - {{ $productColor->name }}</h5>
    <div class="owl-carousel proofs__images">
        @foreach ($proofs as $proof)
            <div class="proof-image owl-lazy" data-src="{{ route('system::image', [$proof->file_id]) }}"></div>
        @endforeach
    </div>
    <div class="proofs__thumbs">
        <div class="owl-carousel">
            @foreach ($proofs as $proof)
                <div class="proof-image" data-src="{{ route('system::image', [$proof->file_id]) }}"
                     style="background-image: url({{ route('system::image', [$proof->file_id]) }})"></div>
            @endforeach
        </div>
    </div>
</div>
