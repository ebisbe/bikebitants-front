<template>
    <div class="btn-group">
        <a aria-expanded="false"
           href="#"
           class="label dropdown-toggle {{ status.class }}"
           data-toggle="dropdown">
            <span v-if="!uploading">{{ status.text }}</span>
            <span v-else class="fa fa-spinner fa-spin"></span>
            <span class="caret"></span>
        </a>

        <ul class="dropdown-menu dropdown-menu-right">
            <li v-for="stat in status_list">
                <a v-if="stat.text != status.text" v-on:click="update(stat)" href="#">
                    <span class="status-mark {{ stat.class }} position-left"></span> {{ stat.text }}
                </a>
                <a v-else class="hidden">
                    <span class="status-mark {{ stat.class }} position-left"></span> {{ stat.text }}
                </a>
            </li>
        </ul>
    </div>
</template>

<script>

    export default {

        props: ['status_selected', 'product_id', 'token'],

        data() {
            return {
                status_list: [],
                status,
                uploading: false
            }
        },

        created: function () {
            $.getJSON('product/status', function (data) {
                this.status_list = data;
                this.status = data[this.status_selected];
            }.bind(this));
        },

        methods: {
            update: function (status) {
                this.uploading = true;
                var that = this;
                $.ajax({
                    url: 'product/' + this.product_id,
                    data: {
                        'status': status._id,
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