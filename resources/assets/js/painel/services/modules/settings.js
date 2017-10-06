import { HttpService } from '../httpService';
import moment from '../../helpers/moment'

const httpService = new HttpService();
httpService.build('admin/v1/settings');

/**
 * Actions
 *
 * @type {{all: (function({commit: *}, *))}}
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
                       commit('SET_SETTINGS', response.data)
                   })
    },
    /**
     *
     * @param commit
     * @param payload
     */
    update({commit}, payload){
        httpService.update('', payload)
                   .then(response => {
                       if(response.status === 204) {
                           toastr.info('Configurações atualizada.', '', {timeOut: 1000});
                           commit('UPDATE_SETTING', payload)
                       }
                   })
    }
}

/**
 * Getters
 *
 * @type {{all: (function(*))}}
 */
const getters = {

    all: (state) => {
        return state.list;
    },

}

export default {

    namespaced: true,

    state: {
        list: {}
    },

    mutations: {
        /**
         *
         * @param state
         * @param payload
         * @constructor
         */
        SET_SETTINGS: (state, payload) => {
            state.list = payload
        },
        /**
         *
         * @param state
         * @param payload
         * @constructor
         */
        UPDATE_SETTING: (state, payload) => {
            _.update(state.list, payload.column, item => {
                return payload.value
            })
        }
    },

    actions,

    getters
}