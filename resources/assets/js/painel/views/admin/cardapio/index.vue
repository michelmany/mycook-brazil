<template>
    <div class="main-content">
        <div class="page-header">
            <h4>Produtos</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link to="/admin/cardapio">Cardapio</router-link></li>
                <li class="breadcrumb-item active">Produtos</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <table id="responsive-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Ls from '../../../services/ls'
    import { HttpService } from '../../../services/httpService';

    export default {
        data: function () {
            return {
                user: {},
                seller_id: '',
                products: []
            }
        },
        methods: {
            listProducts() {
                let httpService = new HttpService();
                httpService.build('admin/v1/products')
                .list({query: 'where[seller_id]='+this.seller_id})
                .then((res) => {
                    this.products = res.data.data;

                    let data = [];

                    res.data.data.forEach((value) => {
                        let action = `<a href="/painel/admin/cardapio/${value.id}/edit" class="btn btn-info btn-xs"><i class="fa fa-eye"></i>Detalhes</a>`;
                        value.active = (value.active ? 'Ativo' : 'Inativo');
                        data.push([
                            value.id,
                            value.name,
                            value.price,
                            action,
                            ]);
                    });

                    $('#responsive-datatable').DataTable({
                        responsive: true,
                        data: data,
                        language: {
                            url: "assets/js/datatables-pt-br.json"
                          },
                        columns: [
                            {title: "Id", width: "20px"},
                            {title: "Nome do Produto"},
                            {title: "Preço"},
                            {title: "Ação", width: "70px"},
                        ],
                        fixedColumns: true
                    });
                });
            },
            setUser() {
                let user = Ls.get('auth.user');

                if (user !== null) {
                  this.user = JSON.parse(user);
                }
                if(this.user.role === 'admin') {
                    this.seller_id = this.$route.params.id
                    console.log(this.seller_id);
                }
                if(this.user.role === 'vendedor') {
                    console.log('vendedor')
                    this.seller_id = this.user.seller.id;
                    console.log(this.seller_id);
                }
            }
        },
        computed: {

        },
        mounted() {
            this.setUser()
            this.listProducts()
        }
    }
</script>

<style>
    .breadcrumb .action {
        float: left;
        padding-left: 10px;
    }
</style>
