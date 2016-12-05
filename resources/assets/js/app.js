
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('jquery-ui-bundle');
require('google-maps');
require('bootstrap-hover-dropdown');
require('smoothscroll-for-websites');
//require('card');
//require('jgrowl');
require('./bower/owl.carousel.js');
require('bootstrap-hover-dropdown');

//require('./jquery.card.js');
require('./custom.js');
require('./shop.js');

/*var VueLazyload = require('vue-lazyload');
Vue.use(VueLazyload);*/

Vue.component('total-checkout', require('./components/totalCheckout.vue'));
Vue.component('product-form' , require('./components/productForm.vue'));
Vue.component('add-review' , require('./components/addReview.vue'));
Vue.component('cart-menu' , require('./components/cartMenu.vue'));
Vue.component('cart-add' , require('./components/cartAdd.vue'));

var VueInternalization = require('vue-i18n');
import Locales from './vue-i18n-locales.generated.js';
Vue.use(VueInternalization);
Vue.config.lang = Laravel.language;
Object.keys(Locales).forEach(function (lang) {
    Vue.locale(lang, Locales[lang])
});


const app = new Vue({
    el: '#page-wrapper'
});
