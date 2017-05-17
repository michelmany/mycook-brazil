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
              this.users = res.data.data;

              console.log(this.users);
              let data = [];
              res.data.data.forEach((value) => {
                let action = `<a href="/painel/admin/users/${value.id}/ver" class="btn btn-default btn-xs">ver</a>`;
                data.push([
                  //value.active,
                  //value.avatar,
                  //value.cpf,
                  //value.created_at,
                  value.id,
                  value.name,
                  value.email,
                  action,
                  //value.role,
                  //value.updated_at,
                ]);
              });


            $('#responsive-datatable').DataTable({
                  responsive: true,
                  data: data,
                  columns: [
                    {title: "Id"},
                    {title: "Nome"},
                    {title: "Email"},
                    {title: ""},
                  ]
              });
            });

        }
    }
</script>

