<template>
    <div class="row row-no-padding">

        <attribute-select
                v-for="attribute in attributes"
                v-bind:order="attribute.order"
                v-bind:name="attribute.name"
                v-bind:options="attribute.attribute_values"
                v-on:changed="emitChangedValue">
        </attribute-select>

        <quantity-select
                v-bind:max-quantity="maxQuantity">
        </quantity-select>

        <div class="col-md-2 col-sm-12">
            <button type="submit" class="btn btn-primary add-to-cart js-add-button">
                <i class="fa fa-shopping-cart"></i>
                Add to cart
            </button>
        </div>

    </div>
</template>

<script>
    import attributeSelect from './attributeSelect.vue';
    import quantitySelect from './quantitySelect.vue';

    export default {
        props: ['attributes', 'variations'],

        data() {
            return {
                firstSelected: '',
                variationsFilter: [],
                maxQuantity: -1
            }
        },

        created: function () {
            var filter = [];
            this.variations.forEach(function (variation) {
                if (typeof filter[variation._id[1]] === 'undefined') {
                    filter[variation._id[1]] = [];
                }
                filter[variation._id[1]].push(variation._id[2]);
            });
            this.variationsFilter = filter;

            switch (this.attributes.length) {
                case 2:
                    this.secondSetValues = this.attributes[1].attribute_values;
                    this.emitChangedValue(1, this.attributes[0].attribute_values[0]._id);
                    this.emitChangedValue(2, this.attributes[1].attribute_values[0]._id);
                    break;
                case 1:
                    this.emitChangedValue(2, this.attributes[0].attribute_values[0]._id);
                    this.maxQuantity = this.variations[0].stock;
                    break;
                case 0:
                    this.maxQuantity = this.variations[0].stock;
                    break;
            }
        },

        methods: {
            emitChangedValue: function (order, selectedValue) {
                switch (order) {
                    case 1:
                        this.firstOptionUpdated(selectedValue);
                        this.firstSelected = selectedValue;
                        break;
                    case 2:
                        this.secondOptionUpdated(selectedValue);
                        break;
                }
            },

            firstOptionUpdated: function (selectedValue) {
                var filters = this.variationsFilter;
                this.attributes[1].attribute_values
                        = this.secondSetValues.filter(
                        function (attribute) {
                            return filters[selectedValue].indexOf(attribute._id) >= 0
                        });
            },

            secondOptionUpdated: function (selectedValue) {
                var firstSelected = this.firstSelected;
                var selectedVariation = this.variations.filter(
                        function (variation) {
                            return variation._id.indexOf(firstSelected) >= 1 &&
                                    variation._id.indexOf(selectedValue) >= 1;
                        }
                ).shift();

                this.maxQuantity = selectedVariation.stock;
            }
        },

        components: {attributeSelect, quantitySelect}
    };
</script>