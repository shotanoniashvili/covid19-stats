/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import store from './store';
import router from './router';
import i18n from './i18n';
import * as helpers from './helpers';
import App from "./App";
import VueSweetalert2 from "vue-sweetalert2";
import axios from 'axios';

const token = localStorage.getItem('token')
if (token) {
    axios.defaults.headers.common.Authorization = `Bearer ${token}`
}

require('./bootstrap');


window.Vue = require('vue').default;
Vue.prototype.$helpers = helpers;

Vue.use(VueSweetalert2);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store: store,
    router: router,
    i18n: i18n,
    render: h => h(App)
});
