<template>
    <div>
        <vue-loading v-show="loading" type="bubbles" color="#F95700" :size="{ width: '50px', height: '50px' }" key="1"></vue-loading>

        <div v-if="!loading && orders.length > 0">

            <div class="row">

            <div class="col-md-3">
                <div class="form-group">
                    <select class="form-control form-control-sm" v-model="perPage">
                        <option selected>Escolha uma quantidade</option>
                        <option v-for="option in pageOptions" :value="option.value">{{ option.text }}</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" placeholder="faça uma busca" class="form-control form-control-sm" v-model.trim="filter">
                </div>
            </div>

            </div>

            <b-table striped hover show-empty
                :items="orders"
                :fields="table.cols"
                :current-page="currentPage"
                :per-page="perPage"
                :filter="filter"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                @filtered="onFiltered">

                <template slot="payment" scope="row">
                    <i :class="'fa fa-2x ' + brandCard(row.value)"></i>
                </template>

                <template slot="status_delivery" scope="row">
                    {{ statusDelivery(row.value) }}
                </template>

                <template slot="amount" scope="row">
                    R$ {{ row.value.total }}
                </template>

                <template slot="created_at" scope="row">
                    {{ $moment(row.value).format('DD/M/Y H:m:s') }}
                </template>

                <template slot="actions" scope="row">
                    <button class="btn btn-sm btn-primary" @click="show(row.item, index)">
                        <i class="fa fa-share"></i> Detalhes
                    </button>
                </template>

            </b-table>

            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <b-pagination :total-rows="table.rows" :per-page="perPage" v-model="currentPage" />
                </div>
            </div>
        </div>

        <div v-else>
            <p class="text-muted">Você não realizou nenhuma compra!</p>
        </div>
    </div>
</template>

<script>
import vueLoading from 'vue-loading-template'
import {moment} from '../app'
import services from '../../painel/services/moip/orders'

export default {
    name: 'list-orders',
    data() {
        return {
            loading: false,
            orders: [],
            table: {
                    cols: {
                        orderId: {label: 'Código'},
                        payment: {label: 'Dados Pagamento'},
                        amount: {label: 'Status Pedido', sortable: true},
                        status: {label: 'Status', sortable: true},
                        status_delivery: {label: 'Status da Entrega', sortable: true},
                        created_at: {label: 'Data Compra', sortable:true},
                        actions: {label: '#'}
                    },
                    rows: 0
                },
                currentPage: 1,
                perPage: 5,
                pageOptions: [{text:5,value:5}, {text:10,value:10}, {text:15,value:15}, {text:50,value:50}],
                sortBy: null,
                sortDesc: false,
                filter: null,
        }
    },
    computed: {
        'table.totalRows'() {
            return this.table.rows = this.orders.length
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
        },
        statusDelivery(status) {
            return services.formatStatusDelivery(status)
        },

        onFiltered(filterItems) {
            this.table.rows = filterItems.length
            this.currentPage = 1
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