@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Design Images</h1>
        </div>
    </div>
    {!! Form::open() !!}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Design Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Proofs</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="file-list">
                                    @for($i = 0; $i < 10; $i++)
                                        @include ('partials.image_picker', [
                                            'fieldName' => 'image' . $i,
                                            'fieldType' => 'image',
                                            'fieldData' => isset(${'image' . $i}) ? ${'image' . $i} : null
                                        ])
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class=" action-area pull-right">
                <a href="{{ route('admin::design::read', [$design->id]) }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section ('javascript')
    @include ('partials.enable_filepicker')
@append