<template>
    <v-snackbar v-model="alert" color="color" bottom timeout="4000" multi-line>
            {{message}}
            <template v-slot:action="{attrs}">
                <v-btn color="white" text v-bind="attrs" @click="close = false">
                    X
                </v-btn>
            </template>
        </v-snackbar>
</template>
<script>
import {mapGetters, mapActions} from 'vuex'
export default {
    name: 'alert',
    computed: {
        ...mapGetters({
            status: 'alert/status',
            color: 'alert/color',
            message: 'alert/message'
        }),
        alert: {
            get() {
                return this.status
            },
            set(value){
                this.setAlert({
                    status : value
                })
            }
        }
    },
    methods: {
        ...mapActions({
            setAlert : 'alert/set'
        }),
        close(){
            this.setAlert({
                status: false
            })
        }
    }
}
</script>