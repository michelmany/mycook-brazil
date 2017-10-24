<template>
    <div class="main-content">
        <div class="page-header">
            <h3>Detalhes do comprador</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link to="/admin/buyers">Compradores</router-link></li>
                <li class="breadcrumb-item active">Detalhes</li>
            </ol>
        </div>
        <!-- compradores card -->
        <div class="card">
            <div class="card-header">
                <div class="caption">
                    <h6><i class="fa fa-user"></i> {{ user.name }}</h6>
                </div>
                <div class="actions my-1">
                    <router-link :to="'/admin/buyers/' + user.id + '/edit'" class="btn btn-warning btn-sm">
                        <i class="fa fa-pencil"></i>Editar</router-link>
                    <router-link :to="'/admin/buyers/' + user.id + '/remove'" class="btn btn-danger btn-sm">
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
                        <div v-if="user.cpf">
                            <small>CPF:</small> {{ user.cpf }}
                            <the-mask style="display: none;" :masked="true" 
                            :mask="'###.###.###-##'" v-model="user.cpf"/>
                            <hr>
                        </div>
                        <div v-if="user.buyer.phone">
                            <small>Telefone:</small> {{ user.buyer.phone }}
                            <the-mask style="display: none;" :masked="true" 
                            :mask="['(##) ####-####', '(##) #####-####']" v-model="user.buyer.phone"/>
                            <hr>
                        </div>
                        <div v-if="user.buyer.birth">
                            <the-mask style="display: none;" :masked="true" 
                            :mask="'##/##/####'" v-model="user.buyer.birth"/>
                            <small>Data de nascimento:</small> {{ user.buyer.birth }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <div class="mt-1">
                    <router-link :to="'/admin/buyers'" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Voltar</router-link>
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
                    <div class="col-md-6" v-for="(address, index) in user.addresses">
                        <table class="table table-bordered">
                            <thead class="thead-default">
                              <tr>
                                <th>
                                    <a href="#" @click.prevent="removeAddress(address.id, index)" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Excluir</a>
                                </th>
                                <th>
                                    <!-- <a href="#" @click.prevent="updateDefault(address, index)"><i class="fa fa-check-square-o"></i> Principal</a> -->
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Nome</td>
                                    <td>{{ address.name }}</td>
                                </tr>
                                <tr>
                                    <td>CEP</td>
                                    <td>{{ address.cep }}</td>
                                </tr>
                                <tr>
                                    <td>Endereço</td>
                                    <td>{{ address.address }}</td>
                                </tr>
                                <tr>
                                    <td>Número</td>
                                    <td>{{ address.number }}</td>
                                </tr>
                                <tr>
                                    <td>Complemento</td>
                                    <td>{{ address.complement ? address.complement : '-----' }}</td>
                                </tr>
                                <tr>
                                    <td>Bairro</td>
                                    <td>{{ address.neighborhood }}</td>
                                </tr>
                                <tr>
                                    <td>Cidade</td>
                                    <td>{{ address.city }}</td>
                                </tr>
                                <tr>
                                    <td>Estado</td>
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

       let httpService = new HttpService();

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
      methods: {
          removeAddress(id, index) {
              httpService.build('admin/v1/address')
              .remove(id)
              .then((res) => {
                  toastr.success('Endereço excluído com sucesso!', '', {
                  timeOut: 500,
                    onHidden: () => {
                        this.user.addresses.splice(index, 1);
                    }
                  })
              });
          }
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