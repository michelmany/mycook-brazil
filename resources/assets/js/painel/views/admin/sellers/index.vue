<template>
  <div class="main-content">
    <div class="page-header">
      <h3>Vendedores</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
        <li class="breadcrumb-item"><router-link to="/admin">Admin</router-link></li>
        <li class="breadcrumb-item active">Vendedores</li>
        <li class="action">
          <router-link :to="'/admin/sellers/new'" class="btn btn-primary btn-xs">novo</router-link>
        </li>
      </ol>

    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-block">
            <table id="responsive-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>
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
            .list({query: 'where[role]=vendedor'})
            .then((res) => {
              this.users = res.data.data;

              let data = [];
              res.data.data.forEach((value) => {
                let action = `<a href="/painel/admin/sellers/${value.id}/ver" class="btn btn-default btn-xs">ver</a>`;
                data.push([
                  value.id,
                  value.name,
                  value.email,
                  action,
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

<style>
    .breadcrumb .action {
        float: left;
        padding-left: 10px;
    }
</style>
