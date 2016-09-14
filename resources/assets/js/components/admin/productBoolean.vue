<template>
    <div class="btn-group">
        <a
           v-on:click="update()"
           v-if="!uploading">
            <span v-if="value" class="{{ true_class }}"></span>
            <span v-else class="{{ false_class }}"></span>
        </a>
        <a v-else><span class="fa fa-spinner fa-spin"></span></a>
    </div>
</template>

<script>

    export default {

        props: ['name_value', 'value', 'product_id', 'token', 'true_class', 'false_class'],

        data() {
            return {
                uploading: false
            }
        },

        methods: {
            update: function (status) {
                this.uploading = true;
                var that = this;
                this.value = (this.value === 1 || this.value === '1') ? 0 : 1;
                var data = {
                    '_token': this.token
                };
                data[this.name_value] = this.value;
                $.ajax({
                    url: 'product/' + this.product_id,
                    data: data,
                    method: 'PATCH'
                })
                .done(function (data) {
                    new PNotify({
                        title: 'Primary notice',
                        text: data.message,
                        addclass: 'alert-styled-right',
                        type: 'success'
                    });
                    that.status = status;
                })
                .fail(function (data) {
                    new PNotify({
                        title: 'Error notice',
                        text: data.responseText,
                        addclass: 'alert-styled-right',
                        type: 'error'
                    });
                })
                .always(function () {
                    that.uploading = false;
                });
            }
        }
    };

</script>