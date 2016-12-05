<template>
    <button :class="button_class"
            @click.prevent="addProduct()"
            :disabled="disabled"
    >
        <i v-if="show_icon" :class="iClass"></i>
        <span v-html="$t(text)"></span>
    </button>

    <button @click="deleteProduct(product)"
            class="btn btn-link remove no-padding"
            type="button">
        <i class="fa fa-times-circle"></i>
    </button>

    <button class="btn btn-transparent" type="submit">
        <i class="fa fa-times"></i>
    </button>

</template>
<script>
    export default {
        props: ['product'],

        data() {
            return {
                iClass: {
                    fa: true,
                    'fa-shopping-cart': true,
                    'fa-spinner': false,
                    'fa-spin': false
                },
                disabled: false
            }
        },

        methods: {
            addProduct: function () {
                var product = {
                    'quantity': this.quantity,
                    'product_id': this.product_id,
                    'properties': this.properties
                };

                this.prePost();
                this.$http.post('/api/cart/', product)
                        .then(function (response) {
                            this.postPost();
                            Bus.$emit('addProduct', response.data);
                        });
            },

            prePost: function () {
                this.disabled = true;
                this.iClass['fa-shopping-cart'] = false;
                this.iClass['fa-spinner'] = true;
                this.iClass['fa-spin'] = true;
            },

            postPost: function () {
                this.disabled = false;
                this.iClass['fa-shopping-cart'] = true;
                this.iClass['fa-spinner'] = false;
                this.iClass['fa-spin'] = false;
            }
        }
    };
</script>