<template>
    <div class="btn-group">
        <a
           v-on:click="update()"
           v-if="!uploading">
            <span v-if="!is_featured" class="glyphicon glyphicon-star-empty"></span>
            <span v-else class="glyphicon glyphicon-star"></span>
        </a>
        <a v-else><span class="fa fa-spinner fa-spin"></span></a>
    </div>
</template>

<script>

    export default {

        props: ['is_featured', 'product_id', 'token'],

        data() {
            return {
                uploading: false
            }
        },

        methods: {
            update: function (status) {
                this.uploading = true;
                var that = this;
                this.is_featured = (this.is_featured === 1 || this.is_featured === '1') ? 0 : 1;
                $.ajax({
                    url: 'product/' + this.product_id,
                    data: {
                        'featured': this.is_featured,
                        '_token': this.token
                    },
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