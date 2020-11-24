import Vue from 'vue'
import Vuex from 'vuex'
import router from './router.js'
import App from './App.vue'
import vuetify from './plugins/vuetify'
// store
import payment from './stores/payment'
import alert from './stores/alert'
import auth from './stores/auth'
import dialog from './stores/dialog'
import './bootstrap'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        payment,
        alert,
        auth,
        dialog
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