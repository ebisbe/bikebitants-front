<template>
    <div class="form-group product-quantity">

        <a class="btn btn-default" @click="decrement">-</a>
        <input class="form-control" id="qty" name="quantity" v-model="quantity" type="text">
        <a class="btn btn-default" @click="increment">+</a>
    </div>
</template>

<script>

    export default {

        props: ['maxQuantity'],

        data() {
            return {
                quantity: 0
            }
        },

        methods: {
            increment: function () {
                this.quantity += 1;
                if (this.quantity > this.maxQuantity) {
                    this.decrement();
                }
            },

            decrement: function () {
                if (this.quantity >= 1) {
                    this.quantity -= 1;
                }
            },

            checkQuantity: function () {
                if (this.quantity > this.maxQuantity) {
                    this.quantity = this.maxQuantity;
                }
            }
        },

        watch: {
            maxQuantity: function () {
                this.checkQuantity();
            },
            quantity: function () {
                this.checkQuantity();
            }
        }
    };

</script>