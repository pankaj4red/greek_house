<tr>
    <?php //dd($campaign); ?>
    <td><input type="text" class="gh-control small" value="1"></td>
    <td>
        <select class="gh-control small">
            <option>--</option>
            @foreach (product_size_options($campaign->products->first()->id) as $sizeKey => $sizeValue)
                <option value="{{ $sizeKey }}" {{ $sizeList[$i] == $sizeKey ? 'selected' : '' }}>{{ $sizeValue }}</option>
            @endforeach
            <!--
            <option>S</option>
            <option>M</option>
            <option>L</option>
            <option>XL</option>
            <option>2XL</option>
            <option>3XL</option>-->
        </select>
    </td>
    <td>
        <select class="gh-control small product__style">
            <option>--</option>
            <option selected="">Black - Comfort Colors T-Shirt</option>
            <option>White - Comfort Colors T-Shirt</option>
            <option>Blue - Comfort Longlseeve</option>
            <option>White - Comfort Longlseeve</option>
        </select>
    </td>
    <td>
        <div class="product__price">$20.99 <div class="product__remove">Remove</div></div>
    </td>
</tr>