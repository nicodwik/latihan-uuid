import Vue from 'vue'
import Vuex from 'vuex'
import router from './router.js'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import payment from './stores/payment'
import alert from './stores/alert'
import './bootstrap'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        payment,
        alert
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