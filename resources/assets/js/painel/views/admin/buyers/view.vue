<template>
    <div class="main-content">
        <div class="page-header">
            <h3>Detalhes do comprador</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link to="/admin">Admin</router-link></li>
                <li class="breadcrumb-item active">Compradores</li>
            </ol>
        </div>
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-lg-4">
                        <avatar :photo-url="user.avatar_full_url"></avatar>
                    </div>
                    <div class="col-lg-6 mt-3 mt-lg-0">
                        <p><small>Nome:</small> {{ user.name }}</p>
                        <hr>
                        <p><small>Email:</small> {{ user.email }}</p>
                        <hr>
                        <p><small>Função:</small> {{ user.role }}</p>
                        <hr>
                        <p><small>Status:</small> {{ user.active ? 'Ativo' : 'Inativo' }}</p>
                        <hr>
                        <p><small>CPF:</small> {{ user.cpf }}</p>
                        <hr>
                        <p><small>Telefone:</small> {{ user.buyer.phone }}</p>
                        <hr>
                        <p><small>Data de nascimento:</small> {{ user.buyer.birth | datetime('DD/MM/YYYY')}}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <router-link :to="'/admin/buyers'" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Voltar</router-link>
                <router-link :to="'/admin/buyers/' + user.id + '/edit'" class="btn btn-warning btn-sm">
                    <i class="fa fa-pencil"></i>Editar</router-link>
                <router-link :to="'/admin/buyers/' + user.id + '/remove'" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i>Excluir</router-link>
            </div>
        </div>

        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Endereços
                            <small><router-link :to="'/admin/address/new/' + user.id + '/' + user.role" class="btn btn-primary btn-xs">novo</router-link></small>
                        </h3>
                        <div class="card" v-if="user.addresses.length === 0">
                            <div class="card-header bg-dark">
                                Nenhum endereço cadastrado
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" v-for="address in user.addresses">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <td>cep</td>
                                <td>{{ address.cep }}</td>
                            </tr>
                            <tr>
                                <td>endereço</td>
                                <td>{{ address.address }}</td>
                            </tr>
                            <tr>
                                <td>Número</td>
                                <td>{{ address.number }}</td>
                            </tr>
                            <tr>
                                <td>Complemento</td>
                                <td>{{ address.complement }}</td>
                            </tr>
                            <tr>
                                <td>bairro</td>
                                <td>{{ address.neighborhood }}</td>
                            </tr>
                            <tr>
                                <td>cidade</td>
                                <td>{{ address.city }}</td>
                            </tr>
                            <tr>
                                <td>estado</td>
                                <td>{{ address.state }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { HttpService } from '../../../services/httpService';
    import AvatarUpload from '../../../components/AvatarUpload';

    export default {
        data: function () {
            return {
                user: {
                  addresses: [],
                  buyer: {}
                }
            }
        },
      components: {
        avatar: AvatarUpload
      },
        mounted() {
            let httpService = new HttpService();
            httpService.build('admin/v1/users/' + this.$route.params['id'])
            .list()
            .then((res) => {
                this.user = res.data;
                this.user.buyer = res.data.buyer || {};
            });
        }
    }
</script>