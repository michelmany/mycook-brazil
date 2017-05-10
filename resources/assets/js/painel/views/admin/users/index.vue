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
    <div class="card">
      <div class="card-block">
        <table class="table table-hover table-striped">
          <thead>
          <tr>
            <th style="width: 1%">#</th>
            <th>Usuário</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="user in users.data">
            <td>{{ user.id }}</td>
            <td><mark>{{ user.role }}</mark> {{ user.name }} <small>{{ user.email }}</small></td>
            <td class="text-right">
              <router-link :to="'/admin/users/' + user.id + '/ver'" class="btn btn-success btn-xs">ver</router-link>
            </td>
          </tr>
          </tbody>
        </table>
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
    }
  }
</script>