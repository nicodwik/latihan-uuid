<template>
    <div>
        <v-container class="ma-0 pa-0" grid-list-sm>
            <v-subheader>All Campaigns</v-subheader>
            <v-layout wrap>
                <v-flex v-for="campaign in campaigns" :key="`campaign-${campaign.id}`" xs6>
                    <v-card :to="`/campaign/${campaign.id}`">
                        <v-img :src="campaign.image" class="white--text">
                            <v-card-title class="fill-height align-end" v-text="campaign.title"></v-card-title>
                        </v-img>
                    </v-card>
                </v-flex>
            </v-layout>
            <v-pagination v-model="page" @input="go" :length="lengthPage" :total-visible="5">
            </v-pagination>
        </v-container>
    </div>
</template>
<script>
export default {
    data: () => ({
        campaigns: [],
        page: 0,
        lengthPage: 0
    }),
    created(){
        this.go()
    },
    methods: {
        go() {
            // let url = `api/campaign?page=${this.page}`
            axios.get(`/api/campaign?page=${this.page}`)
                .then((response) => {
                    // console.log(response.data)
                    let { data } = response.data
                    this.campaigns = data.data
                    this.page = data.current_page
                    this.lengthPage = data.last_page
                })
                .catch((error) => {
                    let { resposes } = error
                    console.log(resposes)
                })
        }
    }
}
</script>