<template>
    <div class="form-group product-quantity">
        <a class="btn btn-default" @click="decrement">-</a>
        <input class="form-control"
               id="qty"
               name="quantity"
               v-model="quantity"
               type="text">
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
                    this.changed();
                }
            },
            decrement: function () {
                if (this.quantity > 1) {
                    this.quantity -= 1;
                    this.changed();
                }
            },
            changed: function() {
                this.$emit('changedQuantity', this.quantity);
            }
        },

        watch: {
            maxQuantity: function () {
                if (this.quantity > this.maxQuantity) {
                    this.quantity = this.maxQuantity;
                    this.changed();
                }
                if (this.quantity == 0
                        && this.maxQuantity != 0) {
                    this.quantity = 1;
                    this.changed();
                }
            }
        }
    };
</script>