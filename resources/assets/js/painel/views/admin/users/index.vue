<template>
    <div class="main-content">
        <div class="page-header">
            <h3>Usuários</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link to="/admin">Admin</router-link></li>
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <table id="responsive-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Função</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="user in users.data" >
                                    <td>{{ user.id }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.role }}</td>
                                    <td style="width: 20px" class="text-center">
                                        <router-link :to="'/admin/users/'+user.id+'/ver'" class="btn btn-info btn-sm"><i class="fa fa-eye"></i>Detalhes</router-link>
                                    </td>
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
    export default {
        data: function () {
            return {
                users: []
            }
        },
        mounted() {
            let httpService = new HttpService();
            httpService.build('admin/v1/users')
            .list()
            .then((res) => {
                this.users = res.data;
            });

            $('#responsive-datatable').DataTable({
                responsive: true
            });

        }
    }
</script>

