import { HttpService } from '../httpService';

import moment from '../../helpers/moment'

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
        console.log('list all categories')
    },
    /**
     *
     * @param commit
     * @param payload
     */
    update({commit}, payload){
        console.log('update category')
    }
}

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
     * Get category by id
     * @param state
     */
    find: (state) => (id) => {
        return _.find(state.list, item => item.id === id)
    }

};

export default {

    namespaced: true,

    state: {
        list: []
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
        UPDATE_CATEGORY: (state, payload) => {
            console.log('update category')
        },
    },

    actions,

    getters
};