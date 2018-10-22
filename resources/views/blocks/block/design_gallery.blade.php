<div class="panel panel-default panel-box">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-status"></i><span class="icon-text">Design Gallery</span>
        </h3>
    </div>
    <div class="panel-body">
        {{ Form::open(['url' => $blockUrl]) }}
        <div class="row">
            <div class="col-md-4">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="control-label">Link</label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-text">
                                <a href="{{ route('home::design_gallery', [$campaign->designs->first()->id]) }}" target="_blank">{{ $campaign->designs->first()->name }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="control-label">Name</label>
                        </div>
                        <div class="col-md-9">
                            {{ Form::text('name', $campaign->designs->first()->name, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="control-label">Code</label>
                        </div>
                        <div class="col-md-9">
                            {{ Form::text('code', $campaign->designs->first()->code, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="control-label">Status</label>
                        </div>
                        <div class="col-md-9">
                            {{ Form::select('status', design_status_options(), $campaign->designs->first()->status, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="control-label">Trending</label>
                        </div>
                        <div class="col-md-9">
                            {{ Form::checkbox('trending', 'enabled', $campaign->designs->first()->trending, ['data-toggle' => 'toggle', 'data-on' => 'Enabled', 'data-off' => 'Disabled', 'data-size' => 'small', 'data-onstyle' => 'success']) }}
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::hidden('images', null, ['id' => 'images']) }}
            <div class="col-md-8">
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Design Images</label>
                        <ol class="drag-images drag-design-images vertical" id="design-gallery-list">
                            @foreach ($campaign->designs->first()->images as $image)
                                <li>
                                    <i class="icon-move"></i>
                                    @include ('partials.image_entry', [
                                        'imageId' => 'design' . global_counter(),
                                        'type' => $image->type,
                                        'typeId' => $image->id,
                                        'url' => route('system::image', [$image->file_id]),
                                        'enable' => true,
                                        'enableState' => $image->enabled,
                                        'remove' => true,
                                    ])
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Campaign Proofs</label>
                            <ol class="drag-images drag-design-images vertical" id="proof-list">
                                @foreach ($campaign->artwork_request->proofs as $proof)
                                    <li>
                                        @include ('partials.image_entry', [
                                            'imageId' => 'design' . global_counter(),
                                            'type' => $proof->type,
                                            'typeId' => $proof->id,
                                            'url' => route('system::image', [$proof->file_id]),
                                            'addRemove' => true,
                                            'addRemoveState' => false,
                                        ])
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Upload Design Image</label>
                            <div class="file-list">
                                @include ('partials.image_picker', [
                                    'fieldName' => 'image',
                                    'fieldType' => 'image',
                                    'fieldData' => isset($image) ? $image : null
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Override Thumbnail</label>
                            <div class="file-list">
                                @include ('partials.image_picker', [
                                    'fieldName' => 'thumbnail',
                                    'fieldType' => 'image',
                                    'fieldData' => isset($thumbnail) ? $thumbnail : null
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            @foreach (design_tag_group_repository()->all() as $group)
                                <label class="control-label" for="tag_{{ $group->code }}">{{ $group->caption }}</label>
                                {!! Form::textarea('tag_' . $group->code, commafy_tags($campaign->designs->first()->getTags($group->code)), ['class' => '', 'id' => 'tag_' . $group->code]) !!}
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success pull-right">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="hidden" id="proof-template">
        <li>
            <i class="icon-move"></i>
            @include ('partials.image_entry', [
                'imageId' => '#',
                'type' => 'proof',
                'typeId' => 0,
                'url' => '#',
                'enable' => true,
                'enableState' => true,
                'remove' => true,
            ])
        </li>
    </ul>
    <ul class="hidden" id="upload-template">
        <li>
            <i class="icon-move"></i>
            @include ('partials.image_entry', [
                'imageId' => '#',
                'type' => 'upload',
                'typeId' => 0,
                'url' => '#',
                'enable' => true,
                'enableState' => true,
                'removeUpload' => true,
            ])
        </li>
    </ul>
    {{ Form::close() }}
</div>

@section ('javascript')
    <script src="//johnny.github.io/jquery-sortable/js/jquery-sortable.js"></script>
    <script>

        var GreekHouseImages = {
                proofTemplate: $('#proof-template').html(),
                uploadTemplate: $('#upload-template').html(),
                uploadId: 0,
                references: {
                    designImageList: $("#design-gallery-list"),
                    proofList: $("#proof-list"),
                    imageInformation: $("#images")
                },
                methods: {
                    init: function () {
                        if ($(this).hasClass('start-hidden')) {
                            $(this).closest('.toggle').css('display', 'none');
                        }
                        $(this).closest('.toggle').css('opacity', 1);
                        if ($(this).attr('data-type') === 'enable') {
                            $(this).change(function () {
                                if ($(this).prop('checked')) {
                                    GreekHouseImages.methods.image.enable(this);
                                } else {
                                    GreekHouseImages.methods.image.disable(this);
                                }
                            });
                        }
                        if ($(this).attr('data-type') === 'add') {
                            $(this).change(function () {
                                if ($(this).prop('checked')) {
                                    GreekHouseImages.methods.proof.add(this);
                                } else {
                                    GreekHouseImages.methods.proof.remove(this);
                                }
                            });
                        }
                        if ($(this).attr('data-type') === 'upload') {
                            $(this).click(function () {
                                GreekHouseImages.methods.upload.remove(this);
                            });
                        }
                        if ($(this).attr('data-type') === 'remove') {
                            $(this).click(function () {
                                GreekHouseImages.methods.image.remove(this);
                            });
                        }
                    },
                    image: {
                        enable: function (that) {
                            var informationDiv = $(that).closest('.image-entry-container');
                            GreekHouseImages.actions.enable(informationDiv.attr('data-id'));
                        },
                        disable: function (that) {
                            var informationDiv = $(that).closest('.image-entry-container');
                            GreekHouseImages.actions.disable(informationDiv.attr('data-id'));
                        },
                        remove: function (that) {
                            var informationDiv = $(that).closest('.image-entry-container');
                            var li = GreekHouseImages.references.designImageList.find('.image-entry-container[data-id=' + informationDiv.attr('data-id') + ']').closest('li');
                            li.fadeOut(200, function () {
                                $(this).remove();
                                GreekHouseImages.actions.remove(informationDiv.attr('data-id'));
                            });
                        }
                    }
                    ,
                    proof: {
                        add: function (that) {
                            var informationDiv = $(that).closest('.image-entry-container');
                            var template = $(GreekHouseImages.proofTemplate);
                            template.find('.image-entry-container').attr('data-id', informationDiv.attr('data-id'));
                            template.find('img').attr('src', informationDiv.find('img').attr('src'));
                            template.appendTo('#design-gallery-list');
                            template.find('input[data-type=enable]').bootstrapToggle();
                            template.find('input[data-type=enable]').each(GreekHouseImages.methods.init);
                            template.find('button').each(GreekHouseImages.methods.init);
                            template.hide();
                            GreekHouseImages.actions.addProof(informationDiv.attr('data-id'));
                            template.fadeIn(200);
                        }
                        ,
                        remove: function (that) {
                            var informationDiv = $(that).closest('.image-entry-container');
                            var li = GreekHouseImages.references.designImageList.find('.image-entry-container[data-id=' + informationDiv.attr('data-id') + ']').closest('li');
                            li.fadeOut(200, function () {
                                $(this).remove();
                                GreekHouseImages.actions.remove(informationDiv.attr('data-id'));
                            });
                        }
                    }
                    ,
                    upload: {
                        remove: function (that) {
                            var informationDiv = $(that).closest('.image-entry-container');
                            var li = GreekHouseImages.references.designImageList.find('.image-entry-container[data-id=' + informationDiv.attr('data-id') + ']').closest('li');
                            li.fadeOut(200, function () {
                                $(this).remove();
                                GreekHouseImages.actions.removeUpload(informationDiv.attr('data-id'));
                            });
                        }
                    }
                },
                information:
                    {
                        getInformation: function () {
                            var data = {
                                designs: []
                            };
                            GreekHouseImages.references.designImageList.find('input[data-type=enable]').each(function () {
                                var element = $(this).closest('.image-entry-container');
                                var entry = {
                                    id: element.attr('data-id'),
                                    enabled: $(this).prop('checked')
                                };
                                if (element.attr('data-id').startsWith('upload_')) {
                                    entry.url = element.attr('data-url');
                                    entry.filename = element.attr('data-filename');
                                }
                                data.designs.push(entry);
                            });

                            return data;
                        }
                        ,
                        setInformation: function (data) {
                            //console.log(JSON.stringify(data));
                            GreekHouseImages.references.imageInformation.val(JSON.stringify(data));
                        }
                    }
                ,
                actions: {
                    addProof: function (id) {
                        //console.log('addProof: ' + id);
                        GreekHouseImages.information.setInformation(GreekHouseImages.information.getInformation());
                    },
                    removeProof: function (id) {
                        //console.log('removeProof: ' + id);
                        GreekHouseImages.information.setInformation(GreekHouseImages.information.getInformation());
                    },
                    enable: function (id) {
                        //console.log('enable: ' + id);
                        GreekHouseImages.information.setInformation(GreekHouseImages.information.getInformation());
                    },
                    disable: function (id) {
                        //console.log('disable: ' + id);
                        GreekHouseImages.information.setInformation(GreekHouseImages.information.getInformation());
                    },
                    addUpload: function (id) {
                        //console.log('addUpload: ' + id);
                        GreekHouseImages.information.setInformation(GreekHouseImages.information.getInformation());
                    },
                    removeUpload: function (id) {
                        //console.log('removeUpload: ' + id);
                        GreekHouseImages.information.setInformation(GreekHouseImages.information.getInformation());
                    },
                    remove: function (id) {
                        //console.log('remove: ' + id);
                        $('.image-entry-container[data-id=' + id + ']').find('input[data-type=add]').bootstrapToggle('off');
                        GreekHouseImages.information.setInformation(GreekHouseImages.information.getInformation());
                    },
                    updateInformation: function () {
                        //console.log('update info');
                        GreekHouseImages.information.setInformation(GreekHouseImages.information.getInformation());
                    }
                }
            }
        ;

        GreekHouseImages.references.designImageList.sortable({
            handle: 'i.icon-move',
            onDrop: function ($item, container, _super) {
                _super($item, container);
                GreekHouseImages.actions.updateInformation();
            }
        });

        setTimeout(function () {
            $(".image-information input[type=checkbox]").each(GreekHouseImages.methods.init);
            $(".image-information button").each(GreekHouseImages.methods.init);
        });

        window.filepicker_callback = function (target, action, data) {
            if (target !== 'image') {
                return;
            }

            var template = $(GreekHouseImages.uploadTemplate);
            var newId = ++GreekHouseImages.uploadId;
            var id = 'upload' + '_' + newId;
            template.find('.image-entry-container').attr('data-id', id);
            template.find('.image-entry-container').attr('data-url', data.url);
            template.find('.image-entry-container').attr('data-filename', data.filename);
            template.find('img').attr('src', data.url);
            template.appendTo('#design-gallery-list');
            template.find('input[data-type=enable]').bootstrapToggle();
            template.find('input[data-type=enable]').each(GreekHouseImages.methods.init);
            template.find('button').each(GreekHouseImages.methods.init);
            template.hide();
            template.fadeIn(200, function () {
                GreekHouseImages.actions.addUpload(id);
                $('input[name=image_id]').closest('.file-entry').remove();
            });
        };

        GreekHouseImages.actions.updateInformation();
    </script>
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
        tagifyTextarea('#tag_{{ $group->code }}', {!! json_encode(explode(',', $group->whitelist)) !!});
        @endforeach
    </script>
@append

@section ('javascript')
    @include ('partials.enable_filepicker')
@append
