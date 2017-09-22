
export default {

    namespaced: true,

    state: {
      addresses: []
    },

    getters: {
      getAll: state => {
        return _.orderBy(state.addresses, 'default', 'desc')
      }
    },

    actions: {
      all(store, payload) {
        console.log(Event, 'evento')
      }
    }
}
