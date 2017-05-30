<template>
    <li class="dropdown navbar-cart hidden-xs">
        <a href="#" id="js-cart" class="dropdown-toggle"
           data-toggle="dropdown"
           data-hover="dropdown"
           data-delay="300"
           data-close-others="true">
            <i class="fa fa-shopping-cart"></i> <cart-badge></cart-badge>
        </a>

        <ul v-if="products.length" class="dropdown-menu">

            <li v-for="product in products">
                <div class="row">
                    <div class="col-sm-3">
                        <img v-bind:src="product.file"
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
                        <a :href="cart" class="btn btn-inverse btn-block">{{ $t('cart.view_cart') }}</a>
                    </div>
                    <div class="col-sm-6">
                        <a :href="checkout" class="btn btn-primary btn-block">{{ $t('cart.checkout') }}</a>
                    </div>
                </div>
            </li>
            <!-- CART ITEM - END -->

        </ul>

        <ul v-else class="dropdown-menu">
            <li>{{ $t('cart.empty_cart') }}</li>
            <li>
                <div class="row">
                    <div class="col-sm-12">
                        <a :href="shop"
                           class="btn btn-primary btn-block">{{ $t('cart.empty_cart') }}</a>
                    </div>
                </div>
            </li>
        </ul>
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

        created () {
            this.$http.get('/api/cart')
                    .then(function (response) {
                        this.products = response.data;
                    });
            Bus.$on('addProduct', this.addProduct);
        },

        methods: {
            deleteProduct: function (product) {
                var index = this.products.indexOf(product);
                this.products.splice(index, 1);
                Bus.$emit('prodLength', this.products.length );
                this.$http.delete('/api/cart/' + product._id)
                        .then(function () {
                            $('#js-cart').dropdown('toggle');
                            this.notifyGA('remove', product)
                        });

            },

            priceLine: function (product) {
                var stock = product.is_max_stock ? ' <small>( Max stock )</small>' : '';
                return product.quantity + 'x - ' + product.price + product.currency + ' ' + stock;
            },

            addProduct: function (product) {
                _.remove(this.products, function (n) {
                    return product._id == n._id;
                });
                this.products.push(product);
                $('#js-cart').dropdown('toggle');
                this.notifyGA('add', product)
                Bus.$emit('prodLength', this.products.length );
            },

            notifyGA: function(type, product) {
                let prod = {
                    'id': product._id,
                    'name': product.name,
                    'category': product.category,
                    'brand': product.brand,
                    'price': product.price,
                    'quantity': product.quantity
                };
                ga('ec:addProduct', prod);

                ga('ec:setAction', type);
                ga('send', 'event', 'UX', 'click', type + ' cart');
            }
        }
    };

</script>