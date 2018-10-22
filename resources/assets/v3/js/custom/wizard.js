if ($('#wizard').length > 0) {
    var WizardProduct = Vue.component('wizard-product', {
        template: '#wizard-product-template',
        data: function () {
            return {
                id: null,
                link: null,
                name: null,
                img: null,
                style: null,
                price:null,
                type: null,
                gender: null,
                size: null,
                description: null,
                colors: null,
                loading: false,
            };
        },
        methods: {
            init: function (data) {
                this.$data.id = data.id;
                this.$data.link = data.link;
                this.$data.name = data.name;
                this.$data.img = data.img;
                this.$data.style = data.style;
                this.$data.price = data.price;
                this.$data.type = data.type;
                this.$data.gender = data.gender;
                this.$data.size = data.size;
                this.$data.description = data.description;
                this.$data.colors = data.colors;
            },
            selectThisProduct: function ($event) {
                wizard.selectProduct(this.$data.id, $event);
            },
        }
    });
    var WizardProductColor = Vue.component('wizard-product-color', {
        template: '#wizard-product-color-template',
        data: function () {
            return {
                id: null,
                link: null,
                name: null,
                image: null,
                thumbnail: null,
                active: null,
            };
        },
        methods: {
            init: function (data) {
                this.$data.id = data.id;
                this.$data.link = data.link;
                this.$data.name = data.name;
                this.$data.image = data.image;
                this.$data.thumbnail = data.thumbnail;
                this.$data.active = data.active;
            },
            selectThisColor: function ($event) {
                wizard.selectColor(this.$data.id, $event);
            },
        }
    });

    var wizard = new Vue({
        el: '#wizard',
        data: function () {
            return {
                categoryId: $('.wizard-category.active').attr('data-wizard-category'),
                categoryDescription: $('.wizard-category.active').attr('data-wizard-category-description'),
                searchText: $('.wizard-search').val(),
                gender: $('.wizard-gender.active').attr('data-wizard-gender'),
                ajaxData: null,
                loading: false,
                productId: null,
                colorId: null,
                colorList: [],
            };
        },
        methods: {
            init: function () {
                var that = this;
                $('#wizard-product-modal').on('hidden.bs.modal', function () {
                    that.closeProduct();
                });
            },
            selectCategory: function (categoryId, categoryDescription, event) {
                this.$data.categoryId = categoryId;
                this.$data.categoryDescription = categoryDescription;

                this.setUrl();
                this.setListItemActive('.wizard-category', ".wizard-category[data-wizard-category='" + this.$data.categoryId + "']");
                this.query();
                if (event) {
                    event.preventDefault();
                }
            },
            selectGender: function (genderCode, event) {
                this.$data.gender = genderCode;

                this.setUrl();
                this.setListItemActive('.wizard-gender', ".wizard-gender[data-wizard-gender='" + this.$data.gender + "']");
                this.query();
                if (event) {
                    event.preventDefault();
                }
            },
            search: function (event) {
                this.setUrl();
                this.query();
                if (event) {
                    event.preventDefault();
                }
            },
            selectProduct: function (productId, event) {
                this.$data.productId = productId;

                var name = this.$el.querySelector(".wizard-product[data-wizard-id='" + productId + "']").attributes['data-wizard-name'].value;
                var img = this.$el.querySelector(".wizard-product[data-wizard-id='" + productId + "']").attributes['data-wizard-img'].value;
                var style = this.$el.querySelector(".wizard-product[data-wizard-id='" + productId + "']").attributes['data-wizard-style'].value;
                var price = this.$el.querySelector(".wizard-product[data-wizard-id='" + productId + "']").attributes['data-wizard-price'].value;
                var size = this.$el.querySelector(".wizard-product[data-wizard-id='" + productId + "']").attributes['data-wizard-size'].value;
                var description = this.$el.querySelector(".wizard-product[data-wizard-id='" + productId + "']").attributes['data-wizard-description'].value;
                var colors = this.$el.querySelector(".wizard-product[data-wizard-id='" + productId + "']").attributes['data-wizard-colors'].value;
                var colorListData = JSON.parse(colors);

                this.$el.querySelector(".wizard-product-name").innerHTML = name;
                this.$el.querySelector(".wizard-product-style").innerHTML = style;
                this.$el.querySelector(".wizard-product-price .text").innerHTML = price;
                this.$el.querySelector(".wizard-product-color-name").innerHTML = colorListData.length > 0 ? colorListData[0].name : '';
                this.$el.querySelector(".wizard-product-preview").src = '';
                this.$el.querySelector(".wizard-product-preview").src = colorListData.length > 0 ? colorListData[0].image : img;
                this.$el.querySelector(".wizard-product-size .text").innerHTML = size;
                this.$el.querySelector(".wizard-product-description").innerHTML = this.htmlEntities(description);
                this.$el.querySelector(".wizard-product-color-id").attributes['value'].value = this.htmlEntities(colorListData.length > 0 ? colorListData[0].id : '');

                this.$el.querySelector('.wizard-product-color-list').innerHTML = '';
                this.$data.colorList = [];
                for (var i = 0; i < colorListData.length; i++) {
                    var data = colorListData[i];
                    data.link = this.getColorUrl(colorListData[i].id);
                    data.active = i == 0;
                    var productColor = new WizardProductColor();
                    productColor.init(data);
                    productColor.$mount();
                    this.$refs.wizardProductColorList.appendChild(productColor.$el);
                    this.$data.colorList.push(productColor);
                }

                if (colorListData.length > 0) {
                    this.$data.colorId = colorListData[0].id;
                }
                this.setUrl();

                $('#wizard-product-modal').modal('show');
                if (event) {
                    event.preventDefault();
                }
            },
            selectColor: function (colorId, event) {
                this.$data.colorId = colorId;
                if (this.$data.colorList.length == 0) {
                    return;
                }
                for (var i = 0; i < this.$data.colorList.length; i++) {
                    if (this.$data.colorList[i].$data.id == colorId) {
                        this.$data.colorList[i].$data.active = true;
                        this.$el.querySelector(".wizard-product-color-name").innerHTML = this.$data.colorList[i].$data.name;
                        this.$el.querySelector(".wizard-product-preview").attributes['src'].value = this.$data.colorList[i].$data.image;

                    } else {
                        this.$data.colorList[i].$data.active = false;
                    }
                }
                this.setUrl();

                $('.wizard-product-color-id').val(this.$data.colorId);
                if (event) {
                    event.preventDefault();
                }
            },
            closeProduct: function () {
                this.$data.colorId = null;
                this.$data.productId = null;
                this.setUrl();
            },
            getColorUrl: function (colorId) {
                return '/wizard/product/' + this.$data.productId + '?c=' + colorId;
            },
            setUrl: function () {
                if (this.$data.productId) {
                    history.pushState('data', '', '/wizard/product/' + this.$data.productId + (this.$data.productId ? '?c=' + this.$data.colorId : ''));
                    return;
                }

                var parameters = [];
                if (this.$data.searchText) {
                    parameters.push('q=' + encodeURIComponent(this.$data.searchText));
                }
                if (this.$data.gender) {
                    parameters.push('g=' + encodeURIComponent(this.$data.gender));
                }

                history.pushState('data', '', '/wizard/product/category/' + this.buildUrlSufix());
            },
            setListItemActive: function (itemsSelector, activeSelector) {
                var items = this.$el.querySelectorAll(itemsSelector);
                for (var i = 0; i < items.length; i++) {
                    items[i].classList.remove('active');
                }

                this.$el.querySelector(activeSelector).classList.add('active');
            },
            buildUrlSufix: function () {
                var parameters = [];
                if (this.$data.searchText) {
                    parameters.push('q=' + encodeURIComponent(this.$data.searchText));
                }
                if (this.$data.gender) {
                    parameters.push('g=' + encodeURIComponent(this.$data.gender));
                }

                return this.$data.categoryDescription + (parameters.length > 0 ? '?' + parameters.join('&') : '');
            },
            query: function () {
                var parameters = [];
                if (this.$data.searchText) {
                    parameters.push('q=' + encodeURIComponent(this.$data.searchText));
                }
                if (this.$data.gender) {
                    parameters.push('g=' + encodeURIComponent(this.$data.gender));
                }

                this.$el.querySelector('.wizard-products').innerHTML = '';
                this.$data.loading = true;

                var that = this;
                this.$http.get('/ajax/wizard-products/' + this.buildUrlSufix(), {
                    responseType: 'text'
                }).then(function (response) {
                    that.$data.ajaxData = response.data;

                    that.updateProducts();
                    that.$data.loading = false;
                });
            },
            updateProducts: function () {
                this.$el.querySelector('.wizard-products').innerHTML = '';
                for (var i = 0; i < this.$data.ajaxData.data.length; i++) {
                    var data = this.$data.ajaxData.data[i];

                    var product = new WizardProduct();
                    product.init(data);
                    product.$mount();
                    this.$refs.wizardProductList.appendChild(product.$el);
                }
            },
            htmlEntities: function (string) {
                return String(string).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
            }
        },
        mounted() {
            console.log('Wizard Mounted');
            this.init();
        }
    });

    window.wizard = wizard;
}