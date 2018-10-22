var PMSColorContainer = {
    init: function () {
        var container = this;

        this.PMSColorEntry = Vue.component('pms-entry', {
            template: '#pms-entry-template',
            data: function () {
                return {
                    code: null,
                    caption: null,
                    pmsList: null
                };
            },
            methods: {
                init: function (data, pmsList) {
                    this.$data.code = data.code;
                    this.$data.caption = data.caption;
                    this.$data.pmsList = pmsList;
                },
                deleteThisEntry: function ($event) {
                    this.$data.pmsList.deleteEntry(this.$data.code);
                },
            }
        });

        $('.pms-color-list').each(function () {
            container.initPMSColorList('#' + this.id);
        });
    },
    initPMSColorList: function (element) {
        var container = this;

        var PMSColorList = new Vue({
            el: element,
            data: function () {
                return {
                    data: $(element + ' .pms-color-hidden').val(),
                    captions: [],
                    colorList: []
                };
            },
            methods: {
                init: function () {
                    var pmsColorList = this;
                    this.$data.colorList = this.decommify(this.$data.data);

                    var captionValues = this.decommify($(element + ' .pms-color-hidden-captions').val());
                    this.$data.captions = [];
                    for (var i = 0; i < captionValues.length; i++) {
                        this.$data.captions[this.$data.colorList[i]] = captionValues[i];
                    }

                    $(this.$el).find('input[type=text]').keydown(function (event) {
                        if (event.which == 13) {
                            event.preventDefault();
                            var value = $(this).val();
                            var caption = value;

                            var matches = value.match(/(.*) \(([#a-zA-Z0-9]*)\)/);
                            if (matches && matches[2]) {
                                value = matches[2];
                                caption = matches[1];
                            }

                            value = value.trim().toLowerCase().replace(/[^A-Fa-f0-9]/g, '');
                            if (value.length != 3 && value.length != 6) {
                                return false;
                            }
                            value = '#' + value;
                            pmsColorList.addColor(value, caption);
                            var that = this;
                            setTimeout(function () {
                                $(that).val('');
                                $(that).autocomplete('close');
                            }, 10);

                            return false;
                        }
                    });

                    this.updateColorElements();
                },
                addColor: function (code, caption) {
                    this.$data.colorList.push(code);
                    this.$data.data = this.commify(this.$data.colorList);
                    this.$data.captions[code] = caption;
                    this.updateColorElements();
                },
                deleteEntry: function (code) {
                    var index = this.$data.colorList.indexOf(code);
                    if (index > -1) {
                        this.$data.colorList.splice(index, 1);
                    }
                    this.$data.data = this.commify(this.$data.colorList);
                    this.updateColorElements();
                },
                updateColorElements: function () {
                    this.emptyColorElements();

                    for (var i = 0; i < this.$data.colorList.length; i++) {
                        this.addColorElement(this.$data.colorList[i]);
                    }
                    $(this.$refs.pmsColorCount).text(this.$data.colorList.length);
                },
                addColorElement: function (code) {
                    var pmsEntry = new container.PMSColorEntry();
                    pmsEntry.init({code: code, caption: this.$data.captions[code]}, this);
                    pmsEntry.$mount();
                    this.$refs.pmsEntryList.appendChild(pmsEntry.$el);

                    return pmsEntry;
                },
                emptyColorElements: function () {
                    $(this.$refs.pmsEntryList).html('');
                },
                commify: function (values) {
                    if (values.length == 0) {
                        return '';
                    }
                    if (values.length == 1) {
                        return values[0];
                    }
                    for (var i = 0; i < values.length; i++) {
                        values[i].trim();
                    }

                    return values.filter(function (e) {
                        return e;
                    }).join();
                },
                decommify: function (value) {
                    var colors = value.split(',');
                    for (var i = 0; i < colors.length; i++) {
                        colors[i] = colors[i].trim();
                    }

                    return colors.filter(function (e) {
                        return e;
                    });
                }
            },
            mounted() {
                console.log('PMS Color List Mounted');
                this.init();
            }
        });
    },
};

window.PMSColorContainer = PMSColorContainer;


