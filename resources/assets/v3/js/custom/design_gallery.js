if ($('#design-gallery').length > 0) {

    var DesignGalleryEntry = Vue.component('design-gallery-item', {
        template: '#design-gallery-entry-template',
        directives: {
            imagesLoaded
        },
        data: function () {
            return {
                id: null,
                link: null,
                info: null,
                thumbnail: null,
            };
        },
        methods: {
            init: function (data) {
                this.$data.id = data.id;
                this.$data.link = data.link;
                this.$data.info = data.info;
                this.$data.thumbnail = data.thumbnail;
            },
            selectThisDesign: function ($event) {
                DesignGallery.selectDesign(this.$data.id, $event);
            },
            imageProgress: function(instance, image) {
                if (image.isLoaded) {
                    $(instance.elements[0]).removeClass('image-loading');
                }
            }
        },
        // updated: function () {
        //     this.$nextTick(function () {
        //         $(this.$el).find('.image-loading').each(function () {
        //             imageLoadingEvent(this);
        //         });
        //     });
        // }
    });

    var DesignGalleryImageEntry = Vue.component('design-gallery-image-item', {
        template: '#design-gallery-image-entry-template',
        directives: {
            imagesLoaded
        },
        data: function () {
            return {
                url: null,
            };
        },
        methods: {
            init: function (url) {
                this.$data.url = url;
            },
            selectThisImage: function ($event) {
                DesignGallery.selectImage(this.$data.url, $event);
            },
            imageProgress: function(instance, image) {
                if (image.isLoaded) {
                    $(instance.elements[0]).removeClass('image-loading');
                }
            }
        }
    });

    var DesignGalleryRelated = Vue.component('design-gallery-related', {
        template: '#design-gallery-related-template',
        directives: {
            imagesLoaded
        },
        data: function () {
            return {
                designList: null,
            };
        },
        methods: {
            init: function (designList) {
                this.$data.designList = designList;
            },
            imageProgress: function(instance, image) {
                if (image.isLoaded) {
                    $(instance.elements[0]).removeClass('image-loading');
                }
            }
        },
        computed: {
            designChunks() {
                return _.chunk(this.designList, 4);
            }
        }
    });

    var DesignGallery = new Vue({
        el: '#design-gallery',
        directives: {
            imagesLoaded
        },
        data: function () {
            return {
                page: 0,
                tags: $('#design-gallery-tag-select').val(),
                scrollMaxPage: 999,
                scrollReady: true,
                scrollLoading: false,
                searchLoading: false,
                designId: $('#design-gallery').attr('data-design-id'),
                recentUrl: null,
                relatedUrl: null,
                wizardUrl: null,
            };
        },
        methods: {
            init: function () {
                $.ajaxSetup({ cache: false });
                $(window).scroll(function () {
                    if (DesignGallery.$data.scrollReady && DesignGallery.$data.page < DesignGallery.$data.scrollMaxPage && $(window).scrollTop() >= $(document).height() - $(window).height() - 300) {
                        console.log('scroll');
                        DesignGallery.$data.scrollLoading = true;
                        DesignGallery.$data.scrollReady = false;
                        DesignGallery.loadRecent();
                    }

                    if (DesignGallery.$data.page >= DesignGallery.$data.scrollMaxPage) {
                        DesignGallery.hideScroll();
                    }
                });

                $('#design-gallery-modal').on('hidden.bs.modal', function () {
                    DesignGallery.$data.designId = null;
                    DesignGallery.setUrl();
                });

                if (this.$data.designId) {
                    console.log('detected design id');
                    setTimeout(function () {
                        $('#design-gallery-modal').modal('show')
                    }, 100);
                }

                // Replace DOM with Vue
            },
            setUrls: function (recentUrl, relatedUrl, wizardUrl) {
                this.$data.recentUrl = recentUrl;
                this.$data.relatedUrl = relatedUrl;
                this.$data.wizardUrl = wizardUrl;
            },
            selectDesign: function (designId, event) {
                this.$data.designId = designId;

                this.setUrl();

                var info = JSON.parse($('.design-gallery-entry[data-design-gallery-id=' + designId + '] a').attr('data-info'));
                $(this.$refs.designDisplayName).text(info.name);
                $(this.$refs.designDisplayCode).text(info.code);
                $(this.$refs.designDisplayImageList).empty();
                this.$refs.designDisplayImage.src = '';
                setTimeout(() => {
                    this.$refs.designDisplayImage.src = info.images[0];
                }, 1);
                this.$refs.designDisplayWizard.href = this.$data.wizardUrl.replace('ID', info.id);

                for (var i = 0; i < info.images.length; i++) {
                    var designGalleryImageEntry = new DesignGalleryImageEntry();
                    designGalleryImageEntry.init(info.images[i]);
                    designGalleryImageEntry.$mount();
                    $(this.$refs.designDisplayImageList).append(designGalleryImageEntry.$el);
                }

                this.loadRelated();

                $('#design-gallery-modal').modal('show');
                if (event) {
                    event.preventDefault();
                }
            },
            setUrl: function () {
                var tagText = '';
                this.$data.tags.forEach(function (value) {
                    if (tagText) {
                        tagText += ',';
                    }
                    tagText += value;
                });
                var tagUrl = tagText ? '?tags=' + encodeURIComponent(tagText) : '';


                if (this.$data.designId) {
                    history.pushState('data', '', '/design-gallery/' + this.$data.designId + tagUrl);
                    return;
                }


                history.pushState('data', '', '/design-gallery' + tagUrl);
            },
            loadRecent: function () {
                console.log('Fetching recent data...');
                this.$data.page++;
                $.getJSON(this.$data.recentUrl + "?page=" + this.$data.page, function (data) {
                    var row = $('<div class="row" />');

                    for (var i = 0; i < data.data.length; i++) {
                        var itemData = data.data[i];
                        var designGalleryEntry = new DesignGalleryEntry();
                        designGalleryEntry.init(itemData);
                        designGalleryEntry.$mount();
                        row.append(designGalleryEntry.$el);
                    }

                    DesignGallery.$refs.designGalleryRecent.appendChild(row.get(0));
                    DesignGallery.$data.scrollLoading = false;
                    DesignGallery.$data.scrollReady = true;
                    DesignGallery.$data.scrollLoadBatchCount += 1;

                    if (data.data.length == 0) {
                        DesignGallery.hideScroll();
                    }
                });
            },
            loadRelated: function () {
                $(this.$refs.designDisplayRelated).find('.carousel-inner').remove();

                console.log('Fetching related data...');
                this.$data.page++;
                $.getJSON(this.$data.relatedUrl.replace('ID', this.$data.designId), function (data) {
                    var designGalleryRelated = new DesignGalleryRelated();
                    designGalleryRelated.init(data.data);
                    designGalleryRelated.$mount();
                    $(DesignGallery.$refs.designDisplayRelated).prepend(designGalleryRelated.$el);
                });
            },
            search: function (tags) {
                console.log('search: ' + tags.join(','));

                this.$refs.designGalleryResults.innerHTML = '';
                this.$data.searchLoading = true;

                this.$data.tags = tags;

                var tagText = '';
                tags.forEach(function (value) {
                    if (tagText) {
                        tagText += ',';
                    }
                    tagText += value;
                });

                $.getJSON(this.$data.recentUrl + "?tags=" + encodeURIComponent(tagText), function (data) {
                    var row = $('<div class="row" />');

                    for (var i = 0; i < data.data.length; i++) {
                        var itemData = data.data[i];
                        var designGalleryEntry = new DesignGalleryEntry();
                        designGalleryEntry.init(itemData);
                        designGalleryEntry.$mount();
                        row.append(designGalleryEntry.$el);
                    }

                    DesignGallery.$refs.designGalleryResults.appendChild(row.get(0));
                    DesignGallery.$data.searchLoading = false;
                });
            },
            hideScroll: function () {
                $('.scroll-down-spinner').hide();
                $('.scroll-down-container').hide();
            },
            selectImage: function (url, event) {
                this.$refs.designDisplayImage.src = url;
                if (event) {
                    event.preventDefault();
                }
            },
            imageProgress: function(instance, image) {
                if (image.isLoaded) {
                    $(instance.elements[0]).removeClass('image-loading');
                }
            }
        },
        mounted() {
            console.log('Design Gallery Mounted');
            this.init();
        }
    });

    window.DesignGallery = DesignGallery;
}