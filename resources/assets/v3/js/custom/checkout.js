if ($('#checkout').length > 0) {
    window.checkout = new Vue({
        el: '#checkout',
        data: function () {
            return {
                // Proofs
                product: null,
                color: null,
                proof: null,
                info: null,

                // Countdown
                days: null,
                hours: null,
                minutes: null,
                seconds: null,
            };
        },
        methods: {
            init: function () {
                // Proofs
                this.$data.info = JSON.parse($('#checkout').attr('data-proofs'));

                if ($('#checkout').attr('data-selected-color')) {
                    var productIndex = null;
                    var productColorIndex = null;
                    for (var i = 0; i < this.$data.info.length; i++) {
                        for (var j = 0; j < this.$data.info[i].colors.length; j++) {
                            if (this.$data.info[i].colors[j].id ==$('#checkout').attr('data-selected-color')) {
                                productIndex = i;
                                productColorIndex = j;
                            }
                        }
                    }

                    this.$data.product = this.$data.info[productIndex].id;
                    this.$data.color = this.$data.info[productIndex].colors[productColorIndex].id;
                    this.$data.proof = this.$data.info[productIndex].colors[productColorIndex].proofs[0].id;
                } else {
                    this.$data.product = this.$data.info[0].id;
                    this.$data.color = this.$data.info[0].colors[0].id;
                    this.$data.proof = this.$data.info[0].colors[0].proofs[0].id;
                }

                // Countdown
                this.$data.days = $('#countdown').attr('data-days');
                this.$data.hours = $('#countdown').attr('data-hours');
                this.$data.minutes = $('#countdown').attr('data-minutes');
                this.$data.seconds = $('#countdown').attr('data-seconds');

                setInterval(function() { window.checkout.tick(); }, 1000);
            },
            selectProduct: function (productId) {
                this.$data.product = parseInt(productId);

                this.fixColor();
                this.fixProof();
                this.fixSlider();
            },
            selectColor: function (colorId) {
                this.$data.color = colorId;

                this.fixProof();
                this.fixSlider();
            },
            selectProof: function (proofId) {
                this.$data.proof = proofId;

                this.fixSlider();
            },
            fixColor: function () {
                // make sure the selected color belongs to the selected product
                for (var productIndex = 0; productIndex < this.$data.info.length; productIndex++) {
                    if (this.$data.info[productIndex].id == this.$data.product) {
                        for (var colorIndex = 0; colorIndex < this.$data.info[productIndex].colors.length; colorIndex++) {
                            if (this.$data.color == this.$data.info[productIndex].colors[colorIndex].id) {
                                // Already Good
                                return;
                            }
                        }
                        // Fix
                        this.$data.color = this.$data.info[productIndex].colors[0].id;
                        return;
                    }
                }
            },
            fixProof: function () {
                // make sure the selected proof belongs to the selected color
                for (var productIndex = 0; productIndex < this.$data.info.length; productIndex++) {
                    if (this.$data.info[productIndex].id == this.$data.product) {
                        for (var colorIndex = 0; colorIndex < this.$data.info[productIndex].colors.length; colorIndex++) {
                            if (this.$data.color == this.$data.info[productIndex].colors[colorIndex].id) {
                                for (var proofIndex = 0; proofIndex < this.$data.info[productIndex].colors[colorIndex].proofs.length; proofIndex++) {
                                    if (this.$data.proof == this.$data.info[productIndex].colors[colorIndex].proofs[proofIndex].id) {
                                        // Already Good
                                        return;
                                    }
                                }
                                // Fix
                                this.$data.proof = this.$data.info[productIndex].colors[colorIndex].proofs[0].id;
                                return;
                            }
                        }
                    }
                }
            },
            fixSlider: function () {
                var proofIndex = 0;

                for (var productIndex = 0; productIndex < this.$data.info.length; productIndex++) {
                    if (this.$data.info[productIndex].id == this.$data.product) {
                        for (var colorIndex = 0; colorIndex < this.$data.info[productIndex].colors.length; colorIndex++) {
                            if (this.$data.color == this.$data.info[productIndex].colors[colorIndex].id) {
                                for (proofIndex = 0; proofIndex < this.$data.info[productIndex].colors[colorIndex].proofs.length; proofIndex++) {
                                    if (this.$data.proof == this.$data.info[productIndex].colors[colorIndex].proofs[proofIndex].id) {
                                        break;
                                    }
                                }
                                break;
                            }
                        }
                    }
                }

                $('#checkout #carousel-' + this.$data.product + '-' + this.$data.color).carousel(proofIndex);
            },
            tick: function () {
                this.$data.seconds--;
                if (this.$data.seconds < 0) {
                    this.$data.seconds = 59;
                    this.$data.minutes--;
                    if (this.$data.minutes < 0) {
                        this.$data.minutes = 59;
                        this.$data.hours--;
                        if (this.$data.hours < 0) {
                            this.$data.hours = 23;
                            this.$data.days--;
                            if (this.$data.days < 0) {
                                this.$data.seconds = 0;
                                this.$data.minutes = 0;
                                this.$data.hours = 0;
                                this.$data.days = 0;
                            }
                        }
                    }
                }
            },
        },
        mounted() {
            console.log('Checkout Mounted');
            this.init();
        }
    });
}