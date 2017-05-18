<template>
  <div class="main-content">
    <div class="page-header">
      <h3>Novo comprador</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
        <li class="breadcrumb-item"><router-link to="/admin">Admin</router-link></li>
        <li class="breadcrumb-item active">Compradores</li>
        <li class="action">
          <router-link :to="'/admin/buyers'" class="btn btn-primary btn-xs">voltar</router-link>
        </li>
      </ol>

    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-block">
            <div class="row">
              <div class="col-lg-12">
                <form @submit.prevent="save()">

                  <div class="form-group row">
                    <label for="formAtivo" class="col-12 col-md-2 col-form-label">Status </label>
                    <input type="checkbox" id="formAtivo" v-model="user.active"/>
                  </div>

                  <div class="form-group row">
                    <label for="formNome" class="col-12 col-md-2 col-form-label">Nome</label>
                    <div class="col-12 col-md-10">
                      <input type="text" class="form-control" id="formNome" placeholder="Seu nome" v-model="user.name">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="formCpf" class="col-12 col-md-2 col-form-label">CPF</label>
                    <div class="col-12 col-md-10">
                      <input type="text" class="form-control" id="formCpf" placeholder="Seu CPF" v-model="user.cpf">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="formEmail" class="col-12 col-md-2 col-form-label">Email</label>
                    <div class="col-12 col-md-10">
                      <input type="text" class="form-control" id="formEmail" placeholder="Seu email" v-model="user.email">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="formSenha" class="col-12 col-md-2 col-form-label">Senha</label>
                    <div class="col-12 col-md-10">
                      <input type="text" class="form-control" id="formSenha" placeholder="Digite uma nova senha" v-model="user.password">
                    </div>
                  </div>

                  <hr>
                  <button type="submit" class="btn btn-success">
                    <i class="fa fa-check" aria-hidden="true"></i> Salvar alterações
                  </button>

                </form>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <router-link :to="'/admin/buyers/'" class="btn btn-default btn-sm">
              <i class="fa fa-arrow-left"></i> Voltar</router-link>
            <router-link :to="'/admin/buyers/' + user.id + '/remove'" class="btn btn-danger btn-sm">
              <i class="fa fa-trash"></i>Excluir</router-link>
          </div>
        </div>
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
      save: function () {
        this.user.role = 'comprador';
        httpService.build('admin/v1/users')
          .create(this.user)
          .then((res) => {
            console.log(res)
            toastr.success('Usuario cadastrado com sucesso!', 'Usuário '+ this.user.name);
            this.$router.push('/admin/buyers/' + res.data.id + '/ver');
          });
      }
    },
    mounted() {
      let active = document.getElementById('formAtivo');
      new Switchery(active, {
        color: '#38A866'
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