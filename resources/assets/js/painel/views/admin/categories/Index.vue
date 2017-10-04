<template>
    <div class="main-content" id="moipPage">
        <div class="page-header">
            <h4>Gerenciar Categorias</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item active">Categorias</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <!--<div class="card-header">-->
                        <!--<h3 class="card-title"> Gerenciar Categorias </h3>-->
                    <!--</div>-->
                    <div class="card-block">

                        <b-table striped hover show-empty
                                 :items="categories"
                                 :fields="table.cols"
                                 :current-page="currentPage"
                                 :per-page="perPage"
                                 :filter="filter"
                                 :sort-by.sync="sortBy"
                                 :sort-desc.sync="sortDesc"
                                 :empty-text="emptyText"
                                 :empty-filtered-text="emptyFilteredText"
                                 @filtered="onFiltered">
                            <template slot="status" scope="row">
                                <div class="onoffswitch">
                                    <input type="checkbox"
                                           class="onoffswitch-checkbox"
                                           :id="'status_'+row.item.id"
                                           :checked="row.value"
                                           @change="updateStatus($event,row)"
                                    >
                                    <label class="onoffswitch-label" :for="'status_'+row.item.id"></label>
                                </div>
                            </template>
                            <template slot="created_at" scope="row">
                                {{ $moment(row.value).format('DD/MM/Y HH:mm:ss') }}
                            </template>
                            <template slot="actions" scope="row">
                                <div class="btn-group btn-group-sm">
                                    <router-link :to="{name: 'system-categories-edit', params: {id: row.item.id}}" class="btn btn-primary">
                                        <i class="fa fa-edit"></i> editar
                                    </router-link>
                                    <button class="btn btn-primary" @click="destroy({id: row.item.id, index: row.index})">
                                        <i class="fa fa-trash-o"></i> remover
                                    </button>
                                       <!--<router-link :to="{name: 'system-categories-delete', params: {id: row.item.id}}" class="btn btn-primary">-->
                                        <!--<i class="fa fa-trash-o"></i> remover-->
                                    <!--</router-link>-->
                                </div>
                            </template>
                        </b-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters, mapState} from 'vuex'
    import bus from '../../../services/bus'

    export default {
        data(){
            return {
                table: {
                    cols: {
                        id: {label: 'ID', sortable: true},
                        name: {label: 'Nome', sortable: true},
                        status: {label: 'Status', sortable: true},
                        created_at: {label: 'Data Criação', sortable: true},
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
            ...mapGetters({categories: 'categories/all'}),
            'table.totalRows'(){
                return this.table.rows = this.categories.length
            },
        },

        methods: {
            ...mapActions({all: 'categories/all', update: 'categories/update', destroy: 'categories/destroy'}),

            onFiltered(filterItems) {
                this.table.rows = filterItems.length;
                this.currentPage = 1
            },

            updateStatus(event, category) {
                let status = event.target.checked;
                let payload = {id: category.item.id, data: {status} };
                this.update(payload)
            },
        },

        created() {
            this.all();

            bus.$on('category delete', payload => {
                toastr.info('Categoria removida!', null, {
                    timeOut: 1500,
                    onHidden:() => this.categories.splice(payload.index, 1)
                })
            })
        }

    }
</script>