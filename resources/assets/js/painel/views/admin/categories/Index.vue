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

                        </b-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        data(){
            return {
                table: {
                    cols: {
                        id: {label: 'ID', sortable: true},
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
            ...mapActions({all: 'categories/all'}),

            onFiltered(filterItems) {
                this.table.rows = filterItems.length
                this.currentPage = 1
            }
        },


    }
</script>