<template>
    <div class="main-content">
        <div class="page-header">
            <h4>Vendedores</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item active"><router-link to="/admin/sellers">Vendedores</router-link></li>
                <li class="breadcrumb-item active">Detalhes</li>
            </ol>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="caption">
                    <h6><i class="fa fa-user"></i> {{ user.name }}</h6>
                </div>
                <div class="actions my-1">
                    <router-link :to="'/admin/sellers/' + user.id + '/edit'" class="btn btn-warning btn-sm">
                        <i class="fa fa-pencil"></i>Editar</router-link>
                    <router-link :to="'/admin/sellers/' + user.id + '/remove'" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i>Excluir</router-link>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-lg-4">
                        <avatar :photo-url="user.avatar_full_url"></avatar>
                        <div class="caption mt-3">
                            <p><small>Envie uma logo ou foto<br>Tamanho ideal: 400x400 pixels</small></p>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-3 mt-lg-0">
                        <div>
                            <small>Email:</small> {{ user.email }}
                            <hr>
                        </div>
                        <div>
                            <small>Status:</small> {{ user.active ? 'Ativo' : 'Inativo' }}
                            <hr>
                        </div>
                        <div>
                            <small>CPF:</small> {{ user.cpf }}
                            <the-mask style="display: none;" :masked="true" 
                            :mask="'###.###.###-##'" v-model="user.cpf"/>
                            <hr>
                        </div>
                        <div v-if="user.seller.phone2 != null">
                            <the-mask style="display: none;" :masked="true" 
                            :mask="['(##) ####-####', '(##) #####-####']" v-model="user.seller.phone"/>
                            <small>Telefone:</small> {{ user.seller.phone }}
                            <hr>
                        </div>
                        <div v-if="user.seller.phone2 != null">
                            <the-mask style="display: none;" :masked="true" 
                            :mask="['(##) ####-####', '(##) #####-####']" v-model="user.seller.phone2"/>
                            <small>Celular:</small> {{ user.seller.phone2 }}
                            <hr>
                        </div>
                        <div v-if="user.seller.phone3 != null">
                            <small>Telefone 3:</small> {{ user.seller.phone3 }}
                            <hr>
                        </div>
                        <div v-if="user.seller.phone4 != null">
                            <small>Telefone 4:</small> {{ user.seller.phone4 }}
                            <hr>
                        </div>
                        <div v-if="user.seller.phone5 != null">
                            <small>Telefone 5:</small> {{ user.seller.phone5 }}
                            <hr>
                        </div>
                        <div v-if="user.seller.facebook">
                            <span class="fa fa-facebook"></span>
                            <a :href="'https://facebook.com/' + user.seller.facebook" target="_blank">
                                 <small>{{ user.seller.facebook }}</small>
                            </a>
                        <hr>
                        </div>
                        <div v-if="user.seller.instagram">
                            <span class="fa fa-instagram"></span>
                            <a :href="'https://instagram.com/' + user.seller.instagram" target="_blank">
                                 <small>{{ user.seller.instagram }}</small>
                            </a>
                            <hr>
                        </div>
                        <div v-if="user.seller.type_delivery">
                            <small>Tipos de entrega:</small> {{ user.seller.type_delivery | join(' - ') }}
                            <hr>
                        </div>
                        <div v-if="user.seller.dishes">
                            <small>Quais pratos deseja vender?</small> {{ user.seller.dishes }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <div class="mt-1">
                    <router-link :to="'/admin/sellers'" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Voltar</router-link>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="caption">
                    <h6><i class="fa fa-picture-o" aria-hidden="true"></i> Imagens</h6>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div v-if="user.seller.fotos && user.seller.fotos.length === 0" class="col-md-12">
                        <p><small>Nenhuma imagem cadastrada</small></p>
                    </div>
                    <div class="col-md-4 image-wrapper" v-for="photo in user.seller.fotos" >
                        <div class="image-container">
                            <img :src="photo.full_url" class="img-fluid" style="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Endereços -->
        <div class="card">
            <div class="card-header">
                <div class="caption">
                    <h6><i class="fa fa-map-marker" aria-hidden="true"></i> Endereços</h6>
                </div> 
                <div class="actions">
                    <router-link :to="'/admin/address/new/' + user.id + '/' + user.role" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Adicionar Novo</router-link>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div v-if="user.addresses.length === 0" class="col-md-12">
                        <p><small>Nenhum endereço cadastrado</small></p>
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
        </div><!-- /enderecos -->
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