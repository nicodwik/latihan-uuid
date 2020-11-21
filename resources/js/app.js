import Vue from 'vue'
import router from './router.js'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import './bootstrap'

const app = new Vue({
    el: '#app',
    router: router,
    vuetify,
    components: {
        App,
    }
})