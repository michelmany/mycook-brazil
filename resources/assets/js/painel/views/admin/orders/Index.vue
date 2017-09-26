<template>
    <div class="main-content" id="moipPage">
        <div class="page-header">
            <h4>Vendas</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item active">Minhas Vendas</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Minhas Vendas </h3>
                    </div>
                    <div class="card-block">
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

                            <template slot="status" scope="row">
                                {{row.item.status}}
                            </template>

                            <template slot="amount" scope="row">
                                R$ {{row.value.total}}
                            </template>

                            <template slot="status_delivery" scope="row">
                                Entregue
                            </template>

                            <template slot="actions" scope="row">
                                <a :href="'/painel/seller/orders/'+row.item.id" class="btn btn-sm btn-info">
                                    <i class="fa fa-plus"></i> Detalhes
                                </a>
                            </template>
                        </b-table>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <b-pagination :total-rows="table.rows" :per-page="perPage" v-model="currentPage" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex'
    export default {
        data() {
            return {
                table: {
                    cols: {
                        id: {label: 'ID', sortable:true},
                        orderId: {label: 'ID Pedido', sortable:true},
                        status: {label: 'Status Pedido'},
                        status_delivery: {label: 'Entrega'},
                        amount: {label: 'Total', sortable: true},
                        created_at: {label: 'Data Compra', sortable:true},
                        actions: {label: 'Gerenciar'}
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
            ...mapGetters({orders: 'orders/getOrders'}),
            'table.totalRows'(){
                return this.table.rows = this.orders.length
            },
        },
        methods: {
            ...mapActions({all: 'orders/all'}),
            onFiltered(filterItems) {
                this.table.rows = filterItems.length
                this.currentPage = 1
            }
        },
        created() {
            this.all()
        }
    }
</script>