/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('jquery-ui-bundle');
require('google-maps');
require('smoothscroll-for-websites');
//require('card');
//require('jgrowl');
require('../css/bower/owl.carousel/dist/owl.carousel.js');
require('bootstrap-hover-dropdown');

//require('./jquery.card.js');
require('./shop.js');
require('./custom.js');

require('lazysizes');

Vue.component('total-checkout', require('./components/totalCheckout.vue'));
Vue.component('product-form' , require('./components/productForm.vue'));
Vue.component('add-review' , require('./components/addReview.vue'));
Vue.component('cart-menu' , require('./components/cartMenu.vue'));
Vue.component('cart-add' , require('./components/cartAdd.vue'));

const VueInternalization = require('vue-i18n');
import Locales from './vue-i18n-locales.generated.js';
Vue.use(VueInternalization);
Vue.config.lang = Laravel.language;
Object.keys(Locales).forEach(function (lang) {
    Vue.locale(lang, Locales[lang])
});

const WebFont = require('webfontloader');

WebFont.load({
    google: {
        families: ['Source Sans Pro:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900,900italic', 'Raleway:400,100,200,300,500,600,700,900,800']
    }
});

const app = new Vue({
    el: '#page-wrapper'
});
