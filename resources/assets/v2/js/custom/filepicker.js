let GreekHouseFilepicker = {
    setKey: function (key) {
        loadScript('https://api.filepicker.io/v1/filepicker.js', function () {
            filepicker.setKey(key);
            GreekHouseFilepicker.init();
        });
    },
    init: function () {
        $('body').on('click', '.filepicker', function (event) {
            let that = this;
            event.preventDefault();
            if ($(this).attr('data-type') === 'image') {
                filepicker.pick(
                    {
                        services: ['COMPUTER', 'FACEBOOK', 'FLICKR', 'GOOGLE_DRIVE', 'IMAGE_SEARCH', 'URL', 'DROPBOX'],
                        mimeTypes: 'image/*',
                        maxFiles: 1,
                        maxSize: 10 * 1024 * 1024,
                        transformations: ['crop', 'circle', 'rotate']
                    }, function (res) {
                        let url = res.url;
                        let filename = res.filename;
                        if (!res.mimetype.startsWith('image/')) {
                            GreekHousePrompt.alert('File upload Error', 'This field only accepts image files.');
                            return;
                        }

                        $(that).parent().parent().find('.filepicker-information').remove();
                        $(that).parent().before($('<div class="filepicker-information"><div class="filepicker-entry-content filepicker-image-wrapper"><img src="' + url + '" class="filepicker-image"/></div>' +
                            '<input type="hidden" value="' + url + '" name="' + $(that).attr('id') + '_url"/>' +
                            '<input type="hidden" value="' + filename + '" name="' + $(that).attr('id') + '_filename"/>' +
                            '<input type="hidden" value="0" name="' + $(that).attr('id') + '_id"/>' +
                            '<input type="hidden" value="new" name="' + $(that).attr('id') + '_action"/>' +
                            '<a href="#" class="btn btn-danger filepicker-remove" data-target="' + $(that).attr('id') + '">Remove</a>' +
                            '</div>'));
                        if (typeof filepicker_callback === 'function') {
                            filepicker_callback($(that).attr('id'), 'add', {url: url, filename: filename});
                        }
                    }, function (error) {
                        console.log(error);
                    });
            } else {
                filepicker.pick(
                    {
                        services: ['COMPUTER', 'FACEBOOK', 'FLICKR', 'GOOGLE_DRIVE', 'IMAGE_SEARCH', 'URL', 'DROPBOX'],
                        maxFiles: 1,
                        maxSize: 10 * 1024 * 1024,
                        transformations: ['crop', 'circle', 'rotate']
                    }, function (res) {
                        let url = res.url;
                        let filename = res.filename;
                        let imageHtml = '<div class="filepicker-entry-content filepicker-image-wrapper"><img src="/images/file.png" class="filepicker-image" title="' + filename + '"/></div>';
                        if (filename.match(/.(jpg|jpeg|png|gif)$/i)) {
                            imageHtml = '<div class="filepicker-entry-content filepicker-image-wrapper"><img src="' + url + '" class="filepicker-image"/></div>';
                        }
                        $(that).parent().parent().find('.filepicker-information').remove();
                        $(that).parent().before($('<div class="filepicker-information">' + imageHtml +
                            '<input type="hidden" value="' + url + '" name="' + $(that).attr('id') + '_url"/>' +
                            '<input type="hidden" value="' + filename + '" name="' + $(that).attr('id') + '_filename"/>' +
                            '<input type="hidden" value="0" name="' + $(that).attr('id') + '_id"/>' +
                            '<input type="hidden" value="new" name="' + $(that).attr('id') + '_action"/>' +
                            '<a href="#" class="btn btn-danger filepicker-remove" data-target="' + $(that).attr('id') + '">Remove</a>' +
                            '</div>'));
                        if (typeof filepicker_callback === 'function') {
                            filepicker_callback($(that).attr('id'), 'add', {url: url, filename: filename});
                        }
                    }, function (error) {
                        console.log(error);
                    });
            }

            return false;
        });

        $('body').on('click', '.filepicker-remove', function (event) {
            event.preventDefault();
            let entry = $(this).closest('.filepicker-entry');
            $(this).closest('.filepicker-information').remove();
            entry.before($('<div class="filepicker-information"><input type="hidden" value="" name="' + $(this).attr('data-target') + '_url"/>' +
                '<input type="hidden" value="" name="' + $(this).attr('data-target') + '_filename"/>' +
                '<input type="hidden" value="0" name="' + $(this).attr('data-target') + '_id"/>' +
                '<input type="hidden" value="remove" name="' + $(this).attr('data-target') + '_action"/></div>'));
            if (typeof filepicker_callback === 'function') {
                filepicker_callback($(this).attr('data-target'), 'remove', {});
            }
            return false;
        });
    },
};

window.GreekHouseFilepicker = GreekHouseFilepicker;


