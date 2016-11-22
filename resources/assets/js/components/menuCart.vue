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
                    <form method="POST" action="/cart/{{ product._id }}">
                        <input type="hidden" name="_method" value="DELETE"/>
                        <input type="hidden" name="_token" value="{{ _token }}">
                        <button class="btn btn-link remove no-padding" type="submit">
                            <i class="fa fa-times-circle"></i>
                        </button>
                    </form>
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
</template>

<script>

    export default {

        props: [],

        data() {
            return {
                products: [],
                _token: '',
                cart: '',
                checkout: '',
                shop: ''
            }
        },

        created: function () {
            $.getJSON('/cart', function (data) {
                this.products = data.products;
                this._token = data._token;
                this.cart = data.cart;
                this.checkout = data.checkout;
                this.shop = data.shop;
            }.bind(this));
        },

        methods: {
            updateShipping: function () {
                $.ajax({
                            url: 'cart-conditions',
                            data: {
                                'country': this.country,
                                'region': this.region,
                                '_token': this.token
                            },
                            method: 'post'
                        })
                        .done(function (jqXHR) {
                            this.list = jqXHR;
                        }.bind(this))
                        .fail(function (jqXHR) {

                        })
                        .always(function () {

                        });
            }
        },

        watch: {
            'region': function () {
                this.updateShipping();
            },
            'token': function (value) {
            },
            'country': function (value) {
            }
        }
    };

</script>