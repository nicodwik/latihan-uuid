<template>
    <div>
        <v-card v-if="campaign.id">
            <v-img :src="campaign.image" class="white--text" height="200px">
                <v-card-title class="fill-height align-end" v-text="campaign.title"></v-card-title>
            </v-img>
            <v-card-text>
                <v-simple-table dense>
                    <tbody>
                        <tr>
                            <td><v-icon>mdi-home-city</v-icon> Alamat</td>
                            <td>{{campaign.address}}</td>
                        </tr>
                        <tr>
                            <td><v-icon>mdi-hand-heart</v-icon> Terkumpul</td>
                            <td>Rp {{campaign.collected}}</td>
                        </tr>
                        <tr>
                            <td><v-icon>mdi-cash</v-icon> Dibutuhkan</td>
                            <td>Rp {{campaign.required}}</td>
                        </tr>
                    </tbody>
                </v-simple-table>
                Description: <br>
                {{campaign.description}}
            </v-card-text>
            <v-card-actions>
                <v-btn block color="primary" @click="donate" :disabled="campaign.collected >= campaign.required">
                    <v-icon>mdi-money</v-icon>&nbsp;
                    DONATE
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>
<script>
import { mapMutations, mapActions } from 'vuex'
export default {
    data: () => ({
        campaign: {},
        payments: 0
    }),
    created() {
        this.go()
    },
    methods: {
        go() {
            let { id } = this.$route.params
            console.log(id)
            axios.get(`/api/campaign/${id}`)
                .then((response) => {
                    let { data } = response.data
                    this.campaign = data
                    // console.log(this.campaign)
                })
                .catch((error) => {
                    let { response } = error
                    console.log(response)
                })
        },
        ...mapMutations({
           handleClick : 'payment/addPayment' 
        }),
        ...mapActions({
           setAlert : 'alert/set' 
        }),

        donate(){
            this.handleClick()
            this.setAlert({
                status: true,
                color: 'success',
                message: 'Berhasil'
            })
        }
        // handleClick(){
        //     this.$store.commit('addPayment')
        // }
    }
}
</script>