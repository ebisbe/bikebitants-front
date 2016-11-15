<template>
    <div class="row row-no-padding">

        <attribute-select
                v-for="property in properties"
                v-bind:order="property.order"
                v-bind:name="property.name"
                v-bind:options="property.properties_values"
                v-on:changed="emitChangedValue">
        </attribute-select>

        <quantity-select
                v-bind:max-quantity="maxQuantity">
        </quantity-select>

        <div class="col-md-2 col-sm-12">
            <button type="submit"
                    class="btn btn-primary add-to-cart js-add-button"
                    v-html="$t('catalogue.add_to_stock')">

            </button>
        </div>

    </div>
</template>

<script>
    import attributeSelect from './attributeSelect.vue';
    import quantitySelect from './quantitySelect.vue';

    export default {
        props: ['properties', 'variations'],

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

            switch (this.properties.length) {
                case 2:
                    this.secondSetValues = this.properties[1].properties_values;
                    this.emitChangedValue(1, this.properties[0].properties_values[0]._id);
                    this.emitChangedValue(2, this.properties[1].properties_values[0]._id);
                    break;
                case 1:
                    this.firstSelected = this.properties[0].properties_values[0]._id;
                    this.emitChangedValue(2, this.properties[0].properties_values[0]._id);
                    this.maxQuantity = this.variations[0].stock;
                    break;
                case 0:
                    this.maxQuantity = this.variations[0].stock;
                    break;
            }
        },

        methods: {
            emitChangedValue: function (order, selectedValue) {
                switch (this.properties.length) {
                    case 1:
                        this.firstSelected = selectedValue;
                        this.secondOptionUpdated(selectedValue);
                        break;
                    case 2:
                        switch (order) {
                            case 1:
                                this.firstOptionUpdated(selectedValue);
                                this.firstSelected = selectedValue;
                                break;
                            case 2:
                                this.secondOptionUpdated(selectedValue);
                                break;
                        }
                        break;
                }
            },

            firstOptionUpdated: function (selectedValue) {
                var filters = this.variationsFilter;
                this.properties[1].properties_values
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