<div class="panel panel-default panel-box">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-status"></i><span class="icon-text">Design Tags</span>
        </h3>
    </div>
    <div class="panel-body">
        @if ($edit)
            {{ Form::model($campaign, ['url' => $blockUrl, 'class' => 'form-inline']) }}
            @foreach (design_tag_group_repository()->all() as $group)
                <div class="row">
                    <div class="col-sm-3">
                        <label for="tag_{{ $group->code }}">{{ $group->caption }}</label>
                    </div>
                    <div class="col-sm-9">
                        {!! Form::textarea('tag_' . $group->code, commafy_tags($campaign->designs->first()->getTags($group->code)), ['class' => '', 'id' => 'tag_' . $group->code]) !!}
                    </div>
                </div>
            @endforeach
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" name="save" value="save" class="btn btn-info pull-right margin-top">Save Tags</button>
                </div>
            </div>
            {{ Form::close() }}
        @endif
    </div>
</div>

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