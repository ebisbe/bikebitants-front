<template>
    <form id="add-product" class="form-inline">
        <attribute-select
                v-for="property in properties"
                :order="property.order"
                :name="property.name"
                :options="property.properties_values"
                @changed="emitChangedValue">
        </attribute-select>

        <quantity-select
                :max-quantity="maxQuantity"
                @changedQuantity="updateQuantity">
        </quantity-select>

        <cart-add :quantity="quantity"
                  :product_id="product_id"
                  :properties="cart_properties"
                  text="catalogue.add"
                  :show_icon="true"
                  button_class="btn btn-primary add-to-cart">
        </cart-add>

        <span class="help-block" id="helpBlock2">{{ stockText }}</span>
    </form>
</template>

<script>
    import attributeSelect from './attributeSelect.vue';
    import quantitySelect from './quantitySelect.vue';

    export default {
        props: ['properties', 'variations', 'product_id'],

        data() {
            return {
                firstSelected: '',
                variationsFilter: [],
                maxQuantity: -1,

                quantity:1,
                cart_properties: {}
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
                    break;
                case 0:
                    this.maxQuantity = this.variations[0].stock;
                    break;
            }
        },

        methods: {
            emitChangedValue: function (order, selectedValue) {
                this.cart_properties[order] = selectedValue;
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
            },

            updateQuantity: function(quantity) {
                this.quantity = quantity;
            }
        },

        components: {attributeSelect, quantitySelect},

        computed: {
            stockText: function() {
                if(this.maxQuantity == 0) {
                    return Vue.t('catalogue.out_of_stock')
                }
                if(this.maxQuantity == 1) {
                    return Vue.t('catalogue.one_stock') + ' ' + this.maxQuantity;
                }
                if(this.maxQuantity <= 5) {
                    return Vue.t('catalogue.small_stock') + ' ' + this.maxQuantity;
                }

                return Vue.t('catalogue.in_stock');
            }
        }
    };
</script>