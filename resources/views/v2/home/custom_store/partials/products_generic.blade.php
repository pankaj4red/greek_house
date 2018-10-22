<div class="container">
    <div class="row no-gutters">
        <div class="col-12">
            <div class="products_items {{ $class }}">
                @foreach($products as $product)
                    <a href="{{ route('custom_store::product_page').'/1/'.$product->id }}" class="product__item">
                        <div class="product__image" style="background-image: url({{ $product['image'] }})"></div>
                        <div class="product__name">{{ $product['name'] }}</div>
                        <div class="product__price">${{ number_format($product['price'], 2) }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>