var Vue =  require('vue');
var VueInternalization = require('vue-i18n');

import totalCheckout from './components/totalCheckout.vue';
import productStatus from './components/admin/productStatus.vue';
import productBoolean from './components/admin/productBoolean.vue';
import productForm from './components/productForm.vue';
import addReview from './components/addReview.vue';

import Locales from './vue-i18n-locales.generated.js';

Vue.use(VueInternalization);

Vue.config.lang = 'es';

Object.keys(Locales).forEach(function (lang) {
    Vue.locale(lang, Locales[lang])
});

new Vue({
    el: 'body',

    components: { totalCheckout, productStatus, productBoolean, productForm, addReview }

});