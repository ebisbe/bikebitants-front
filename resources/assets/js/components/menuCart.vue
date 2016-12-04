<template>
    <li class="dropdown navbar-cart hidden-xs">
        <a href="#" id="js-cart" class="dropdown-toggle"
           data-toggle="dropdown"
           data-hover="dropdown"
           data-delay="300"
           data-close-others="true">
            <i class="fa fa-shopping-cart"></i>
        </a>

        <ul v-if="products.length" class="dropdown-menu">

            <li v-for="product in products">
                <div class="row">
                    <div class="col-sm-3">
                        <img v-bind:src="'/img/70/' + product.filename"
                             :alt="product.alt" class="img-responsive">
                    </div>
                    <div class="col-sm-9">
                        <h4>
                            <a :href="product.route">{{ product.name }}</a>
                        </h4>
                        <p v-html="priceLine(product)"></p>
                        <button @click="deleteProduct(product)" class="btn btn-link remove no-padding"
                                type="button">
                            <i class="fa fa-times-circle"></i>
                        </button>
                    </div>
                </div>
            </li>

            <!-- CART ITEM - START -->
            <li>
                <div class="row">
                    <div class="col-sm-6">
                        <a :href="cart" class="btn btn-primary btn-block">{{ $t('cart.view_cart') }}</a>
                    </div>
                    <div class="col-sm-6">
                        <a :href="checkout" class="btn btn-primary btn-block">{{ $t('cart.checkout') }}</a>
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
                        <a :href="shop"
                           class="btn btn-primary btn-block">{{ $t('cart.empty_cart') }}</a>
                    </div>
                </div>
            </li>
        </ul>
        <input type="hidden" id="vue-cart-update" v-model="resync">
    </li>
</template>

<script>

    export default {

        props: ['cart', 'checkout', 'shop'],

        data() {
            return {
                products: []
            }
        },

        created: function () {
            this.sync();
        },

        methods: {
            sync: function () {
                this.$http.get('/api/cart')
                        .then(function (response) {
                            console.log(response);
                            this.products = response.data;
                        });
            },

            deleteProduct: function (product) {
                var index = this.products.indexOf(product);
                this.products.splice(index, 1);
                this.$http.delete('/api/cart/' + product._id)
            },

            priceLine: function (product) {
                return product.quantity + 'x - ' + product.price + product.currency;
            }
        }
    };

</script>