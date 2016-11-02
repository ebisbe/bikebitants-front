<template>
    <form class="comment-form">
        <p class="comment-notes" v-html="$t('catalogue.email_not_published')"></p>
        <div class="row">
            <div class="form-group comment-form-author col-sm-6 {{ validation_name ? 'has-error' : '' }}">
                <label for="name" v-html="$t('catalogue.name')"></label>
                <input class="form-control" id="name" name="name" type="text" required value=""
                       placeholder="{{ $t('catalogue.name_placeholder') }}" v-model="name">
                <span v-show="validation_name" class="help-block">
                    <strong>{{ validation_name }}</strong>
                </span>
            </div>
            <div class="form-group comment-form-email col-sm-6 {{ validation_email ? 'has-error' : '' }}">
                <label for="email" v-html="$t('catalogue.email')"></label>
                <input class="form-control" id="email" name="email" type="email" required value=""
                       placeholder="{{ $t('catalogue.email_placeholder') }}" v-model="email">
                <span v-show="validation_email" class="help-block">
                    <strong>{{ validation_email }}</strong>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6 {{ validation_rating ? 'has-error' : '' }}">
                <label for="rating" v-html="$t('catalogue.rating')"></label>
                <select v-model.number="rating" name="rating" id="rating" class="form-control" required>
                    <option v-for="option in rating_options" value="{{ option }}">
                        {{ option }}
                    </option>
                </select>
                <span v-show="validation_rating" class="help-block">
                    <strong>{{ validation_rating }}</strong>
                </span>
            </div>
        </div>
        <div class="form-group comment-form-comment {{ validation_comment ? 'has-error' : '' }}">
            <label for="comment" v-html="$t('catalogue.comment')"></label>
            <textarea class="form-control" id="comment" name="comment" required
                      placeholder="{{ $t.('catalogue.comment_placeholder') }}" v-model="comment"></textarea>
            <span v-show="validation_name" class="help-block">
                    <strong>{{ validation_comment }}</strong>
                </span>
        </div>
        <button class="btn btn-primary" type="button" v-on:click="submit()"
                v-html="$t('catalogue.submit')">
        </button>
    </form>
</template>

<script>

    export default {

        props: ['product_id', 'token'],

        data() {
            return {
                'name': '',
                'validation_name': '',
                'email': '',
                'validation_email': '',
                'rating': 5,
                'validation_rating': '',
                'comment': '',
                'validation_comment': '',
                'rating_options': [5, 4, 3, 2, 1]
            }
        },

        methods: {
            submit: function () {
                $.ajax({
                    url: '/review',
                    data: {
                        'name': this.name,
                        'email': this.email,
                        'rating': this.rating,
                        'comment': this.comment,
                        'product_id': this.product_id,
                        '_token': this.token
                    },
                    method: 'post'
                })
                .done(function (jqXHR) {
                    this.list = jqXHR.responseJSON.response;
                }.bind(this))
                .fail(function (jqXHR) {
                    var response = jqXHR.responseJSON;
                    this.validation_name = response.name;
                    this.validation_email = response.email;
                    this.validation_rating = response.rating;
                    this.validation_comment = response.comment;
                }.bind(this))
                .always(function () {

                });
            }
        }
    };

</script>