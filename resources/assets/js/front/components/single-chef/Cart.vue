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
                                <button type="button" class="btn btn-secondary btn-sm remove" @click="dec(item, index)">-</button>
                                <span>{{ item.qty }}</span>
                                <button type="button" class="btn btn-secondary btn-sm" @click="inc(item, index)">+</button>
                                <b-button size="sm" secondary v-b-modal="'item_note_'+index" :ref="'btnShowItemNote'+index">
                                    <i class="fa fa-commenting"></i>
                                </b-button>
                            </div>
                            <div>
                                R$ {{ item.price }}
                            </div>
                        </div>
                        <div class="cart__qty" v-if="item.availableQty == 1">Apenas 1 produto disponível para o dia selecionado</div>
                        <div class="cart__qty" v-else>{{ item.availableQty }} produtos disponíveis para o dia selecionado</div>
                        <!-- modal note -->
                        <b-modal :id="'item_note_'+index" size="sm">
                            <template slot="modal-title">
                                <h3 style="color:#141414;">Observação</h3>
                                <h4 style="color: #9d9d9d; font-size: 16px;">Atenção! Items adicionais poderão ser cobrados</h4>
                            </template>
                            <textarea class="form-control" :value="items[0].note" v-model="item.note" rows="4" onresize="false"></textarea>
                            <template slot="modal-footer">
                                <b-btn variant="success" @click="cartProductUpdate(item, index)" block>Adicionar</b-btn>
                            </template>
                        </b-modal>
                        <!-- close modal note. -->
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
            <button class="btn btn-primary btn-block" :disabled="items.length <= 0" @click="createPayment()" v-if="userIsLogged">Finalizar compra</button>
            <a :href="'/entrar?intended='+pathname" class="btn btn-primary btn-block" v-else>Finalizar compra</a>

            <p class="text-info mt-3 text-center">
               <small> * Cobramos o valor fixo de R$ {{ getDeliveryFee() }} para entregas</small>
            </p>
        </div>
    </div>
</template>
'
<script>
    import { eventBus } from '../../app';
    import {number_format} from '../../../painel/helpers/functions'
    import Moment from 'moment';
    import { extendMoment } from 'moment-range';

    const moment = extendMoment(Moment);

    export default {
        props: {
            chefName: String,
            chefMoipId: String,
            chefId: Number,
            settings: Object
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
            getDeliveryFee(){
                return number_format(this.settings.delivery_fee, 2, ',', '.');
            },
            inc(item, index) {
                if (item.qty < item.availableQty) {
                    item.qty++;
                }
                this.cartProductUpdate(item, index);
            },
            dec(item, index) {
                const after = item.qty
                if(item.qty > 1){
                    item.qty--;
                }
                const before = item.qty

                if(after === before) {
                    item.qty = 0
                    this.items.splice(index, 1)
                    this.courier = {}
                    eventBus.$emit('remove-item', item)
                }
                this.cartProductUpdate(item, index);
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
                axios.get(`/moip/services/cart?seller=${this.pathname}`)
                     .then(res => {
                         if(res.status !== 204) {
                             this.items = res.data.items;
                             this.courier = res.data.courier;
                             this.$bus.$emit('getCartStorage', {
                               items: res.data.items,
                               courier: res.data.courier,
                               selectedDateIndex: res.data.selectedDateIndex,
                               selectedTimes: res.data.selectedTimes
                             })
                         }
                     });
            },
            cartProductUpdate(item,index) {
                axios.put(`/moip/services/cart/${index}?seller=${this.pathname}`, {item})
                     .then(res => {
                         this.$root.$emit('bv::hide::modal', 'item_note_'+index)
                     })
            },
            createPayment() {
                toastr.info('Aguarde só um instante', 'Estamos Processando todas as Informações', {
                    timeOut: 2000,
                    onHidden: () => {
                        const payload = {
                            items: this.items,
                            seller: this.chefMoipId,
                            seller_id: this.chefId,
                            total: parseFloat(this.total),
                            courier: this.courier,
                            pathname: this.pathname
                        };

                        axios.post('/moip/marketplace/order/process', payload)
                            .then(res => {
                                toastr.success('Aguarde, iremos redireciona-lo','Seu Pedido foi Criado!', {
                                    progressBar: true,
                                    timeout: 2000,
                                    onHidden: () => {
                                        window.location.href = res.data;
                                    }
                                });
                            })
                            .catch(error => {
                                // 400
                                if(error.response.status === 400) {
                                    toastr.warning(error.response.data.error, 'Impossivel Continuar',{
                                        progressBar: true,
                                        timeout: 2000,
                                    })
                                }
                                // 422 and 412
                                if(error.response.status === 422 || error.response.status === 412) {
                                    toastr.error(error.response.data.error, 'Processo Necessário', {
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
                })
            },
            addItemToCart(item) {
               _.set(item.item, 'note', 'observações....')
               axios.post('/moip/services/cart?seller='+this.pathname, item)
                    .then(res => console.log(''))
            },

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
            eventBus.$on('cartItems', (cartItems, cartData, item, selectedDateIndex, selectedTimes) => {
                // console.log(cartItems, cartData)
                this.items = cartItems;
                this.courier.time = cartData.time;
                this.courier.fulldate = cartData.date;
                // this.cartProduct(cartItems, cartData);
                this.addItemToCart({item, selectedDateIndex, selectedTimes, courier: this.courier})
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
