<template>
  <div class="main-content">
    <div class="page-header">
      <h3>Detalhes do usuários</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
        <li class="breadcrumb-item"><router-link to="/admin">Admin</router-link></li>
        <li class="breadcrumb-item active">Usuários</li>
      </ol>
    </div>
    <div class="card">
      <div class="card-block">
        <div class="row">
          <div class="col-md-2"><img :src="user.avatar + '?s=200'" class="img-responsive"></div>
          <div class="col-md-10">
            <h5>Perfil</h5>
            <p><mark>{{ user.name }} <small>{{ user.email }}</small></mark></p>
            <p>Tipo de usuário: {{ user.role }}</p>
            <p>Conta ativa?: {{ user.active ? 'sim' : 'não' }}</p>
            <p>CPF: {{ user.cpf }}</p>

            <hr>
            <h5>Perfil de vendedor</h5>

            <hr>
            <h5>Perfil de comprador</h5>

          </div>
        </div>
      </div>
      <div class="card-footer">
        <router-link :to="'/admin/users'" class="btn btn-default">voltar</router-link>
        <router-link :to="'/admin/users/' + user.id + '/edit'" class="btn btn-info">editar</router-link>
        <router-link :to="'/admin/users/' + user.id + '/remove'" class="btn btn-danger">remover</router-link>
      </div>
    </div>
  </div>
</template>

<script>
  import { HttpService } from '../../../services/httpService';
  export default {
    data: function () {
      return {
        user: {}
      }
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