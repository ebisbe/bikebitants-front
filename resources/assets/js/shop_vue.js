var Vue =  require('vue');

import totalCheckout from './components/totalCheckout.vue';
import productStatus from './components/admin/productStatus.vue';
import productFeatured from './components/admin/productFeatured.vue';

new Vue({
    el: 'body',

    components: { totalCheckout, productStatus, productFeatured }

});