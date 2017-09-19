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
                        lista de vendas
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import { HttpService } from '../../../services/httpService';
    import Ls from '../../../services/ls';

    const httpService = new HttpService;
    const service =  httpService.build('moip/marketplace/seller/orders');

    export default {
        data() {
          return {
              authToken: ''
          }
        },
        methods: {
        },
        mounted() {
            this.authToken = Ls.get('auth.token');

            console.log(service)
        }
    }
</script>