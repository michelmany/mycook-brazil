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
            <div v-if="items && items.length > 0">
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
        <div v-if="items" class="card-footer text-muted">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Código do cupom">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button">Aplicar</button>
                </span>
            </div>

            <a href="#" class="btn btn-primary btn-block" @click="createPayment()" v-if="userIsLogged">Finalizar compra</a>
            <a :href="'/entrar?intended='+pathname" class="btn btn-primary btn-block" v-else>Finalizar compra</a>

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
        props: {
            chefName: String,
            chefMoipId: String
        },
        data() {
            return {
                items: [],
                courier: {},
                total: '',
                userIsLogged: false,
                pathname: ''
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
                this.cartProduct(item, this.courier, index);
            },
            dec(item, index) {

                if(item.qty > 1){
                    item.qty--;
                }

                this.cartProduct(item, this.courier, index);
            },
            formatedDate(time) {
                return moment(time).format('HH[h]mm') + "~" + moment(time).add(30, 'm').format('HH[h]mm')
            },
            userIsLoggedIn() {
                axios.get('/user-is-logged-in')
                     .then(res => {
                        this.userIsLogged = res.data.data
                     })
            },
            getCart() {
                axios.get('/moip/services/cart')
                     .then(res => {
                         if(res.status !== 204) {
                             this.items = res.data.items;
                             this.courier = res.data.courier;
                         }
                     });
            },
            cartProduct(items, courier, index = '') {
                axios.post('/moip/services/cart', {items, courier, index})
                     .then(res => {
                         console.log(res)
                     })
            },
            createPayment() {
                const payload = {items: this.items, seller: this.chefMoipId, total: parseFloat(this.total), courier: this.courier};
                axios.post('/moip/marketplace/order/process', payload)
                     .then(res => {
                         toastr.info('Aguarde.....', 'Seu Pedido foi Criado!', {
                             progressBar: true,
                             timeout: 2000,
                             onHidden: () => {
                                 window.location.href = res.data._links.checkout.payCreditCard.redirectHref;
                             }
                         });
                     })
                    .catch(error => {
                        // 400
                        if(error.response.satus === 400) {
                            toastr.warning(error.response.data.error, 'Impossivel Continuar',{
                                progressBar: true,
                                timeout: 2000,
                            })
                        }
                        // 412
                        if(error.response.status === 412) {
                            toastr.info(error.response.data.error, 'Processo Necessário', {
                                progressBar: true,
                                timeout: 2000,
                                onHidden: () => {
                                    if(error.response.data._link){
                                        window.location.href = error.response.data._link
                                    }
                                }
                            })
                        }
                        // 500
                        if(error.response.status === 500) {
                            toastr.error(error.response.data.error, 'Falha Interna', {
                                progressBar: true,
                                timeout: 2000,
                                onHidden: () => {
                                    window.location.href = error.response.data._link
                                }
                            })
                        }
                    })
            }
        },
        mounted() {
            // check user logged
            this.userIsLoggedIn();

            // get pathname
            this.pathname = window.location.pathname;
            
            // get cart history
            this.getCart();
        },
        created() {

            eventBus.$on('cartItems', (cartItems, cartData) => {
                // console.log(cartItems, cartData)
                this.items = cartItems;
                this.courier.time = cartData.time;
                this.courier.fulldate = cartData.fulldate;
                this.cartProduct(cartItems, cartData);
            })

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