if ($('#add-to-cart').length > 0) {
    var CheckoutAddToCartLine = Vue.component('add-to-card-line', {
        template: '#add-to-cart-line-template',
        data: function () {
            return {
                colorId: null,
                sizeId: null,
                sizeText: 'M',
                quantity: 1,
                image: null,
                price: null,
                info: null,
                sizes: null,
                colors: null,
            };
        },
        methods: {
            init: function (data) {
                this.$data.info = data.info;

                this.$data.colors = [];
                for (var productIndex = 0; productIndex < this.$data.info.length; productIndex++) {
                    for (var colorIndex = 0; colorIndex < this.$data.info[productIndex].colors.length; colorIndex++) {
                        this.$data.colors.push({
                            text: this.$data.info[productIndex].name + ' - ' + this.$data.info[productIndex].colors[colorIndex].name,
                            value: this.$data.info[productIndex].colors[colorIndex].id
                        });
                    }
                }

                var colorId = data.info[0].colors[0].id;
                if (typeof data.colorId != 'undefined') {
                    colorId = data.colorId;
                }

                if ($('#add-to-cart').attr('data-selected-color')) {
                    colorId = $('#add-to-cart').attr('data-selected-color');
                }

                this.selectColor(colorId);
                this.$nextTick(function () {
                    this.watchRemoveLines();
                });
            },
            changeSize: function (event) {
                if (event) {
                    event.preventDefault();
                }

                this.updatePrice();
            },
            updatePrice: function () {
                for (var productIndex = 0; productIndex < this.$data.info.length; productIndex++) {
                    for (var colorIndex = 0; colorIndex < this.$data.info[productIndex].colors.length; colorIndex++) {
                        if (this.$data.colorId == this.$data.info[productIndex].colors[colorIndex].id) {
                            var sizeExtraCharge = 0;
                            for (var sizeIndex = 0; sizeIndex < this.$data.info[productIndex].sizes.length; sizeIndex++) {
                                if (this.$data.info[productIndex].sizes[sizeIndex].id == this.$data.sizeId) {
                                    sizeExtraCharge = parseFloat(this.$data.info[productIndex].sizes[sizeIndex].extra);
                                }
                            }

                            this.$data.price = '$' + (this.$data.info[productIndex].price + sizeExtraCharge);
                        }
                    }
                }
            },
            changeColor: function (event) {
                if (event) {
                    event.preventDefault();
                }

                this.selectColor(this.$data.colorId);
            },
            selectColor: function (colorId) {
                for (var productIndex = 0; productIndex < this.$data.info.length; productIndex++) {
                    for (var colorIndex = 0; colorIndex < this.$data.info[productIndex].colors.length; colorIndex++) {
                        if (this.$data.info[productIndex].colors[colorIndex].id == colorId) {
                            this.$data.colorId = colorId;
                            this.$data.image = this.$data.info[productIndex].colors[colorIndex].image;
                            this.$data.price = '$' + this.$data.info[productIndex].price;

                            // Reset Size
                            var currentSizeText = this.$data.sizeText;
                            var currentSizeIndex = null;
                            this.$data.sizeText = null;
                            this.$data.sizeId = null;

                            this.$data.sizes = [];
                            for (var sizeIndex = 0; sizeIndex < this.$data.info[productIndex].sizes.length; sizeIndex++) {
                                this.$data.sizes.push({
                                    text: this.$data.info[productIndex].sizes[sizeIndex].name,
                                    value: this.$data.info[productIndex].sizes[sizeIndex].id
                                });
                                if (this.$data.info[productIndex].sizes[sizeIndex].name == currentSizeText) {
                                    currentSizeIndex = sizeIndex;
                                }
                            }

                            if (currentSizeIndex !== null) {
                                this.$data.sizeId = this.$data.info[productIndex].sizes[currentSizeIndex].id;
                                this.$data.sizeText = this.$data.info[productIndex].sizes[currentSizeIndex].name;
                            }

                            if (this.$data.sizeId == null) {
                                this.$data.sizeId = this.$data.info[productIndex].sizes[0].id;
                                this.$data.sizeText = this.$data.info[productIndex].sizes[0].name;
                            }
                            this.updatePrice();
                            return;
                        }
                    }
                }
            },
            removeThisLine: function (event) {
                if (event) {
                    event.preventDefault();
                }

                $(this.$el).remove();
                this.$nextTick(function () {
                    this.watchRemoveLines();
                });
            },
            watchRemoveLines: function () {
                if (this.canRemoveLines()) {
                    $('.add-to-line-remove').show();
                } else {
                    $('.add-to-line-remove').hide();
                }
            },
            canRemoveLines: function () {
                return $('.add-to-cart-line').length > 1;
            }
        }
    });

    window.checkoutAddToCart = new Vue({
        el: '#add-to-cart',
        data: function () {
            return {
                info: null,
            };
        },
        methods: {
            init: function () {
                this.$data.info = JSON.parse($('#add-to-cart').attr('data-products'));

                this.addLine();
            },
            addLine: function (event) {
                if (event) {
                    event.preventDefault();
                }

                var data = {
                    info: this.$data.info
                };

                var line = new CheckoutAddToCartLine();
                line.init(data);
                line.$mount();
                this.$refs.lineList.appendChild(line.$el);
            },
        },
        mounted() {
            console.log('Add To Cart Mounted');
            this.init();
        }
    });
}