export default {
    namespaced: true,
    state: {
        status: false,
        color: 'success',
        message: ''
    },
    mutations: {
        set: (state, payload) => {
            state.status = payload.status
            state.color = payload.color
            state.message = payload.message
        }
    },
    actions: {
        set: ({commit}, payload) => {
            commit('set', payload)
        }
    },
    getters: {
        status: state => state.status,
        color: state => state.color,
        message: state => state.message
    }
}