var Vue =  require('vue');

import totalCheckout from './components/totalCheckout.vue';
import productStatus from './components/admin/productStatus.vue';

new Vue({
    el: 'body',

    components: { totalCheckout, productStatus }

});