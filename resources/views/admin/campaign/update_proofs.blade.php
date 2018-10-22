@extends ('admin.layouts.admin')

@section ('content')
    {{ Form::open() }}
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Campaign Proofs
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($campaign->product_colors as $productColor)
                            <div class="col-12 col-md-6">
                                <div class= "form-group">
                                    <label>{{ $productColor->product->name }} - {{ $productColor->name }} Design Files</label>
                                    <div class="file-list">
                                        <div class="d-inline-block">
                                            @include ('admin.partials.filepicker', [
                                                'class' => 'file-block mb-0',
                                                'label'     => 'Front',
                                                'fieldName' => 'proof' . $productColor->id . '_front',
                                                'fieldType' => 'image',
                                                'fieldData' => isset($proofs->products[$productColor->id]->front) ? $proofs->products[$productColor->id]->front : null
                                            ])
                                            <div class="text-center lh-1 text-sm">Front</div>
                                        </div>
                                        <div class="d-inline-block">
                                            @include ('admin.partials.filepicker', [
                                                'class' => 'file-block mb-0',
                                                'label'     => 'Back',
                                                'fieldName' => 'proof' . $productColor->id . '_back',
                                                'fieldType' => 'image',
                                                'fieldData' => isset($proofs->products[$productColor->id]->back) ? $proofs->products[$productColor->id]->back : null
                                            ])
                                            <div class="text-center lh-1 text-sm">Back</div>
                                        </div>
                                        <div class="d-inline-block">
                                            @include ('admin.partials.filepicker', [
                                                'class' => 'file-block mb-0',
                                                'label'     => 'Close Up',
                                                'fieldName' => 'proof' . $productColor->id . '_close_up',
                                                'fieldType' => 'image',
                                                'fieldData' => isset($proofs->products[$productColor->id]->close_up) ? $proofs->products[$productColor->id]->close_up : null
                                            ])
                                            <div class="text-center lh-1 text-sm">Close Up</div>
                                        </div>
                                        <div class="d-inline-block">
                                            @include ('admin.partials.filepicker', [
                                                'class' => 'file-block mb-0',
                                                'label'     => 'Other',
                                                'fieldName' => 'proof' . $productColor->id . '_other',
                                                'fieldType' => 'image',
                                                'fieldData' => isset($proofs->products[$productColor->id]->other) ? $proofs->products[$productColor->id]->other : null
                                            ])
                                            <div class="text-center lh-1 text-sm">Other</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>Generic Design Files (old)</label>
                                <div class="file-list">
                                    @for($i = 0; $i < 10; $i++)
                                        @include ('admin.partials.filepicker', [
                                            'class' => 'file-block',
                                            'fieldName' => 'proof' . $i,
                                            'fieldType' => 'image',
                                            'fieldData' => isset($proofs->generic['proof' . $i]) ? $proofs->generic['proof' . $i] : null
                                        ])
                                    @endfor
                                </div>
                            </div>
                        </div>
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
