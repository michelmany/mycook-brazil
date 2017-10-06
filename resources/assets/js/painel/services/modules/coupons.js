import { HttpService } from '../httpService';
import bus from '../../services/bus'
import moment from '../../helpers/moment'

const httpService = new HttpService();
httpService.build('admin/v1/coupons');

/**
 * Actions
 */
const actions = {
    /**
     *
     * @param commit
     * @param payload
     */
    all({commit}){
        httpService.list()
            .then(response => {
                commit('SET_COUPONS', response.data.coupons)
            })
    },

    /**
     * Store category
     *
     * @param commit
     * @param payload
     */
    store({commit}, payload) {
        httpService.create(payload)
            .then(response => {
                bus.$emit('coupon store success')
            })
            .catch(error => alert(error.response.data))
    },

    /**
     * Find category by params
     *
     * @param commit
     * @param payload
     */
    find({commit}, payload) {
        httpService.get(payload)
            .then(response => commit('SET_COUPON', response.data.coupon))
            .catch(error => alert(error.response.data))
    },

    /**
     *
     * @param commit
     * @param payload
     */
    update({commit}, payload){
        httpService.update(payload.id, payload.data)
            .then(response => {
                if(response.status === 204) {
                    bus.$emit('coupon update success', payload.data)
                    commit('UPDATE_COUPON', payload)
                }
            })
            .catch(error => console.log(error))
    },

    destroy({commit}, payload) {
        httpService.remove(payload.id)
            .then(response => {
                if(response.status === 204) {
                    bus.$emit('coupon delete success', payload)
                }
            })
            .catch(error => console.log(error))
    }
};

/**
 * Getters
 *
 * @type {{all: (function(*))}}
 */
const getters = {
    /**
     * Get all
     *
     * @param state
     * @returns {Array|*|state.list|{}}
     */
    all: (state) => {
        return state.list;
    },

    /**
     * Get coupon by id
     *
     * @param state
     */
    find: (state) => (id) => {
        return _.find(state.list, item => item.id === id)
    },

    /**
     * Get item endpoint
     *
     */
    item: (state) => state.item

};

export default {

    namespaced: true,

    state: {
        list: [],
        item: {}
    },

    mutations: {
        /**
         *
         * @param state
         * @param payload
         * @constructor
         */
        SET_COUPONS: (state, payload) => {
            state.list = payload
        },

        /**
         *
         * @param state
         * @param payload
         * @constructor
         */
        SET_COUPON: (state, payload) => {
            state.item = payload
        },

        /**
         *
         * @param state
         * @param payload
         * @constructor
         */
        UPDATE_COUPON: (state, payload) => {
            let index = _.findIndex(state.list, item => item.id === payload.id);
            console.log('update coupon ', index)
        },
    },

    actions,

    getters
};