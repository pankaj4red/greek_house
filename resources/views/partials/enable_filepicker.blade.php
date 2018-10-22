@section ('javascript')
    <script>
        function loadScript(url, callback) {
            var script = document.createElement("script");
            script.type = "text/javascript";
            if (script.readyState) {
                script.onreadystatechange = function () {
                    if (script.readyState === "loaded" || script.readyState === "complete") {
                        script.onreadystatechange = null;
                        callback();
                    }
                };
            } else {
                script.onload = function () {
                    callback();
                };
            }
            script.src = url;
            document.getElementsByTagName("head")[0].appendChild(script);
        }

        loadScript('https://api.filepicker.io/v1/filepicker.js', function () {
            filepicker.setKey('{{ config('services.filepicker.key') }}');
            $('body').on('click', '.filepicker', function (event) {
                var that = this;
                event.preventDefault();
                if ($(this).attr('data-type') === 'list-file') {
                    filepicker.pick(
                            {
                                services: ['COMPUTER'],
                                conversions: ['crop', 'rotate', 'filter'],
                                mimetype: 'text, text/comma-separated-values, text/csv, application/csv, application/excel, application/vnd.ms-excel, application/vnd.msexcel',
                                container: 'modal',
                                maxSize: 10 * 1024 * 1024
                            },
                            function (data) {
                                var url = data.url;
                                var filename = data.filename;
                                $(that).parent().parent().find('.file-entry').remove();
                                $(that).parent().before($('<div class="file-entry"><div class="file-entry-file"><a href="' + url + '" target="_blank" class="non-image-file">' + filename + '</a></div>' +
                                        '<input type="hidden" value="' + url + '" name="' + $(that).attr('id') + '_url"/>' +
                                        '<input type="hidden" value="' + filename + '" name="' + $(that).attr('id') + '_filename"/>' +
                                        '<input type="hidden" value="0" name="' + $(that).attr('id') + '_id"/>' +
                                        '<input type="hidden" value="new" name="' + $(that).attr('id') + '_action"/>' +
                                        '<a href="#" class="btn btn-danger file-remove" data-target="' + $(that).attr('id') + '">Remove</a>' +
                                        '</div>'));
                                if (typeof filepicker_callback === 'function') {
                                    filepicker_callback($(that).attr('id'), 'add', {url: url, filename: filename});
                                }

                            },
                            function (FPError) {
                                console.log(FPError.toString());
                            }
                    );
                } else if ($(this).attr('data-type') === 'resume') {
                    filepicker.pick(
                            {
                                services: ['COMPUTER'],
                                conversions: ['crop', 'rotate', 'filter'],
                                mimetype: 'text, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf',
                                container: 'modal'
                            },
                            function (data) {
                                var url = data.url;
                                var filename = data.filename;
                                $(that).parent().parent().find('.file-entry').remove();
                                $(that).parent().before($('<div class="file-entry"><div class="file-entry-file"><a href="' + url + '" target="_blank" class="non-image-file">' + filename + '</a></div>' +
                                        '<input type="hidden" value="' + url + '" name="' + $(that).attr('id') + '_url"/>' +
                                        '<input type="hidden" value="' + filename + '" name="' + $(that).attr('id') + '_filename"/>' +
                                        '<input type="hidden" value="0" name="' + $(that).attr('id') + '_id"/>' +
                                        '<input type="hidden" value="new" name="' + $(that).attr('id') + '_action"/>' +
                                        '<a href="#" class="btn btn-danger file-remove" data-target="' + $(that).attr('id') + '">Remove</a>' +
                                        '</div>'));
                                if (typeof filepicker_callback === 'function') {
                                    filepicker_callback($(that).attr('id'), 'add', {url: url, filename: filename});
                                }
                            },
                            function (FPError) {
                                console.log(FPError.toString());
                            }
                    );
                } else if ($(this).attr('data-type') === 'any') {
                    filepicker.pick(
                            {
                                services: ['COMPUTER'],
                                conversions: ['crop', 'rotate', 'filter'],
                                container: 'modal'
                            },
                            function (data) {
                                var url = data.url;
                                var filename = data.filename;
                                var imageHtml = '<div class="file-entry-file"><a href="' + url + '" target="_blank" class="non-image-file">' + filename + '</a></div>';
                                if (filename.match(/.(jpg|jpeg|png|gif)$/i)) {
                                    imageHtml = '<div class="file-entry-image"><img src="' + url + '"/></div>';
                                }
                                $(that).parent().parent().find('.file-entry').remove();
                                $(that).parent().before($('<div class="file-entry">' + imageHtml +
                                        '<input type="hidden" value="' + url + '" name="' + $(that).attr('id') + '_url"/>' +
                                        '<input type="hidden" value="' + filename + '" name="' + $(that).attr('id') + '_filename"/>' +
                                        '<input type="hidden" value="0" name="' + $(that).attr('id') + '_id"/>' +
                                        '<input type="hidden" value="new" name="' + $(that).attr('id') + '_action"/>' +
                                        '<a href="#" class="btn btn-danger file-remove" data-target="' + $(that).attr('id') + '">Remove</a>' +
                                        '</div>'));
                                if (typeof filepicker_callback === 'function') {
                                    filepicker_callback($(that).attr('id'), 'add', {url: url, filename: filename});
                                }
                            },
                            function (FPError) {
                                console.log(FPError.toString());
                            }
                    );
                } else {
                    filepicker.pick(
                            {
                                services: ['COMPUTER', 'FACEBOOK', 'FLICKR', 'GOOGLE_DRIVE', 'IMAGE_SEARCH', 'URL', 'DROPBOX'],
                                conversions: ['crop', 'rotate', 'filter'],
                                mimetype: 'image/*',
                                container: 'modal',
                                imageDim: [450, 450],
                                cropDim: [400, 400],
                                cropRatio: [1],
                                cropForce: true,
                                maxSize: 10 * 1024 * 1024
                            },
                            function (data) {
                                var url = data.url;
                                var filename = data.filename;
                                $(that).parent().parent().find('.file-entry').remove();
                                $(that).parent().before($('<div class="file-entry"><div class="file-entry-image"><img src="' + url + '"/><span>' + filename + '</span></div>' +
                                        '<input type="hidden" value="' + url + '" name="' + $(that).attr('id') + '_url"/>' +
                                        '<input type="hidden" value="' + filename + '" name="' + $(that).attr('id') + '_filename"/>' +
                                        '<input type="hidden" value="0" name="' + $(that).attr('id') + '_id"/>' +
                                        '<input type="hidden" value="new" name="' + $(that).attr('id') + '_action"/>' +
                                        '<a href="#" class="btn btn-danger file-remove" data-target="' + $(that).attr('id') + '">Remove</a>' +
                                        '</div>'));
                                var parent_div = $(that).parent().parent().parent();
                                // this code will create thumbnail from image only for product color images
                                if( $(parent_div).prop('id')== 'color_image_div'){



                                }
                                if (typeof filepicker_callback === 'function') {
                                    filepicker_callback($(that).attr('id'), 'add', {url: url, filename: filename});
                                }
                              },
                            function (FPError) {
                                console.log(FPError.toString());
                            }
                    );
                }

                return false;
            });
            $('body').on('click', '.file-remove', function (event) {
                event.preventDefault();
                var next = $(this).closest('.file-entry').next();
                $(this).closest('.file-entry').remove();
                next.before($('<div class="file-entry hidden"><input type="hidden" value="" name="' + $(this).attr('data-target') + '_url"/>' +
                        '<input type="hidden" value="" name="' + $(this).attr('data-target') + '_filename"/>' +
                        '<input type="hidden" value="0" name="' + $(this).attr('data-target') + '_id"/>' +
                        '<input type="hidden" value="remove" name="' + $(this).attr('data-target') + '_action"/></div>'));
                if (typeof filepicker_callback === 'function') {
                    filepicker_callback($(this).attr('data-target'), 'remove', {});
                }
                return false;
            });
        });
    </script>
@append
