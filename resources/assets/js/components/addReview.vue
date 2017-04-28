<template>
    <form class="comment-form" v-if="!added_review">
        <p class="comment-notes" v-html="$t('catalogue.email_not_published')"></p>
        <div class="row">
            <div :class="['form-group', 'comment-form-author', 'col-sm-6' , validation.name.length ? 'has-error': '' ]">
                <label for="name" v-html="$t('catalogue.name')"></label>
                <input class="form-control" id="name" name="name" type="text" required value=""
                       :placeholder="$t('catalogue.name_placeholder')" v-model="name">
                <span v-show="validation.name" class="help-block">
                    <strong>{{ validation.name.join('') }}</strong>
                </span>
            </div>
            <div :class="['form-group', 'comment-form-email', 'col-sm-6', validation.email.length ? 'has-error': '' ]">
                <label for="email" v-html="$t('catalogue.email')"></label>
                <input class="form-control" id="email" name="email" type="email" required value=""
                       :placeholder="$t('catalogue.email_placeholder')" v-model="email">
                <span v-show="validation.email" class="help-block">
                    <strong>{{ validation.email.join('') }}</strong>
                </span>
            </div>
        </div>
        <div class="row">
            <div :class="['form-group', 'col-sm-6' ]">
                <label for="rating" v-html="$t('catalogue.rating')"></label>
                <select v-model.number="rating" name="rating" id="rating" class="form-control" required>
                    <option v-for="option in rating_options" :value="option">
                        {{ option }}
                    </option>
                </select>
            </div>
        </div>
        <div :class="['form-group', 'comment-form-comment', validation.comment.length ? 'has-error': '' ]">
            <label for="comment" v-html="$t('catalogue.comment')"></label>
            <textarea class="form-control" id="comment" name="comment" required
                      :placeholder="$t('catalogue.comment_placeholder')" v-model="comment"></textarea>
            <span v-show="validation.comment" class="help-block">
                    <strong>{{ validation.comment.join('') }}</strong>
                </span>
        </div>
        <button class="btn btn-primary" type="button" v-on:click="submit()"
                v-html="$t('catalogue.submit')">
        </button>
    </form>
    <form class="comment-form" v-else>
        <p class="comment-notes" v-html="added_review"></p>
    </form>
</template>

<script>

    export default {

        props: ['product_id'],

        data() {
            return {
                'name': '',
                'validation': {
                    'name': [],
                    'comment': [],
                    'email': []
                },
                'email': '',
                'rating': 5,
                'comment': '',
                'rating_options': [5, 4, 3, 2, 1],
                'added_review': false
            }
        },

        methods: {
            submit: function () {
                let review = {
                    'name': this.name,
                    'email': this.email,
                    'rating': this.rating,
                    'comment': this.comment,
                    'product_id': this.product_id,
                };

                this.$http.post('/api/review', review)
                    .then(response => {
                        this.added_review = response.data.response;
                    }, response => {
                        this.validation = this.extend(this.resetErrors(), response.data);
                    });
            },

            resetErrors: function () {
                return {
                    'name': [],
                    'comment': [],
                    'email': []
                };
            },

            extend: function (obj, src) {
                for (let key in src) {
                    if (src.hasOwnProperty(key)) obj[key] = src[key];
                }
                return obj;
            }

        }
    };

</script>