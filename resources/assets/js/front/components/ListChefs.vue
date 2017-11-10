<template>
    <div>

        <vue-loading v-show="loading" type="bubbles" color="#F95700" :size="{ width: '50px', height: '50px' }" key="1"></vue-loading>

        <transition-group name="component-fade" mode="out-in">
            <div class="row" v-if="hasChefs" key="results">
                <div class="col-lg-6" v-for="(chef,index) in filteredChefs" :key="index">
                    <div class="chef-item__box" @click="goToSinglePage(chef.user_id)">
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="chef-item__photo--list mr-3">
                                <img :src="chef.logo" class="rounded-circle" width="85" height="85">
                            </div>
                            <div class="chef-item__text ">
                                <div class="chef-item__title text-uppercase" v-if="chef.custom_name == 'null' || chef.custom_name == null">{{ chef.name }}</div>
                                <div class="chef-item__title text-uppercase" v-else>{{ chef.custom_name }}</div>
                                <div class="chef-item__distance"><small class="text-uppercase">{{ roundDistance(chef.distance) }}</small></div>
                            </div>
                            <div class="chef-item__icon-arrow ml-auto"><i class="fa fa-chevron-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-show="showAlert" key="no-results">
                <div class="alert alert-warning" role="alert">
                    Não encontramos nenhum Chef em sua região. <a href="/">Clique aqui para adicionar novo endereço.</a>
                </div>
            </div>
            <div v-show="hasChefs && filteredChefs.length == 0" key="no-results">
                <div class="alert alert-warning" role="alert">
                    Desculpe, não encontramos nenhum Chef com este nome!
                </div>
            </div>
        </transition-group>

    </div>
</template>

<script>
    import vueLoading from 'vue-loading-template'
    import { eventBus } from '../app';
    import { HttpService } from '../services/httpService'
    let httpService = new HttpService();

    export default {
        data() {
            return {
                loading: false,
                chefs: [],
                data: [],
                user: {},
                address: {},
                coordinates: {},
                search: '',
                showAlert: false
            }
        },
        props: ["latitude", "longitude"],
        methods: {
            listChefs() {

                this.loading = true;

                axios.get('get-chefs')
                .then((res) => {
                    // console.log(res.data)
                    this.loading = false
                    this.chefs = res.data

                    if(this.chefs.length === 0) {
                        this.showAlert = true
                    }

                    if(res.data.length != 0) {
                        eventBus.$emit('has-chef', true);
                    }

                });

            },
            listChefsByCoordinates() {
                this.loading = true;

                axios.post('get-chefs-by-cep', this.coordinates)
                .then((res) => {
                    // console.log(res.data)
                    this.loading = false
                    this.chefs = res.data

                    if(res.data.length != 0) {
                        eventBus.$emit('has-chef', true);
                    }

                });

            },
            searchChef(chefName) {
                this.search = chefName;
                // alert(chefName);
            },
            roundDistance: function(chef) {
                if (chef) {
                    let chefDistance = chef.toFixed(2)
                    if (chefDistance <= 0.1) {
                        chefDistance = "A menos de 100 metros de você!"
                    } else {
                        chefDistance = `A ${chefDistance} Km de distância`
                    }
                    return chefDistance;
                }
            },
            goToSinglePage(id) {
                // console.log(id)
                window.location.href = "/chefs/" + id;
            }
        },
        computed: {
            filteredChefs() {
                var self = this;

                // console.log(this.chefs);
                var arr = _.values(this.chefs)
              
                return arr.filter(function(chef) {
                    if(!chef.custom_name || chef.custom_name == "null") {
                        return chef.name.toLowerCase().indexOf(self.search.toLowerCase())>=0;
                    } else {
                        return chef.custom_name.toLowerCase().indexOf(self.search.toLowerCase())>=0;
                    }
                });
                
            },
            hasChefs() {
                let arr = _.values(this.chefs);
                return arr.length > 0;
            }
        },
        mounted() {
            // if there's coordinates from the url
            let coordinatesObjectSize = Object.keys(this.coordinates).length;
            if (coordinatesObjectSize > 0) {
                this.listChefsByCoordinates()
            } else {
                this.listChefs()
            }

        },
        created() {
            if (this.latitude && this.longitude) {
                this.coordinates.latitude = this.latitude;
                this.coordinates.longitude = this.longitude;
            }

            // Receive data from SearchChef.vue
            eventBus.$on('search-chef', this.searchChef);

        }
    }
</script>

<style lang="scss">

    .sweet-modal .sweet-content + .sweet-buttons {
        @media screen and (max-width: 600px) {
            position: fixed;
            text-align: center;
            background-color: #efefef;
        }
    }

    .component-fade-enter-active, .component-fade-leave-active {
      transition: opacity .5s ease;
    }
    .component-fade-enter, .component-fade-leave-to {
      opacity: 0;
    }
</style>