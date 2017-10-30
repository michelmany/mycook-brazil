import router from './router.js'
import store from './services/store'

import Layout from './helpers/layout'
import filters from './filters'
import TheMask from 'vue-the-mask'
import money from 'v-money'

import moment from './helpers/moment'
import bus from './services/bus'

import 'bootstrap-vue/dist/bootstrap-vue.css'
import BootstrapVue from 'bootstrap-vue'
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

Vue.use(filters)
Vue.use(TheMask)
Vue.use(money, {
        precision: 4,
        decimal: ',',
        thousands: '.',
        prefix: 'R$ ',
        precision: 2,
        masked: false
    })

Vue.use(BootstrapVue)

Vue.prototype.$bus = bus
Vue.prototype.$moment = moment
Vue.config.debug = true

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Plugin from './helpers/plugin'
window.Plugin = Plugin

/**
 * Register Components Global
 */

Vue.component('app-category', require('./components/categories/AppCategory.vue'));

/**
 * Filters
 */
import {number_format} from "./helpers/functions";

Vue.filter('number_format', (value) => {
     return number_format(value, 2, ',', '.')
})


const app = new Vue({
    router,
    store,
    methods : {
        onOverlayClick(){
            Layout.toggleSidebar()
        }
    }
}).$mount('#app')