<template>
    <form id="add-product" class="form-horizontal">
        <div class="row">
            <div class="col-lg-8" v-if="properties.length > 0">
                <attribute-select
                        v-for="property in properties"
                        :order="property.order"
                        :name="property.name"
                        :options="property.properties_values"
                        @changed="emitChangedValue">
                </attribute-select>
            </div>
            <div class="col-lg-4">
                <quantity-select
                        :max-quantity="max_quantity"
                        @changedQuantity="updateQuantity">
                </quantity-select>

                <div class="form-group product-size">
                    <div class="col-sm-12 col-sm-offset-4 col-lg-offset-0">

                        <cart-add :quantity="quantity"
                                  :product_id="product_id"
                                  :properties="cart_properties"
                                  text="catalogue.add"
                                  :show_icon="true"
                                  :checkout="false"
                                  button_class="btn btn-transparent add-to-cart">
                        </cart-add>
                        <cart-add :quantity="quantity"
                                  :product_id="product_id"
                                  :properties="cart_properties"
                                  text="catalogue.add_and_buy"
                                  :show_icon="false"
                                  :checkout="true"
                                  button_class="btn btn-primary add-to-cart">
                        </cart-add>
                    </div>
                </div>

                <div class="form-group product-size">
                    <div class="col-sm-12 col-sm-offset-4 col-lg-offset-0">
                        <span class="help-block" id="helpBlock2">{{ $t('cart.price') }}: <strong>{{ variation_price }}&euro;</strong>
                        <span v-html="stockText"></span> </span>
                    </div>
                </div>

            </div>
        </div>
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
                variation_price: 0,
                cart_properties: []
            }
        },

        created: function () {
            this.cart_properties[0] = this.product_id;

            if (this.properties.length == 0) {
                this.max_quantity = this.variations[0].stock;
                this.variation_price = this.variations[0].tax_price;
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
                    this.variation_price = variation[0].tax_price;
                    Bus.$emit('selectVariation', variation[0]);
                }
            },

            updateQuantity: function (quantity) {
                this.quantity = quantity;
            }
        },

        computed: {
            stockText: function () {
                let text = '';
                switch (true) {
                    case this.max_quantity === 0:
                        text = Vue.t('catalogue.out_of_stock');
                        color = 'bg-danger';
                        break;
                    case this.max_quantity === 1:
                        text = Vue.t('catalogue.one_stock') + ' ' + this.max_quantity;
                        color = 'bg-warning';
                        break;
                    case this.max_quantity <= 5 && this.max_quantity > 1:
                        text = Vue.t('catalogue.small_stock') + ' ' + this.max_quantity;
                        color = 'bg-warning';
                        break;
                    default:
                        text = Vue.t('catalogue.in_stock');
                        color = 'bg-success';
                        break;
                }
                let color = '';
                return '<span class="' + color + '">(' + text + ')</span>';
            }
        }
    };
</script>