import Vue from 'vue'
import Vuex from 'vuex'
import router from './router.js'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import './bootstrap'

Vue.use(Vuex)

const store = new Vuex.Store({
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
})

const app = new Vue({
    el: '#app',
    store: store,
    router: router,
    vuetify,
    components: {
        App,
    }
})

export default app