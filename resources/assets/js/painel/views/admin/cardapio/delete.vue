<template>
    <div class="main-content">
        <div class="page-header">
            <h3>Remover produto</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item active"><router-link to="/seller/cardapio">Produtos</router-link></li>
                <li class="breadcrumb-item active">Remover </li>
            </ol>
        </div>
        <div class="card">
            <div class="card-block">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-8">
                        <h5>Tem certeza que quer excluir o produto <strong>{{ product.name }}</strong>?</h5>
                        <a href="" class="btn btn-success btn-lg" @click.prevent="remove()">SIM</a> 
                        <router-link :to="'/seller/cardapio/' + product.id + '/edit'" class="btn btn-danger btn-lg">NÃO</router-link>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <router-link :to="'/admin/sellers/' + product.id + '/ver'" class="btn btn-default btn-sm">
                <i class="fa fa-arrow-left"></i> Voltar</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import { HttpService } from '../../../services/httpService';
    let httpService = new HttpService();

    export default {
        data: function () {
            return {
                product: {}
            }
        },
        methods: {
            remove() {
                httpService.build('admin/v1/products')
                .remove(this.$route.params['id'])
                .then(() => {
                    toastr.success('Excluído com sucesso!', 'Produto '+ this.product.name);
                    this.$router.push('/seller/cardapio');
                });
            }
        },
        mounted() {
            httpService.build('admin/v1/products/' + this.$route.params['id'])
            .list()
            .then((res) => {
                this.product = res.data;
            });
        }
    }
</script>