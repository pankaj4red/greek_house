<div class="product-carousel {{ $active ? 'active' : '' }}" id="product-{{ $productId }}-{{ $colorId }}">
    <h5>{{ $name }}</h5>
    <div class="owl-carousel proofs__images">
        @foreach ($proofs as $proof)
            <div class="proof-image owl-lazy" data-src="{{ route('system::image', [$proof->file_id]) }}"></div>
        @endforeach
    </div>
    @if (! isset($hideThumbs) || ! $hideThumbs)
        <div class="proofs__thumbs">
            <div class="owl-carousel">
                @foreach ($proofs as $proof)
                    <div class="proof-image" data-src="{{ route('system::image', [$proof->file_id]) }}" style="background-image: url({{ route('system::image', [$proof->file_id]) }})"></div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@if (isset($hideThumbs) && $hideThumbs)
    <style>
        #product-{{ $productId }}-{{ $colorId }} .owl-nav {
            display: none;
        }
    </style>
@endif