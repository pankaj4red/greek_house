<div class="table-responsive">
    <table class="table border">
        <thead>
        <tr>
            <th>Garment Info</th>
            <th>Garment Style</th>
            <th>Style Number</th>
            <th>Color</th>
        </tr>
        </thead>
        <tbody>
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
