<template>
    <span class="badge">{{ length }}</span>
</template>

<script>

    export default {

        data() {
            return {
                length: 0
            }
        },

        created () {
            Bus.$on('prodLength', this.prodLength);
        },

        methods: {
            prodLength: function(length) {
                this.length = length;
            }
        }
    };

</script>