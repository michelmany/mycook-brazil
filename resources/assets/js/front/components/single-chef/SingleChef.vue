<template>
    <div>
        <div class="row">
            <!-- Cardápio -->
            <div class="col-md-12 col-lg-8">
                <cardapio :chef-id="seller.seller.id"></cardapio>
            </div>
            <!-- Carrinho -->
            <div class="col-md-12 col-lg-4 hidden-md-down">
                <cart :chef-name="seller.name" :chef-moip-id="moip.moipId" :chef-id="seller.seller.id" :settings="settings"></cart>
            </div>
        </div>

        <b-button size="sm" variant="primary" @click="showModal" class="btn-view-cart hidden-lg-up">
            Ver carrinho
        </b-button>

        <b-modal ref="modalCart" size="lg" class="hidden-lg-up">
            <cart :chef-name="seller.name" :chef-moip-id="moip.moipId" :chef-id="seller.seller.id" :settings="settings"></cart>
            <template slot="modal-footer">
                <b-btn variant="link" @click="hideModal" block>Fechar carrinho</b-btn>
            </template>
        </b-modal>

    </div>
</template>


<script>
    import Cardapio from './Cardapio.vue'
    import Cart from './Cart.vue'

    export default {
        props: ['seller', 'moip', 'settings'],
        components: {
            Cardapio, Cart
        },
        methods: {
            showModal() {
                this.$refs.modalCart.show();
            },
            hideModal() {
                this.$refs.modalCart.hide();
            },
            onResize() {
                var self = this;
                window.onresize = function(e) {
                    if(window.innerWidth >= 992) {
                        self.hideModal();
                    }
                }
            }
        },
        mounted() {
            console.log('motou cardápio!');
            this.onResize();
        }
    }
</script>

<style scoped>
    .btn-view-cart {
        width: 100%;
        left: 0;
        height: 55px;
        border-radius: 0;
        font-size: 18px;
    }
</style>
