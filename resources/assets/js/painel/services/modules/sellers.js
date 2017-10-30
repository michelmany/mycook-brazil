import { HttpService } from '../httpService';
import bus from '../../services/bus'
import moment from '../../helpers/moment'

const httpService = new HttpService();
httpService.build('admin/v1/sellers');

/**
 * Actions
 */
const actions = {
    /**
     * Find category by params
     *
     * @param commit
     * @param payload
     */
    find({commit}, payload) {
        httpService.get(payload)
            .then(response => commit('SET_SELLER', response.data.seller))
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
                    bus.$emit('seller update success', payload.data)
                    commit('UPDATE_SELLER', payload)
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
     * Get category by id
     * @param state
     */
    get: (state) => {
        return state.seller;
    }
};

export default {

    namespaced: true,

    state: {
        seller: {}
    },

    mutations: {
        /**
         *
         * @param state
         * @param payload
         * @constructor
         */
        SET_SELLER: (state, payload) => {
            state.seller = payload
        },

        UPDATE_SELLER: (state, payload) => {
            console.log('update seller', payload)

            _.update(state.seller.data, payload.column, item => {
                return payload.value
            })
        }
    },

    actions,

    getters
};