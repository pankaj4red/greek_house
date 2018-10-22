if ($('#design-gallery-tags').length > 0) {
    var DesignGalleryTags = {
        settings: {
            haltProcessing: false,
            dataTags: [],
            dataThemeEvents: [],
            dataChapters: []
        },
        init: function (dataTags, dataThemeEvents, dataChapters) {
            DesignGalleryTags.settings.dataTags = dataTags;
            DesignGalleryTags.settings.dataThemeEvents = dataThemeEvents;
            DesignGalleryTags.settings.dataChapters = dataChapters;

            $(".select2-multiple").select2({
                allowClear: true,
                data: DesignGalleryTags.settings.dataTags,
                tags: true,
                minimumInputLength: 1
            });
            $('.select2-multiple').on('select2:close', function (e) {
                var that = this;
                setTimeout(function () {
                    $(that).closest('.multiselect-container').find('.select2-search__field').focus();
                }, 100);
            });
            $('.select2-multiple').on("select2:select", DesignGalleryTags.search);
            $('.select2-multiple').on("select2:unselect", DesignGalleryTags.search);

            $("#filter-event-themes").each(function () {
                $(this).select2({
                    data: dataThemeEvents,
                    allowClear: true,
                    placeholder: "Filter by " + $(this).attr('data-caption')
                });
            });

            $("#filter-chapter").each(function () {
                $(this).select2({
                    data: dataChapters,
                    allowClear: true,
                    placeholder: "Filter by " + $(this).attr('data-caption')
                });
            });

            $(".tag-select").on("change", this.search);
            $('.tag-select').on('select2:unselecting', function () {
                var opts = $(this).data('select2').options;
                opts.set('disabled', true);
                setTimeout(function () {
                    opts.set('disabled', false);
                }, 1);
            });
        },
        updateTags: function () {
            if (DesignGalleryTags.settings.haltProcessing) {
                return;
            }

            var tags = $('.select2-multiple').val() && $('.select2-multiple').val().length > 0 ? $('.select2-multiple').val() : [];
            var changed = false;
            $('.tag-select').each(function () {
                if ($(this).val()) {
                    tags.push($(this).val().trim());
                    changed = true;
                    DesignGalleryTags.settings.haltProcessing = true;
                    $(this).val([]).trigger("change");
                    DesignGalleryTags.settings.haltProcessing = false;
                }
            });
            if (changed == true) {
                DesignGalleryTags.settings.haltProcessing = true;
                $('.select2-multiple').val(tags).trigger("change");
                DesignGalleryTags.settings.haltProcessing = false;
            }

            var tagText = '';
            tags.forEach(function (value) {
                if (tagText) {
                    tagText += ',';
                }
                tagText += value;
            });
            if (tags.length > 0) {
                window.history.pushState('page', "Design Gallery | Greek House", '/design-gallery?tags=' + encodeURIComponent(tagText));
            } else {
                window.history.pushState('page', "Design Gallery | Greek House", '/design-gallery');
            }

            if (DesignGallery) {
                DesignGallery.search(tags);
            }
        },
        search: function () {
            DesignGalleryTags.updateTags();
        },
    };

    window.DesignGalleryTags = DesignGalleryTags;
}
