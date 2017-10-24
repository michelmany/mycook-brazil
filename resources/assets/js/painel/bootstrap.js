import VueRouter from 'vue-router'
import VeeValidate, { Validator } from 'vee-validate'
import CpfValidator from './components/validators/cpf.validator'
import Portuguese from 'vee-validate/dist/locale/pt_BR'
import Dictionary from './components/validators/dictionary'

import Axios from 'axios';
import Ls from './services/ls'
require("babel-polyfill");
require('es6-promise').polyfill();

window._ = require('lodash');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');


/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest'
};

/**
 * Interceptors
 */

axios.interceptors.request.use(function (config) {
    // Do something before request is sent
    const AUTH_TOKEN = Ls.get('auth.token');

    if(AUTH_TOKEN){
        config.headers.common['Authorization'] = `Bearer ${AUTH_TOKEN}`
    }

    return config;
}, function (error) {
    // Do something with request error
    return Promise.reject(error);
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });



Vue.use(VueRouter)

Validator.extend('cpf', CpfValidator)
Validator.addLocale(Portuguese);

Vue.use(VeeValidate, {
    locale: 'pt_BR', 
    dictionary: Dictionary
});
