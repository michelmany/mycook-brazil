<template>
    <div class="main-content">
        <div class="page-header">
            <h3>Detalhes do usuário</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link to="/admin/users">Usuários</router-link></li>
                <li class="breadcrumb-item active">Detalhes</li>
            </ol>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="caption">
                    <h6><i class="fa fa-user"></i> {{ user.name }}</h6>
                </div>
                <div class="actions my-1">
                    <router-link :to="'/admin/users/' + user.id + '/edit'" class="btn btn-warning btn-sm">
                        <i class="fa fa-pencil"></i>Editar</router-link>
                    <router-link :to="'/admin/users/' + user.id + '/remove'" class="btn btn-danger btn-sm">
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
                            :mask="'###.###.###-##'" v-model="user.cpf"></the-mask>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <router-link :to="'/admin/users'" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Voltar</router-link>
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
                user: {}
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
            });
        }
    }
</script>