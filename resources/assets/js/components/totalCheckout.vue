<template>
    <ul id="totalCheckout" class="list-unstyled order-total">
        <li v-for="condition in list">{{ condition.name }}<span>{{{ condition.value }}}</span></li>
    </ul>
    <input type="hidden" id="vue-token" v-model="token">
    <input type="hidden" id="vue-country" v-model="country">
    <input type="hidden" id="vue-region" v-model="region">
</template>

<script>

    export default {

        props: ['token', 'country', 'region'],

        data() {
            return {
                list: []
            }
        },

        created: function () {
            $.getJSON('cart-conditions', function (data) {
                this.list = data;
            }.bind(this));
        },

        methods: {
            updateShipping: function() {
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
            'token': function (value) {},
            'country': function (value) {}
        }
    };

</script>