import { HttpService } from '../httpService';
import bus from '../../services/bus'
import moment from '../../helpers/moment'
import { removeAccent } from '../../helpers/functions'

const httpService = new HttpService();
httpService.build('admin/v1/categories');

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
                commit('SET_CATEGORIES', response.data.categories)
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
                bus.$emit('category store success')
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
            .then(response => commit('SET_CATEGORY', response.data.category))
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
                    bus.$emit('category update success', payload.data)
                    commit('UPDATE_CATEGORY', payload)
                    //toastr.success('Categoria alterada com sucesso.', 'Atualização!', {onHidden:() => commit('UPDATE_CATEGORY', payload), timeOut:1000})
                }
            })
            .catch(error => console.log(error))
    },

    destroy({commit}, payload) {
        httpService.remove(payload.id)
            .then(response => {
                if(response.status === 204) {
                    bus.$emit('category delete success', payload)
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
        return _.orderBy(state.list, ['name', 'status'], ['asc']);
    },

    /**
     * Get category by id
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
        SET_CATEGORIES: (state, payload) => {
            state.list = payload
        },

        /**
         *
         * @param state
         * @param payload
         * @constructor
         */
        SET_CATEGORY: (state, payload) => {
            state.item = payload
        },

        /**
         *
         * @param state
         * @param payload
         * @constructor
         */
        UPDATE_CATEGORY: (state, payload) => {
            let index = _.findIndex(state.list, item => item.id === payload.id);
            _.forEach(payload.data, (value, key) => {
                _.set(state.list[index], key, value)
            })
        },
    },

    actions,

    getters
};