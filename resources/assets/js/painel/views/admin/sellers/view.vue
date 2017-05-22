<template>
    <div class="main-content">
        <div class="page-header">
            <h3>Detalhes do vendedor</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link to="/admin">Admin</router-link></li>
                <li class="breadcrumb-item active">Vendedores</li>
            </ol>
        </div>
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-lg-4">
                        <avatar :photo-url="user.avatar_full_url"></avatar>
                        <div class="caption mt-3">
                            <p><small>Envie uma logo ou foto<br>Tamanho ideal: 400x400 pixels</small></p>
                        </div>
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
                        <p><small>Telefone:</small> {{ user.seller.phone }}</p>
                        <div v-if="user.seller.phone2 != null">
                            <hr>
                            <p><small>Telefone 2:</small> {{ user.seller.phone2 }}</p>
                        </div>
                        <div v-if="user.seller.phone3 != null">
                            <hr>
                            <p><small>Telefone 3:</small> {{ user.seller.phone3 }}</p>
                        </div>
                        <div v-if="user.seller.phone4 != null">
                            <hr>
                            <p><small>Telefone 4:</small> {{ user.seller.phone4 }}</p>
                        </div>
                        <div v-if="user.seller.phone5 != null">
                            <hr>
                            <p><small>Telefone 5:</small> {{ user.seller.phone5 }}</p>
                        </div>
                        <hr>
                        <p><small>Formação:</small> {{ user.seller.formacao }}</p>
                        <hr>
                        <p><span class="fa fa-facebook"></span>
                            <a :href="user.seller.facebook" target="_blank">
                                 <small>{{ user.seller.facebook }}</small>
                            </a>
                        </p>
                        <hr>
                        <p><span class="fa fa-instagram"></span>
                            <a :href="user.seller.instagram" target="_blank">
                                 <small>{{ user.seller.instagram }}</small>
                            </a>
                        </p>
                        <hr>
                        <p><small>Tipos de entrega:</small> {{ user.seller.type_delivery | join(' - ') }}</p>
                        <hr>
                        <p><small>Distância de entrega:</small> {{ user.seller.distance_delivery }}</p>
                        <hr>
                        <p><small>Quantidade de pratos:</small> {{ user.seller.plates_quantity }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <router-link :to="'/admin/sellers'" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Voltar</router-link>
                <router-link :to="'/admin/sellers/' + user.id + '/edit'" class="btn btn-warning btn-sm">
                    <i class="fa fa-pencil"></i>Editar</router-link>
                <router-link :to="'/admin/sellers/' + user.id + '/remove'" class="btn btn-danger btn-sm">
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
                  seller: {},
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
                this.user.seller = res.data.seller || {};
            });
        }
    }
</script>