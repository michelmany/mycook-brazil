<template>
    <div class="main-content" id="moipPage">
        <div class="page-header">
            <h4>Gerenciar Cupons</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item active">Cupons</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <select class="form-control form-control-sm" v-model="perPage">
                                        <option selected>Escolha uma quantidade</option>
                                        <option v-for="option in pageOptions" :value="option.value">{{ option.text }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-9">
                                <div class="form-group">
                                    <input type="text" placeholder="faça uma busca" class="form-control form-control-sm" v-model.trim="filter">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">

                        <b-table striped hover show-empty
                                 :items="coupons"
                                 :fields="table.cols"
                                 :current-page="currentPage"
                                 :per-page="perPage"
                                 :filter="filter"
                                 :sort-by.sync="sortBy"
                                 :sort-desc.sync="sortDesc"
                                 :empty-text="emptyText"
                                 :empty-filtered-text="emptyFilteredText"
                                 @filtered="onFiltered">

                            <template slot="expires_in" scope="row">
                                {{ row.value ? $moment(row.value).fromNow() : 'Não Expira' }}
                            </template>

                            <template slot="created_at" scope="row">
                                {{ $moment(row.value).format('D/M/Y HH:mm:ss') }}
                            </template>

                            <template slot="actions" scope="row">
                                <div class="btn-group btn-group-sm">
                                    <router-link :to="{name: 'system-coupons-edit', params: {id: row.item.id}}" class="btn btn-primary">
                                        <i class="fa fa-edit"></i> Editar
                                    </router-link>
                                    <button class="btn btn-primary" @click="destroy({id: row.item.id, index: row.index})"><i class="fa fa-trash"></i> Remover</button>
                                </div>
                            </template>

                        </b-table>
                    </div>
                    <div class="card-footer">
                        <div class="pull-right">
                            <b-pagination :total-rows="table.rows" :per-page="perPage" v-model="currentPage" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'
    import bus from '../../../services/bus'

    export default {
        data(){
            return {
                table: {
                    cols: {
                        id: {label: 'ID', sortable: true},
                        code: {label: 'Código', sortable: true},
                        uses: {label: 'Total de Uso', sortable: true},
                        created_at: {label: 'Data do Cadastro', sortable: true},
                        actions: {label: 'Gerenciar'}
                    },
                    rows: 0
                },
                currentPage: 1,
                perPage: 10,
                pageOptions: [{text:5,value:5}, {text:10,value:10}, {text:15,value:15}, {text:50,value:50}],
                sortBy: null,
                sortDesc: false,
                filter: null,
                emptyText: 'Não há registros para mostrar',
                emptyFilteredText: 'Não há registros que correspondam ao seu pedido',
            }
        },

        computed: {
            ...mapGetters({coupons: 'coupons/all'}),
            'table.totalRows'(){
                return this.table.rows = this.coupons.length
            },
        },

        methods: {
            ...mapActions({all: 'coupons/all', update: 'coupons/update', destroy: 'coupons/destroy'}),

            onFiltered(filterItems) {
                this.table.rows = filterItems.length;
                this.currentPage = 1
            },

        },

        created() {
            this.all();

            bus.$on('coupon delete success', payload => {
                toastr.info('Cupom removido com sucesso!', null, {
                    timeOut: 1500,
                    onHidden:() => this.coupons.splice(payload.index, 1)
                })
            })
        }

    }
</script>