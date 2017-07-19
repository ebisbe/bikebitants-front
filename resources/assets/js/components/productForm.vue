<template>
    <form id="add-product" class="form-horizontal">
        <ul class="list-inline product-links">
            <li><a><i class="fa fa-shield"></i>{{ $t('cart.secure_payment') }}</a></li>
            <li><a><i class="fa fa-refresh"></i>{{ $t('cart.allow_return') }}</a></li>
            <li v-if="variation_price >=  30"><a><i class="fa fa-bicycle"></i>{{ $t('cart.free_packaging') }}</a></li>
            <li v-else><a><i class="fa fa-bicycle"></i>{{ $t('cart.free_packaging') }} {{ $t('cart.over_30_euros')
                }}</a></li>
            <li v-if="hasSize"><a><i class="fa fa-scissors"></i>Cambio de talla gratuito</a></li>
        </ul>
        <div class="row">
            <div class="col-lg-8" v-if="visible">
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
                    <div class="col-xs-4 col-xs-offset-8 col-sm-3 col-sm-offset-9 col-lg-6 col-lg-offset-6">

                        <cart-add :quantity="quantity"
                                  :product_id="product_id"
                                  :properties="cart_properties"
                                  text="catalogue.add"
                                  :show_icon="false"
                                  :cart="true"
                                  button_class="btn btn-primary add-to-cart">
                        </cart-add>
                    </div>
                </div>

                <div class="form-group product-size">
                    <div class="col-sm-12 col-sm-offset-4 col-lg-offset-0">
                        <span class="help-block" id="helpBlock2">{{ $t('cart.price') }}: <strong>{{ variation_price }}&euro;</strong><br/>
                        <span v-html="stockText"></span> </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6" :class="{'col-lg-offset-6': visible, 'col-md-offset-4': visible }">
                <div class="PmtSimulator" v-show="(variation_price * quantity) > 99"
                     data-pmt-num-quota="6" data-pmt-max-ins="12" data-pmt-style="grey"
                     data-pmt-type="2"
                     data-pmt-discount="0" :data-pmt-amount="variation_price * quantity" data-pmt-expanded="yes">
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import attributeSelect from './attributeSelect.vue';
    import quantitySelect from './quantitySelect.vue';

    export default {
        props: ['properties', 'variations', 'product_id', 'delivery_time'],

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
                this.$nextTick(function () {
                    window.pmtClient.simulator.updateSimulators();
                })
            },

            updateQuantity: function (quantity) {
                this.quantity = quantity;
                this.$nextTick(function () {
                    window.pmtClient.simulator.updateSimulators();
                })
            }
        },

        computed: {
            stockText: function () {
                let text = '';
                let color;
                let deliver = Vue.t('cart.delivery_time') + this.delivery_time + 'h.';
                switch (true) {
                    case this.max_quantity === 0:
                        text = Vue.t('catalogue.out_of_stock');
                        color = 'alert-danger';
                        deliver = '';
                        break;
                    case this.max_quantity === 1:
                        text = Vue.t('catalogue.one_stock') + ' ' + this.max_quantity;
                        color = 'alert-warning';
                        break;
                    case this.max_quantity <= 5 && this.max_quantity > 1:
                        text = Vue.t('catalogue.small_stock') + ' ' + this.max_quantity;
                        color = 'alert-warning';
                        break;
                    default:
                        text = Vue.t('catalogue.in_stock');
                        color = 'alert-success';
                        break;
                }
                return '<span class="' + color + '"><b>' + text + '. ' + deliver + '</b></span>';
            },
            visible: function () {
                return this.properties.length > 0;
            },
            hasSize: function () {
                return _.size(_.filter(this.properties, function (o) {
                    return o.name == 'Talla';
                }));
            }
        }
    };
</script>