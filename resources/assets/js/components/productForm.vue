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
                :max-quantity="max_quantity"
                @changedQuantity="updateQuantity">
        </quantity-select>

        <div class="form-group product-size">
            <cart-add :quantity="quantity"
                      :product_id="product_id"
                      :properties="cart_properties"
                      text="catalogue.add"
                      :show_icon="true"
                      button_class="btn btn-primary add-to-cart">
            </cart-add>
        </div>

        <span class="help-block" id="helpBlock2">{{ stockText }}</span>
    </form>
</template>

<script>
    import attributeSelect from './attributeSelect.vue';
    import quantitySelect from './quantitySelect.vue';

    export default {
        props: ['properties', 'variations', 'product_id'],

        components: {attributeSelect, quantitySelect},

        data() {
            return {
                max_quantity: -1,
                quantity: 1,
                cart_properties: []
            }
        },

        created: function () {
            this.cart_properties[0] = this.product_id;

            if (this.properties.length == 0) {
                this.max_quantity = this.variations[0].stock;
            }
        },

        methods: {
            emitChangedValue: function (order, selectedValue) {
                this.cart_properties[order] = selectedValue;

                let properties = this.cart_properties;
                //iterate through all variations to find the selected one
                let variation = _.filter(this.variations, function (variation) {
                    return _.isEmpty(_.difference(variation._id, properties));
                });

                if (variation.length == 0) {
                    this.max_quantity = 0;
                } else {
                    this.max_quantity = variation[0].stock;
                }
            },

            updateQuantity: function (quantity) {
                this.quantity = quantity;
            }
        },

        computed: {
            stockText: function () {
                if (this.max_quantity <= 0) {
                    return Vue.t('catalogue.out_of_stock')
                }
                if (this.max_quantity == 1) {
                    return Vue.t('catalogue.one_stock') + ' ' + this.max_quantity;
                }
                if (this.max_quantity <= 5) {
                    return Vue.t('catalogue.small_stock') + ' ' + this.max_quantity;
                }

                return Vue.t('catalogue.in_stock');
            }
        }
    };
</script>