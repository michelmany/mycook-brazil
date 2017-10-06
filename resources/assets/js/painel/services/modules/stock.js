import { HttpService } from '../httpService';
import bus from '../../services/bus';

const httpService = new HttpService();

export default {
    namespaced: true,

    state: {
        extras: []
    },

    mutations: {
        SET_EXTRAS(state, payload) {
            state.extras = payload
        },
        UPDATE_EXTRA_QTY(state, payload) {
            state.extras[payload.index].quantity = payload.qty;
        },
        UPDATE_EXTRA_TIME(state, payload) {
            // console.log(payload)
            if(payload.type === 'start'){
                state.extras[payload.index].start_time = payload.value
            }else{
                state.extras[payload.index].end_time = payload.value
            }
        }
    },

    actions: {

        getProductExtra(store, payload) {
            httpService.build('admin/v1/extras')
                .list({query: 'where[product_id]='+ payload.id})
                .then((res) => {
                    if(res.data.data.length > 0) {
                        store.commit('SET_EXTRAS', res.data.data)
                    }else{
                        store.commit('SET_EXTRAS', [
                            { date: 'Seg', start_time: "09:00",  end_time: "22:30", quantity: 0 },
                            { date: 'Ter', start_time: "09:00", end_time: "22:30", quantity: 0},
                            { date: 'Qua', start_time: "09:00", end_time: "22:30", quantity: 0},
                            { date: 'Qui', start_time: "09:00", end_time: "22:30", quantity: 0},
                            { date: 'Sex', start_time: "09:00", end_time: "22:30", quantity: 0},
                            { date: 'Sáb', start_time: "09:00", end_time: "22:30", quantity: 0},
                            { date: 'Dom', start_time: "09:00", end_time: "22:30", quantity: 0}
                        ])
                    }
                });
        },

        updateProductExtras({state}, payload) {
            httpService.build('admin/v1/extras')
                .update(payload.id, state.extras)
                .then((res) => {
                    toastr.success('Configurado com sucesso!', 'Produto', {
                        progressBar: true,
                        timeout: 2000,
                        onHidden: () => {
                           bus.$emit('redirect', {url: '/seller/cardapio/' + payload.id + '/edit'})
                        }
                    });
                })
                .catch((error) => {
                    toastr.error('Não foi possível editar seus dados!', 'Erro de servidor');
                    console.log(error.response)
                });
        }
    },

    getters: {
        getExtras: state => {
            return state.extras;
        }
    }
}