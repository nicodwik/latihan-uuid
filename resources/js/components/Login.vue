<template>
    <v-card>
        <v-toolbar dark color="success">
            <v-btn icon dark @click.native="close">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Login</v-toolbar-title>    
        </v-toolbar>
        <v-divider></v-divider>

        <v-container fluid>
            <v-form ref="form" v-model="valid" lazy-validation>
                <v-text-field v-model="email" :rules="emailRules" label="E-mail" required append-icon="mdi-email">
                </v-text-field>
                <v-text-field 
                    v-model="password"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" 
                    :rules="passwordRules"
                    :type="showPassword ? 'text' : 'password'"
                    label="password"
                    hint="At Least 6 Character"
                    counter
                    @click:append="showPassword = !showPassword">
                </v-text-field>

                <div class="text-xs-center">
                    <v-btn
                        color="success lighten-1"
                        :disabled='!valid'
                        @click="submit">

                        Login
                        <v-icon right dark>mdi-lock-open</v-icon>
                    </v-btn>
                    <v-btn
                        color="primary lighten-1"
                        @click="authProvider('google')">
                        Login with Google
                        <v-icon right dark>mdi-google</v-icon>
                    </v-btn>    
                </div>    
            </v-form>
        </v-container>    
    </v-card>    
</template>
<script>
import {mapGetters, mapActions} from 'vuex'
export default {
    name: 'login',
    data() {
        return {
            valid: true,
            email: 'nicodwika@gmail.com',
            emailRules: [
                v => !!v || 'Email is Required',
                v => /([a-zA-Z0-9_]{1,})(@)([a-zA-Z0-9_]{2,}).([a-zA-Z0-9_]{2,})+/.test(v) || 'Email must be valid'
            ],
            showPassword: false,
            password: 'rahasiadunk',
            passwordRules : [
                v => !!v || 'Password required',
                v => (v && v.length >= 6) || 'Min 6 characters'
            ]
        }
    },
    computed: {
        ...mapGetters({
            user : 'auth/user'
        })
    },
    methods: {
        ...mapActions({
            setAlert : 'alert/set',
            setAuth : 'auth/set'
        }),
        submit() {
            if(this.$refs.form.validate()) {
                let formData = {
                    'email' : this.email,
                    'password' : this.password
                }
                axios.post('/api/auth/login', formData)
                    .then((response) => {
                        let {data} = response.data
                        console.log(data)
                        this.setAuth(data)
                        if(this.user.user.id.length>0) {
                            this.setAlert({
                                status: true,
                                color: 'success',
                                message: 'Login Success'
                            })
                            this.close()
                        } else {
                            this.setAlert({
                                status: true,
                                color: 'error',
                                message: 'Login failed'
                            })
                        }
                    })
                    .catch((error) => {
                        let response = error
                        console.log(response)
                        this.setAlert({
                            status: true,
                            color: 'error',
                            message: 'fack'
                        })
                    })
            }
        },
        close() {
            this.$emit('closed', false)
        },
        authProvider(provider) {
            axios.get(`/api/auth/social/${provider}`)
                .then((response) => {
                    let data = response.data
                    console.log(data)
                    window.location.href = data.url
                })
                .catch((error) => {
                    this.setAlert({
                        status: true,
                        color: 'error',
                        message: 'Login failed'
                    })
                })
        }
    }
}
</script>