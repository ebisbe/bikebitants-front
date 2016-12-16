<template>
    <div class="">
        <ul id="totalCheckout" class="list-unstyled order-total">
            <li v-for="condition in list">{{ condition.name }}<span v-html="condition.value"></span></li>
        </ul>
        <input type="hidden" id="vue-country" v-model="country">
        <input type="hidden" id="vue-state" v-model="state">
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

        created: function () {
            this.$http.get('api/cart-conditions')
                    .then(function (response) {
                        this.list = response.data;
                    });
        },

        methods: {
            updateShipping: function () {
                console.log('hola!');
                this.$http.post('api/cart-conditions', {
                    'country': this.country,
                    'sate': this.state
                }).then(function (response) {
                    this.$set('list', response.body);
                });
            }
        },

        watch: {
            'state': function () {
                this.updateShipping();
            }
        }
    };

</script>