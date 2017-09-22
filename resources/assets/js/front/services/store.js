import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import cart from './modules/cart'
import address from './modules/address'

export default new Vuex.Store({
    modules: {
        cart,
        address
    }
});
