<template>
    <div id="product-carousel" class="product-carousel">
        <div class="item" v-for="image in images" :data-hash="image.file_hash">
            <img
                    :data-src="'/img/330/' + image.filename "
                    :alt="image.alt"
                    data-sizes="100w"
                    :data-srcset="'/img/330/' + image.filename + ' 360w,/img/450/' + image.filename + ' 480w,/img/538/' + image.filename + ' 568w,/img/355/' + image.filename + ' 1200w'"
                    class="img-responsive lazyloaded"
                    sizes="100w"
                    :srcset="'/img/330/' + image.filename + ' 360w,/img/450/' + image.filename + ' 480w,/img/538/' + image.filename + ' 568w,/img/355/' + image.filename + ' 1200w'"
                    src="'/img/330/' + image.filename "
            >
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            images: {
                type: Array,
                required: true
            }
        },

        created () {
            Bus.$on('selectVariation', this.selectedVariation);
        },

        methods: {

            selectedVariation: function (variation) {
                let foundVariation = _.filter(this.images, function (image) {
                    return image.file_hash === variation.file_hash;
                });

                if (_.isEmpty(foundVariation)) {
                    this.images.push(variation);
                    this.createNewVariation(variation);
                }


                location.hash = variation.file_hash;
            },

            createNewVariation: function (image) {
                let imgTag = '<img data-src="/img/330/' + image.filename + '" data-sizes="100w" data-srcset="/img/330/' + image.filename + ' 360w,/img/450/' + image.filename + ' 480w,/img/538/' + image.filename + ' 568w,/img/355/' + image.filename + ' 1200w" class="img-responsive lazyloaded" sizes="100w" srcset="/img/330/' + image.filename + ' 360w,/img/450/' + image.filename + ' 480w,/img/538/' + image.filename + ' 568w,/img/355/' + image.filename + ' 1200w" src="/img/330/' + image.filename + '">';
                if (typeof window.owl !== 'undefined') {
                    console.log(this.images.length);
                    window.owl.trigger(
                        'add.owl.carousel', [
                            '<div data-hash="' + image.file_hash + '" class="item">' + imgTag + '</div>'
                            , 1
                        ]
                    );
                }
            }
        }
    };

</script>