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
                    <li v-for="item in items" class="list-unstyled cart__item">{{ item.name }}
                        <div class="mt-2 d-flex justify-content-between">
                            <div>
                                <button type="button" class="btn btn-secondary btn-sm" @click="dec(item)">-</button>
                                <span>{{ item.qty }}</span>
                                <button type="button" class="btn btn-secondary btn-sm" @click="inc(item)">+</button>
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
        <div v-if="items.length" class="card-footer text-muted">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Código do cupom">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button">Aplicar</button>
                </span>
            </div>
            <a href="#" class="btn btn-primary btn-block">Finalizar compra</a>
        </div>
    </div>
</template>

<script>
    import { eventBus } from '../../app';
    import Moment from 'moment';
    import { extendMoment } from 'moment-range';
    const moment = extendMoment(Moment);

    export default {
        props: {
            chefName: String
        },
        data() {
            return {
                items: '',
                courier: {},
                total: ''
            }
        },
        watch: {
            calculateTotal(total) {
                this.total = total;
            }
        },
        methods: {
            inc(item) {
                if (item.qty < item.availableQty) {
                    item.qty++;
                }
            },
            dec(item) {
                if (item.qty > 1) {
                    item.qty--;
                }
            },
            formatedDate(time) {
                return moment(time).format('HH[h]mm') + "~" + moment(time).add(30, 'm').format('HH[h]mm')
            }
        },
        mounted() {

        },
        created() {

            eventBus.$on('cartItems', (cartItems, cartData) => {
                // console.log(cartItems)
                this.items = cartItems;
                this.courier.time = cartData.time;
                this.courier.fulldate = cartData.fulldate;
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