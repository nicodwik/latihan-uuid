<template>
    <v-app>
        <alert></alert>

        <v-dialog v-model="dialog" fullscreen hide-overlay transition="scale-transition">
            <search @closed="closeDialog"/>
        </v-dialog>

        <v-navigation-drawer app v-model='drawer'>
            <v-list>
                <v-list-item v-if="!guest">
                    <v-list-item-avatar>
                        <v-img src="https://randomuser.me/api/portraits/men/78.jpg"></v-img>
                    </v-list-item-avatar>
                    <v-list-content>
                        <v-list-item-title>John Cena</v-list-item-title>
                    </v-list-content>
                </v-list-item>

                <div class="pa-2" v-if="guest">
                    <v-btn block color='primary' class="mb-1">
                        <v-icon left>mdi-lock</v-icon>
                        Login
                    </v-btn>
                    <v-btn block color="success">
                        <v-icon left>mdi-account</v-icon>
                        Register
                    </v-btn>
                </div>
                <v-divider></v-divider>

                <v-list-item v-for="(item, index) in menus" :key='`menu-${index}`' :to="item.route">
                    <v-list-item-icon>
                        <v-icon left>{{item.icon}}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{item.title}}</v-list-item-title>
                    </v-list-item-content>

                </v-list-item>
            </v-list>

            <template v-slot:append v-if="!guest">
                <div class="pa-2">
                    <v-btn block color="red" dark>
                        <v-icon left>mdi-lock</v-icon>
                        Logout
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>

        <v-app-bar app color="success" dark v-if="isHome">
            <v-app-bar-nav-icon @click.stop='drawer = !drawer'></v-app-bar-nav-icon>
            <v-toolbar-title>Dummy-CrowdfundingApp</v-toolbar-title>

            <v-spacer></v-spacer>
            <v-btn icon>
                <v-badge v-if="handlePayment>0" color="orange" overlap>
                    <template v-slot:badge>
                            <span >{{handlePayment}}</span>                        
                    </template>
                    <v-icon>mdi-cash-multiple</v-icon>
                </v-badge>
                <v-icon>mdi-cash-multiple</v-icon>
            </v-btn>

            <v-text-field @click="openDialog" slot="extension" hide-details append-icon="mdi-microphone" flat label="search" prepend-inner-icon="mdi-magnify" solo-inverted>

            </v-text-field>
        </v-app-bar>
        <v-app-bar app color="success" dark v-else>
            <v-btn icon @click.stop="$router.go(-1)">
                <v-icon>mdi-arrow-left-circle</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn icon>
                    <v-icon>mdi-cash-multiple</v-icon>
                <v-badge v-if="handlePayment>0" color="orange" overlap class="mb-5">
                    <template v-slot:badge>
                            <span >{{handlePayment}}</span>                        
                    </template>
                </v-badge>
            </v-btn>
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>

            <!-- Provides the application the proper gutter -->
            <v-container fluid>
                <v-slide-y-transition>
                    <router-view></router-view>
                </v-slide-y-transition>
            <!-- If using vue-router -->
            </v-container>
        </v-main>

        <v-card>
            <v-footer absolute app>
                <v-card-text class="text-center">
                    &copy; {{new Date().getFullYear()}} - <strong>SanbercodeApp</strong>
                </v-card-text>
            </v-footer>
        </v-card>
    </v-app>
</template>
<script>
import {mapGetters} from 'vuex'
import Alert from './components/Alert.vue'
import Search from './components/Search.vue'

export default {
    components: { 
      Alert,
      Search 
    },
    name: 'App',
    data: () => ({
        drawer: false,
        guest: false,
        dialog: false,
        menus: [
            {
                title: 'Home',
                icon: 'mdi-home',
                route: '/'
            },
            {
                title: 'Campaign',
                icon: 'mdi-hand-heart',
                route: '/campaigns'
            }
        ],
    }),
    computed: {
        isHome() {
            return (this.$route.path === '/' || this.$route.path === '/home')
        },
        // handlePayment(){
        //     return this.$store.getters.addPayment
        // }
        ...mapGetters({
            'handlePayment' : 'payment/addPayment'
        }),
    },
    methods: {
        openDialog() {
            this.dialog = true
        },
        closeDialog (value) {
            this.dialog = value
        }
    }
}
</script>