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
                        <div class="mt-2 d-flex justify-content-between flex-wrap">
                            <div>
                                <button type="button" class="btn btn-secondary btn-sm remove" @click="dec(item, index)">-</button>
                                <span>{{ item.qty }}</span>
                                <button type="button" class="btn btn-secondary btn-sm" @click="inc(item, index)">+</button>
                                <!-- open dialog -->
                                <b-button size="sm" variant="primary" class="ml-3" @click="addNote(item, index)" v-b-tooltip title="Adicionar observação!">
                                    <i class="fa fa-commenting"></i>
                                </b-button>
                                <!-- open dialog -->
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

                    <li class="list-unstyled cart__item" v-if="additional.length > 0" v-for="(item,index) in additional" :key="index">
                        {{ item.product }}
                        <div class="mt-2 d-flex justify-content-between flex-wrap">
                            <div>
                                <button class="btn btn-sm btn-secondary" :disabled="item.type === 'delivery_fee'" @click="removeAdditional(item,index)">-</button>
                                {{ item.detail }}
                            </div>
                            <div v-if="item.type && item.type === 'coupon'">
                                - R$ {{ item.price }}
                            </div>
                            <div v-else>
                                + R$ {{ item.price }}
                            </div>
                        </div>
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
            <coupon :total="totalItems" @couponDiscount="couponDiscount" v-if="additional.length < 2"></coupon>

            <div v-if="userIsLogged" class="btn-group" style="width: 100%;">
                <!--<button class="btn btn-primary" :disabled="items.length <= 0"><i class="fa fa-cart-arrow-down"></i> Limpar </button>-->
                <button class="btn btn-primary btn-block" :disabled="items.length <= 0" @click="createPayment()">Finalizar compra</button>
            </div>

            <a :href="'/entrar?intended='+pathname" class="btn btn-primary btn-block" v-else>Finalizar compra</a>

        </div>

        <!-- modal note -->
        <sweet-modal  ref="modalNote" title="Adicionar Observações" :id="currentModal.index">
            <textarea class="form-control" v-model="currentModal.item.note" rows="4" onresize="false"></textarea>
            <button class="btn btn-block btn-success mt-2" @click="cartProductUpdate(currentModal.item, currentModal.index)">Adicionar</button>
        </sweet-modal>
        <!-- modal note -->

    </div>
</template>

<script>
    import { eventBus } from '../../app';
    import {number_format} from '../../../painel/helpers/functions'
    import Moment from 'moment';
    import { extendMoment } from 'moment-range';
    import Coupon from '../utils/Coupon.vue'

    const moment = extendMoment(Moment);

    export default {
        props: {
            chefName: String,
            chefMoipId: String,
            chefId: Number,
            settings: Object
        },
        components: {
            Coupon
        },
        data() {
            return {
                items: [],
                additional: [],
                courier: {},
                total: '',
                totalItems: '',
                userIsLogged: false,
                pathname: '',
                currentModal: {
                    index: null,
                    item: {}
                }
            }
        },
        watch: {
            calculateTotal(total) {
                this.totalItems = total.toFixed(2);
                this.additional.forEach(m => {
                    this.total = (parseFloat(total) + parseFloat(m.price)).toFixed(2)
                })
            }
        },
        methods: {
            addNote(item, index){

                this.currentModal.index = index
                this.currentModal.item = item

                this.$refs.modalNote.open(index)
            },
            removeAdditional(item,index) {
                if(item.type === 'delivery_fee') {
                    toastr.info('Este item adicional não pode ser removido!', 'Opsssss', {timeOut: 1000});
                    return;
                }
                this.additional.splice(index, 1)
                this.total = (parseFloat(this.total) + parseFloat(item.price)).toFixed(2)
            },
            couponDiscount(coupon) {
                this.additional.push({
                    product: coupon.code,
                    type: 'coupon',
                    price: parseFloat(coupon.discount).toFixed(2),
                    detail: coupon.detail,
                    quantity: 1,
                    id: coupon.id
                });

                this.total = (this.total - coupon.discount).toFixed(2);
            },
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
                            this.$refs.modalNote.close(index)
                     })
            },
            createPayment() {
                toastr.info('Aguarde só um instante', 'Estamos Processando todas as Informações', {
                    timeOut: 2000,
                    onHidden: () => {
                        const payload = {
                            items: this.items,
                            additional: this.additional,
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
               _.set(item.item, 'note', 'observações....');
               axios.post('/moip/services/cart?seller='+this.pathname, item)
                    .then(res => {
                        // window.location.reload();
                        console.log('adicionado ao carrinho');
                    })
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
            this.$bus.$on('cartItems', (cartItems, cartData, item, selectedDateIndex, selectedTimes) => {
                this.items = cartItems;
                this.courier.time = cartData.time;
                this.courier.date = cartData.date;
                this.courier.fulldate = cartData.fulldate;
                this.addItemToCart({item, selectedDateIndex, selectedTimes, courier: this.courier})
            })

            // add frete to additional
            this.additional.push({
                product: 'Adicional',
                type: 'delivery_fee',
                price: parseFloat(this.settings.delivery_fee).toFixed(2),
                detail: 'Taxa de entrega',
                quantity: 1
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

<style lang="css">
    .sweet-modal{max-width: 480px;}
    .sweet-modal .sweet-title > h2 {
        line-height: 3;
    }
</style>
