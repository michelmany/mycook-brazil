<template>
    <div class="main-content">
        <div class="page-header">
            <h3>Removendo usuário</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
        </div>
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-lg-4"><img :src="user.avatar + '?s=200'" class="img-responsive" v-if="user.avatar"></div>
                    <div class="col-lg-6">

                        <h5>Tem certeza que quer excluir o usuário <strong>{{ user.name }}</strong>?</h5>
                        <a href="" class="btn btn-success btn-lg" @click.prevent="remove()">SIM</a> <router-link :to="'/admin/users/' + user.id + '/ver'" class="btn btn-danger btn-lg">NÃO</router-link>

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <router-link :to="'/admin/users/' + user.id + '/ver'" class="btn btn-default btn-sm">
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
                user: {}
            }
        },
        methods: {
            remove() {
                httpService.build('admin/v1/users')
                .remove(this.$route.params['id'])
                .then(() => {
                    toastr.success('Excluído com sucesso!', 'Usuário '+ this.user.name);
                    this.$router.push('/admin/users');
                });
            }
        },
        mounted() {
            httpService.build('admin/v1/users/' + this.$route.params['id'])
            .list()
            .then((res) => {
                this.user = res.data;
            });
        }
    }
</script>