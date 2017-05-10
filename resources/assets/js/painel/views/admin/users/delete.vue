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
          <div class="col-md-2"><img :src="user.avatar + '?s=200'" class="img-responsive" v-if="user.avatar"></div>
          <div class="col-md-10">

            <h5>Tem certeza que quer remover?</h5>
            <a href="" class="btn btn-success btn-lg" @click.prevent="remove()">SIM</a> <router-link :to="'/admin/users/' + user.id + '/ver'" class="btn btn-danger btn-lg">NÃO</router-link>

            <hr>

            <p><mark>{{ user.name }} <small>{{ user.email }}</small></mark></p>
            <p>Tipo de usuário: {{ user.role }}</p>
            <p>Conta ativa?: {{ user.active ? 'sim' : 'não' }}</p>
            <p>CPF: {{ user.cpf }}</p>

          </div>
        </div>
      </div>
      <div class="card-footer">
        <router-link :to="'/admin/users/' + user.id + '/ver'" class="btn btn-default">voltar</router-link>
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
          // TODO: trocar por algo mais interessante
          alert('removido com sucesso');
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