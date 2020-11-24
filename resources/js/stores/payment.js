export default {
    namespaced: true,
    state: {
        payments: 0
    },
    mutations: {
        addPayment(state){
            let plus = state.payments++
            console.log(plus)
        }
    },
    getters: {
        addPayment(state) {
            return state.payments
        }
    }
}