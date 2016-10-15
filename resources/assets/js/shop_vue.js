var Vue =  require('vue');

import totalCheckout from './components/totalCheckout.vue';
import productStatus from './components/admin/productStatus.vue';
import productBoolean from './components/admin/productBoolean.vue';
import productForm from './components/productForm.vue';

new Vue({
    el: 'body',

    components: { totalCheckout, productStatus, productBoolean, productForm }

});