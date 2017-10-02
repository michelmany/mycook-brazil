<template>
    <div>
        <vue-loading v-show="loading" type="bubbles" color="#F95700" :size="{ width: '50px', height: '50px' }" key="1"></vue-loading>
        
        <table class="table table-stripped" v-if="!loading">
            
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cartão</th>
                    <th>Total Pago</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Opções</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(order,index) in orders" :key="index">
                    <td>
                        <span class="badge badge-primary">{{ order.orderId }}</span>
                    </td>
                    <td>
                        <i :class="'fa fa-2x ' + brandCard(order.payment)"></i>
                    </td>
                    <td>
                        R$ {{ order.amount.total }}
                    </td>
                    <td>
                        {{ order.status }}
                    </td>
                    <td>
                        {{ $moment(order.created_at).format('ddd/MM HH:m:s') }}
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary" @click="show(order, index)">
                            <i class="fa fa-share"></i> detalhes
                        </button>
                    </td>
                </tr>
            </tbody>
            
        </table>

    </div>
</template>

<script>
import vueLoading from 'vue-loading-template'
import {moment} from '../app'
export default {
    name: 'list-orders',
    data() {
        return {
            loading: false,
            orders: []
        }
    },
    methods: {
        list() {
            this.loading = true
            axios.get('/moip/services/orders')
                 .then(res => {
                    this.orders = res.data.orders;
                    this.loading = false;
                })
        },
        show(order, index) {
            window.location.href = '/minha-conta/pedidos/' + order.orderId
        },
        brandCard(payment) {
            if(!payment) {
                return 'fa-credit-card';
            }
            let brand;

            switch (payment.detail.brand) {
                case 'MASTERCARD' : brand = 'fa-cc-mastercard'; break;
                case 'VISA' : brand = 'fa-cc-visa'; break;
                default: brand = 'fa-credit-card';
            }

            return brand;
        }
    },
    mounted() {
        this.list();
    }
}
</script>

<style>
    .fade-enter-active, 
    .fade-leave-active {  transition: opacity .5s }
    .fade-enter, 
    .fade-leave-to {  opacity: 0}
</style>