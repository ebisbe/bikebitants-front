<template>
    <form class="comment-form">
        <p class="comment-notes">
            <span id="email-notes">Your email address will not be published.</span>
            Required fields are marked<span class="required">*</span>
        </p>
        <div class="row">
            <div class="form-group comment-form-author col-sm-6">
                <label for="name">Name<span class="required">*</span></label>
                <input class="form-control" id="name" name="name" type="text" required value=""
                       placeholder="Enter your name" v-model="name">
            </div>
            <div class="form-group comment-form-email col-sm-6">
                <label for="email">Email<span class="required">*</span></label>
                <input class="form-control" id="email" name="email" type="email" required value=""
                       placeholder="Enter your email" v-model="email">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="rating">Rating <span class="required">*</span></label>
                <select v-model.number="rating" name="rating" id="rating" class="form-control" required>
                    <option v-for="option in rating_options" value="{{ option }}">
                        {{ option }}
                    </option>
                </select>
            </div>
        </div>
        <div class="form-group comment-form-comment">
            <label for="comment">Comment<span class="required">*</span></label>
            <textarea class="form-control" id="comment" name="comment" required
                      placeholder="Enter your message" v-model="comment"></textarea>
        </div>
        <button class="btn btn-primary" type="button" v-on:click="submit()">
            <i class="fa fa-check"></i>Submit
        </button>
    </form>
</template>

<script>

    export default {

        props: ['product_id', 'token'],

        data() {
            return {
                'name': '',
                'email': '',
                'rating': 5,
                'comment': '',
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
                    this.list = jqXHR;
                }.bind(this))
                .fail(function (jqXHR) {

                })
                .always(function () {

                });
            }
        }
    };

</script>