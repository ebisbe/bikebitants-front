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
                quantity: 1
            }
        },

        methods: {
            increment: function () {
                if (this.quantity < this.maxQuantity) {
                    this.quantity += 1;
                }
            },
            decrement: function () {
                if (this.quantity > 1) {
                    this.quantity -= 1;
                }
            }
        },

        watch: {
            maxQuantity: function () {
                if (this.quantity > this.maxQuantity) {
                    this.quantity = this.maxQuantity;
                }
                if (this.quantity == 0
                        && this.maxQuantity != 0) {
                    this.quantity = 1;
                }
            }
        }
    };
</script>