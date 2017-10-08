import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import stock from './modules/stock'
import orders from './modules/orders'
import settings from './modules/settings'
import categories from './modules/categories'
import coupons from './modules/coupons'
import sellers from './modules/sellers'

export default new Vuex.Store({
    modules: {
        stock,
        orders,
        settings,
        categories,
        coupons,
        sellers
    }
})