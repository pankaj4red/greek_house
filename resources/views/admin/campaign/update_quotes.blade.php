@extends ('admin.layouts.admin')

@section ('content')
    {{ Form::open() }}
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Campaign Products
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" style="table-layout: fixed;">
                            <thead>
                            <tr>
                                <th>Product / Color</th>
                                <th style="width: 120px;">Image</th>
                                <th style="width: 80px">Quote Low</th>
                                <th style="width: 80px">Quote High</th>
                                <th style="width: 80px">Quote Final</th>
                            </tr>
                            </thead>
                            <tbody class="product-list">
                            @foreach (product_color_products($campaign->product_colors) as $product)
                                <?php $quotes = $campaign->quotes->where('product_id', $product->id) ?>
                                <tr class="product-color-entry">
                                    <td>
                                        {{ Form::hidden('product[]', $product->id) }}
                                        {{ $product->name }}
                                    </td>
                                    <td>
                                        <p class="form-control-static"><img class="color-image product-color-image" src="{{ route('system::image', $product->image_id) }}" style="width: 100px;"/></p>
                                    </td>
                                    <td>{{ Form::text('low[]', $quotes->count() ? $quotes->first()->quote_low : null, ['class' => 'form-control']) }}</td>
                                    <td>{{ Form::text('high[]', $quotes->count() ? $quotes->first()->quote_high : null, ['class' => 'form-control']) }}</td>
                                    <td>{{ Form::text('final[]', $quotes->count() ? $quotes->first()->quote_final : null, ['class' => 'form-control']) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('admin::campaign::read', [$campaign->id]) }}" class="btn btn-default btn-back">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
