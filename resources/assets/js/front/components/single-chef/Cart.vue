<template>
    <div class="card">
        <div class="card-header text-center">
            <h5>Seu carrinho<br><strong>{{ chefName}}</strong></h5>
            <div v-if="courier.time">
                <hr>
                <p>{{ courier.fulldate }} - {{ formatedDate(courier.time) }}</p>
            </div>
        </div>
        <div class="card-block">
            <div v-if="items.length">
                <ul class="px-0">
                    <li v-for="(item,index) in items" :key="index" class="list-unstyled cart__item">{{ item.name }}
                        <div class="mt-2 d-flex justify-content-between">
                            <div>
                                <button type="button" class="btn btn-secondary btn-sm" @click="dec(item, index)">-</button>
                                <span>{{ item.qty }}</span>
                                <button type="button" class="btn btn-secondary btn-sm" @click="inc(item, index)">+</button>
                            </div>
                            <div>
                                R$ {{ item.price }}
                            </div>
                        </div>
                        <div class="cart__qty" v-if="item.availableQty == 1">Apenas 1 disponível para o dia selecionado</div>
                        <div class="cart__qty" v-else>{{ item.availableQty }} disponíveis para o dia selecionado</div>
                    </li>
                </ul>
                <span class="float-right"><strong>Total: R$ {{ total }}</strong></span>
            </div>
            <div v-else class="text-center">
                <h4 class="card-title">Carrinho vazio</h4>
                <p class="card-text">Tá esperando o que?</p>
            </div>
        </div>
        <div v-if="items.length > 0" class="card-footer text-muted">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Código do cupom">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button">Aplicar</button>
                </span>
            </div>

            <a href="#" class="btn btn-primary btn-block" @click="createPayment()" v-if="userIsLogged">Finalizar compra</a>
            <a :href="'/entrar?intended='+pathname" class="btn btn-primary btn-block" v-else>Finalizar compra</a>

            <!-- -->
            <modal v-if="showModal" @close="clearCartHistory">
                <!--
                  you can use custom content here to overwrite
                  default content
                -->
                <iframe slot="body" style="width: 100%; min-height: 450px;" :src="checkoutPayment" frameborder="0"></iframe>
            </modal>
            <!-- -->

        </div>
    </div>
</template>
'
<script>
    import { eventBus } from '../../app';
    import Moment from 'moment';
    import { extendMoment } from 'moment-range';
    import Ls from '../../../painel/services/ls'

    const moment = extendMoment(Moment);


    export default {
        components: {
            modal: require('../../components/utils/Modal.vue')
        },
        props: {
            chefName: String,
            chefMoipId: String
        },
        data() {
            return {
                showModal: false,
                items: [],
                courier: {},
                total: '',
                userIsLogged: false,
                pathname: '',
                checkoutPayment: null,
                cartName: 'my-cart#',
                checkout: {
                    progress: 0,
                    response: null
                }
            }
        },
        watch: {
            calculateTotal(total) {
                this.total = total;
            }
        },
        methods: {
            inc(item, index) {
                if (item.qty < item.availableQty) {
                    item.qty++;
                }
                this.updateCart(item,index);
            },
            dec(item, index) {
                if (item.qty > 1) {
                    item.qty--;
                }
                this.updateCart(item,index);
            },
            updateCart(item, index) {

                var currentMyCart = JSON.parse(Ls.get(this.getCartName()));
                currentMyCart.splice(index, 1);

                var newList = [];
                newList.push(item);

                Ls.remove(this.getCartName());

                Ls.set(this.getCartName(), JSON.stringify(newList.concat(currentMyCart)))
            },
            formatedDate(time) {
                return moment(time).format('HH[h]mm') + "~" + moment(time).add(30, 'm').format('HH[h]mm')
            },
            createPayment() {
                const config = {
                    onUploadProgress: progressEvent => {
                        this.checkout.progress = Math.floor((progressEvent.loaded * 100) / progressEvent.total);
                    }
                };
                const payload = {items: this.items, seller: this.chefMoipId, total: parseFloat(this.total)};
                axios.post('/moip/marketplace/order/process', payload, config)
                     .then(res => {
                        toastr.info('Aguarde.....', 'Seu Pedido foi Criado!', {
                            progressBar: true,
                            timeout: 3000,
                            onHidden: () => {
                                    this.showModal = true;
                                    this.checkoutPayment = res.data._links.checkout.payCheckout.redirectHref;
                            }
                        });

                        this.checkout.response = res;
                     })
                    .catch(error => {
                        // 400
                        if(error.response.satus === 400) {
                            toastr.warning(error.response.data.error, 'Impossivel Continuar')
                        }
                        // 412
                        if(error.response.status === 412) {
                            toastr.info(error.response.data.error, 'Processo Necessário', {
                                onHidden: () => {
                                    window.location.href = error.response.data._link
                                }
                            })
                        }
                        // 500
                        if(error.response.status === 500) {
                            toastr.error(error.response.data.error, 'Falha Interna', {
                                onHidden: () => {
                                    window.location.href = error.response.data._link
                                }
                            })
                        }

                        this.checkout.response = error.response;
                    })
            },
            clearCartHistory(){

                if(!this.checkout.response){
                    // not action
                    this.showModal = false;
                    return;
                }

                // clear ls
                Ls.remove(this.getCartName());

                // close modal
                this.showModal = false;

                // alert and redirect
                toastr.success('Pedido Concluido!', '', {
                    progressBar: true,
                    timeout: 3000,
                    onHidden: () => {
                        window.location.href = '/minha-conta/perfil'
                    }
                })

            },
            userIsLoggedIn() {
                axios.get('/user-is-logged-in')
                     .then(res => {
                        this.userIsLogged = res.data.data
                     })
            },
            getLocalStorageCartItems() {
                return JSON.parse(Ls.get(this.getCartName()))
            },
            getCartName() {
                return this.cartName + this.pathname
            }
        },
        mounted() {
            // check user logged
            this.userIsLoggedIn();

            // get pathname
            this.pathname = window.location.pathname;

            // cart session storage
            this.items = this.getLocalStorageCartItems();
        },
        created() {

            eventBus.$on('cartItems', (cartItems, cartData) => {
                this.items = cartItems;
                this.courier.time = cartData.time;
                this.courier.fulldate = cartData.fulldate;
            })

            console.log(this.checkout.progress)
        },
        computed: {
            calculateTotal() {
                return _.sumBy(this.items, function(item) {
                    return (item.price * item.qty)
                })
            }
        }
    }
</script>