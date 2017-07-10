<template>
    <div>

        <vue-loading v-show="loading" type="bubbles" color="#F95700" :size="{ width: '50px', height: '50px' }" key="1"></vue-loading>

        <transition name="fade">
            <div class="row" v-if="chefs.length > 0" key="2">
                <div class="col-md-6 col-lg-6" v-for="chef in chefs" >
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
        </transition>
        <!-- TODO: criar uma mensagem quando não tiver resultados -->

    </div>
</template>

<script>
    import vueLoading from 'vue-loading-template'

    export default {
        data() {
            return {
                loading: false,
                chefs: {}
            }
        },
        methods: {
            listAddresses() {

                this.loading = true;

                setTimeout(() => {
                    axios.get('get-chefs')
                    .then((res) => {
                        this.loading = false
                        this.chefs = res.data
                    })
                }, 500);

            },
            roundDistance: function(chef) {
                let chefDistance = chef.toFixed(2)
                if (chefDistance <= 0.1) {
                    chefDistance = "A menos de 100 metros de você!"
                } else {
                    chefDistance = `A ${chefDistance} Km de distância`
                }
                return chefDistance;
            },
            goToSinglePage(id) {
                // console.log(id)
                window.location.href = "/chefs/" + id;
            }
        },
        mounted() {
            this.listAddresses();
        }
    }
</script>

<style>
    .fade-enter-active, 
    .fade-leave-active {
      transition: opacity .5s
    }
    .fade-enter, 
    .fade-leave-to {
      opacity: 0
    }
</style>