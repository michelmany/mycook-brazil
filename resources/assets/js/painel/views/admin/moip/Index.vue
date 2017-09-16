<template>
    <div class="main-content" id="moipPage">
        <div class="page-header">
            <h4>Moip</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item active">Moip</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Credenciais Moip </h3>
                    </div>
                    <div class="card-block">
                        <ul class="list-group" v-if="this.moip">
                            <li class="list-group-item">
                                <span class="badge badge-primary">ID Cliente</span> <i>{{ this.moip.moipId}}</i>
                            </li>
                            <li class="list-group-item">
                                <span class="badge badge-primary">Token de Acesso</span> <i>{{ this.moip.moipAccessToken}}</i>
                            </li>
                        </ul>

                        <ul class="list-group" v-else>
                            <li class="list-group-item list-group-item-text">
                                <p> A plataforma necessita de sua autorização para podermos lidar com seus processos de venda.</p>

                                <p>
                                    Sem sua permissão não podemos efetuar transações envolvendo sua conta, por esse motivo necessitamos
                                    da sua permissão!
                                </p>

                            </li>
                            <li class="list-group-item">
                                <a :href="'/moip/marketplace/authorize?token='+authToken" class="btn btn-primary btn-block">
                                    Eu Concordo, continuar com autorização
                                </a>

                            </li>
                        </ul>
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
    const serviceMoip =  httpService.build('auth/services/moip');

    export default {
        data() {
          return {
              moip: '',
              authToken: ''
          }
        },
        methods: {
            verify() {
                serviceMoip.get('check')
                    .then(res => {

                        toastr.success('Sua conta já foi sincronizada com nosso Marketplace!');
                        this.moip = res.data.data;

                    }).catch(res => {
                        toastr.info('Você não sincronizou sua conta com nossa plataforma.')
                    })
            }
        },
        mounted() {

            this.verify()

            this.authToken = Ls.get('auth.token')
        }
    }
</script>