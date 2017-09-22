import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import stock from './modules/stock'

export default new Vuex.Store({
    modules: {
        stock
    }
})