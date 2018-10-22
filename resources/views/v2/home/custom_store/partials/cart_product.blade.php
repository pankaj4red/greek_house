<?php

$entryList = $order->entries;

if(sizeof($entryList) < 1){
    return;
}

$product = $order->campaign->product_colors[0]->product;

$controlFlag = true;
if(isset($control)) $controlFlag = $control;

foreach($entryList as $entry){

    $product = $entry->product_color->product;

?>
<div class="cart__product">
    <input type="hidden" name="order[]" value="{{ $entry->order_id }}">
    <input type="hidden" name="entry[]" class="entry_id" value="{{ $entry->id }}">
    <input type="hidden" name="price[]" value="{{ $order->campaign->quotes->where('product_id', $product->id)->first()->quote_high * 1.07 }}">
    <input type="hidden" name="size[]" value="{{ $entry->size->id }}">
    <input type="hidden" name="color[]" value="{{ $entry->product_color_id }}">
    <a href="{{ route('custom_store::details', [product_to_description($order->campaign->id, $order->campaign->name)]) }}" class="product__image"
       style="background-image: url({{ route('system::image', [$product->image_id]) }})"></a>
    <div class="product__name">
        <a href="{{ route('custom_store::details', [product_to_description($order->campaign->id, $order->campaign->name)]) }}"
           class="">{{ $product->name }}</a>
        <div class="product__color">{{product_color($entry->product_color_id)->name }} ({{ $entry->size->short }})</div>
    </div>
    <div class="product__qty">
        <input type="text" name="quantity[]" class="gh-control" value="{{ $entry->quantity }}" {{ $controlFlag==false?'disabled':'' }}>
        <div class="qty__btn qty-minus {{ $controlFlag==false?'d-none':'' }}" data-field="quantity[]">-</div>
        <div class="qty__btn qty-plus {{ $controlFlag==false?'d-none':'' }}" data-field="quantity[]">+</div>
    </div>
    <div class="product__price">{{ money($order->campaign->quotes->where('product_id', $product->id)->first()->quote_high * 1.07) }}</div>
    <?php if($controlFlag){ ?><div class="product__delete"><i class="fa fa-close"></i></div> <?php } ?>
</div>
<?php

}

?>