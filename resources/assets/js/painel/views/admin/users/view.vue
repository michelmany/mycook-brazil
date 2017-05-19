<template>
    <div class="main-content">
        <div class="page-header">
            <h3>Detalhes do usuário</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link to="/admin">Admin</router-link></li>
                <li class="breadcrumb-item active">Usuários</li>
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
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <router-link :to="'/admin/users'" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Voltar</router-link>
                <router-link :to="'/admin/users/' + user.id + '/edit'" class="btn btn-warning btn-sm">
                    <i class="fa fa-pencil"></i>Editar</router-link>
                <router-link :to="'/admin/users/' + user.id + '/remove'" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i>Excluir</router-link>
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