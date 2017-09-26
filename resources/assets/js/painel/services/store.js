import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import stock from './modules/stock'
import orders from './modules/orders'

export default new Vuex.Store({
    modules: {
        stock,
        orders
    }
})