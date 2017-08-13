<template>
    <div>

        <vue-loading v-show="loading" type="bubbles" color="#F95700" :size="{ width: '50px', height: '50px' }" key="1"></vue-loading>

        <transition-group name="component-fade" mode="out-in">
            <div class="row" v-if="chefs.length > 0" key="results">
                <div class="col-md-6 col-lg-6" v-for="chef in filteredChefs" >
                    <div class="chef-item__box" @click="goToSinglePage(chef.user_id)">
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="chef-item__photo mr-3">
                                <img :src="chef.avatar" class="rounded-circle" width="85" height="85">
                            </div>
                            <div class="chef-item__text ">
                                <div class="chef-item__title text-uppercase">{{ chef.name }}</div>
                                <div class="chef-item__distance"><small class="text-uppercase">{{ roundDistance(chef.distance) }}</small></div>
                            </div>
                            <div class="chef-item__icon-arrow ml-auto"><i class="fa fa-chevron-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-show="chefs.length == 0" key="no-results">
                <div class="alert alert-warning" role="alert">
                    Infelizmente não encontramos nenhum Chef perto de você!
                </div>
            </div>
            <div v-show="chefs.length > 0 && filteredChefs.length == 0" key="no-results">
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
                chefs: {},
                user: {},
                address: {},
                coordinates: {},
                search: ''
            }
        },
        props: ["latitude", "longitude"],
        methods: {
            listChefs() {

                this.loading = true;

                setTimeout(() => {
                    axios.get('get-chefs')
                    .then((res) => {
                        // console.log(res.data)
                        this.loading = false
                        this.chefs = res.data
                    })
                }, 500);

            },
            listChefsByCoordinates() {
                this.loading = true;

                setTimeout(() => {
                    axios.post('get-chefs-by-cep', this.coordinates)
                    .then((res) => {
                        // console.log(res.data)
                        this.loading = false
                        this.chefs = res.data
                    })
                }, 500);
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
                return this.chefs.filter(function(chef) {
                    return chef.name.toLowerCase().indexOf(self.search.toLowerCase())>=0;
                });
            }
        },
        mounted() {
            // if there's coordinates from the url
            var coordinatesObjectSize = Object.keys(this.coordinates).length;
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

<style>
    .component-fade-enter-active, .component-fade-leave-active {
      transition: opacity .5s ease;
    }
    .component-fade-enter, .component-fade-leave-to {
      opacity: 0;
    }
</style>