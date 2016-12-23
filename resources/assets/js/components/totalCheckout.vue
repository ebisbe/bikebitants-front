<template>
    <div>
        <ul id="totalCheckout" class="list-unstyled order-total">
            <li v-for="condition in list">{{ condition.name }}<span v-html="condition.value"></span></li>
        </ul>
    </div>
</template>

<script>

    export default {

        props: ['country', 'state'],

        data() {
            return {
                list: []
            }
        },

        created () {
            this.updateShipping(this.country, this.state);

            Bus.$on('shippingDestinationUpdate', this.shippingDestinationUpdate);
        },

        methods: {
            updateShipping: function (country, state) {
                this.$http.post('api/cart-conditions', {
                    'country': country,
                    'state': state
                }).then(function (response) {
                    this.list = response.body;
                });
            },
            shippingDestinationUpdate: function(data) {
                this.updateShipping(data.country, data.state);
            }
        }
    };

</script>