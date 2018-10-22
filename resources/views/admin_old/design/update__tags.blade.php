@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Design Tags</h1>
        </div>
    </div>
    {!! Form::open() !!}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Design Information
                </div>
                <div class="panel-body">
                    @foreach (design_tag_group_repository()->all() as $group)
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label class="control-label">{{ $group->caption }}</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('tag_' . $group->code, commafy_tags($design->getTags($group->code)), ['class' => '', 'id' => 'tag_' . $group->code]) !!}
                            </div>
                        </div>
                    @endforeach
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
    </div>
    {!! Form::close() !!}
@endsection

@section ('javascript')
    <link href="{{ static_asset('css/tagify.css') }}" rel="stylesheet">
    <script src="{{ static_asset('js/tagify.js') }}"></script>
    <script>
        function tagifyTextarea(textareaSelector, whitelist) {
            var textarea = $(textareaSelector).get(0);
            var tagify = new Tagify(textarea, {
                duplicates: false,
                whitelist: whitelist
            });
        }
        @foreach (design_tag_group_repository()->all() as $group)
            tagifyTextarea('#tag_{{ $group->code }}', JSON.parse("{!! slashes(json_encode(explode(',', $group->whitelist))) !!}"));
        @endforeach
    </script>
@append
