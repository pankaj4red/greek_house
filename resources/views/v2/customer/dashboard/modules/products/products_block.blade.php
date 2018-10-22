<div class="block-info-rounded">
    <div class="block-products campaign__table-wrapper">
        <table class="campaign__table">
            <tbody>
            <tr>
                <th>Garment Info</th>
                <th>Garment Style</th>
                <th>Style Number</th>
                <th>Color</th>
            </tr>
            @foreach ($campaign->product_colors as $productColor)
                <tr>
                    <td>{{ $productColor->product->name }}</td>
                    <td>{{ $productColor->product->category->name }}</td>
                    <td>{{ $productColor->product->style_number }}</td>
                    <td>{{ $productColor->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>