import { HttpService } from '../httpService';
// import bus from '../../services/bus';
import service  from '../../services/moip/orders'
import moment from '../../helpers/moment'

const httpService = new HttpService();
      httpService.build('admin/v1/orders');

export default {
    namespaced: true,

    state: {
        orders: [],
        order: {}
    },

    mutations: {
        'SET_ORDERS' : (state, payload) => {
            state.orders = payload;
        },
        'SET_ORDER': (state, payload) => {
            state.order = payload;
        }
    },

    actions: {
        all(store, payload) {
            httpService.list()
                .then(res => {
                    store.commit('SET_ORDERS', res.data.orders)
                })
        },
        find(store, payload) {
            httpService.get(payload)
                .then(res => {
                    store.commit('SET_ORDER', res.data.order)
                })
        }
    },

    getters: {
        getOrders : (state) => {
            return _.forEach(state.orders, order => {
                order.status = service.formatStatus(order.status)
                order.created_at = moment(order.created_at).format('DD/MM/Y H:m')
            })
        },
        getOrder: (state) => {
            let order = state.order
                order.status =  service.formatStatus(order.status)
                order.created_at =  moment(order.created_at).format('DD/MM/Y H:m:s')
                order.updated_at =  moment(order.updated_at).format('DD/MM/Y H:m:s')
            return order
        }
    }
}