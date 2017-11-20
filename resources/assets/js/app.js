/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('jquery-ui-bundle');
require('google-maps');
require('smoothscroll-for-websites');
require('../css/bower/owl.carousel/dist/owl.carousel.js');
require('bootstrap-hover-dropdown');
require('../../../node_modules/cookie-banner/src/cookiebanner');
require('./shop.js');
require('./custom.js');

require('lazysizes');

import InstantSearch from 'vue-instantsearch';
import totalCheckout from './components/totalCheckout.vue'
import productForm from './components/productForm.vue'
import addReview from './components/addReview.vue'
import cartMenu from './components/cartMenu.vue'
import cartAdd from './components/cartAdd.vue'
import owlCarrousel from './components/owlCarrousel.vue'
import cartBadge from './components/cartBadge.vue'
import categories from './components/categories.vue'
import Search from './components/search.vue'

Vue.use(InstantSearch);
Vue.component('total-checkout', totalCheckout);
Vue.component('product-form', productForm);
Vue.component('add-review', addReview);
Vue.component('cart-menu', cartMenu);
Vue.component('cart-add', cartAdd);
Vue.component('owl-carrousel', owlCarrousel);
Vue.component('cart-badge', cartBadge);
Vue.component('categories', categories);
Vue.component('search', Search);

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

var options = {
    message: Locales[Laravel.language].layout.cookies.message,
    moreinfo: Locales[Laravel.language].layout.cookies.moreinfo,
    linkmsg: Locales[Laravel.language].layout.cookies.linkmsg,
    acceptOnFirstVisit: true,
    cookie:'laravel_cookie_consent'
};
var cb = new Cookiebanner(options); cb.run();
