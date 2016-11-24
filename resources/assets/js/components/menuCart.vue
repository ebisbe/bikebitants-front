<template>
    <ul v-if="products.length" class="dropdown-menu">

        <li v-for="product in products">
            <div class="row">
                <div class="col-sm-3">
                    <img v-bind:src="'/img/70/' + product.filename"
                         alt="{{ product.alt }}" class="img-responsive">
                </div>
                <div class="col-sm-9">
                    <h4>
                        <a href="{{ product.route }}">{{ product.name }}</a>
                    </h4>
                    <p>{{ product.quantity }}x - {{ product.price }}{{{ product.currency }}}</p>
                    <button @click="delete(product._id)" class="btn btn-link remove no-padding" type="button">
                        <i class="fa fa-times-circle"></i>
                    </button>
                </div>
            </div>
        </li>

        <!-- CART ITEM - START -->
        <li>
            <div class="row">
                <div class="col-sm-6">
                    <a href="{{ cart }}" class="btn btn-primary btn-block">{{ $t('cart.view_cart') }}</a>
                </div>
                <div class="col-sm-6">
                    <a href="{{ checkout }}" class="btn btn-primary btn-block">{{ $t('cart.checkout') }}</a>
                </div>
            </div>
        </li>
        <!-- CART ITEM - END -->

    </ul>

    <ul v-else class="dropdown-menu">
        <li>{{ $t('cart.empty_cart_h1') }}</li>
        <li>
            <div class="row">
                <div class="col-sm-12">
                    <a href="{{ shop }}"
                       class="btn btn-primary btn-block">{{ $t('cart.empty_cart') }}</a>
                </div>
            </div>
        </li>
    </ul>
    <input type="hidden" id="vue-cart-update" v-model="resync">

</template>

<script>

    export default {

        data() {
            return {
                products: [],
                _token: '',
                cart: '',
                checkout: '',
                shop: '',
                resync: ''
            }
        },

        created: function () {
            this.sync();
        },

        methods: {
            sync: function () {
                $.getJSON('/cart', function (data) {
                    this.update(data);
                }.bind(this));
            },

            update: function (data) {
                console.log(data);
                this.products = data.products;
                this._token = data._token;
                this.cart = data.cart;
                this.checkout = data.checkout;
                this.shop = data.shop;
                $('#js-cart').mouseover();
            },

            delete: function (id) {
                $.ajax({
                            url: '/cart/' + id,
                            data: {
                                '_method': 'DELETE',
                                '_token': this._token
                            },
                            method: 'post'
                        })
                        .done(function (jqXHR) {
                            this.update(jQuery.parseJSON(jqXHR));
                        }.bind(this))
                        .fail(function (jqXHR) {

                        })
                        .always(function () {

                        }.bind(this));
            }
        },

        watch: {
            'resync': function () {
                this.update(jQuery.parseJSON(this.resync));
            }
        }
    };

</script>