<template>
  <div class="main-content">
    <div class="page-header">
      <h3>Edição de usuário</h3>
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
            <h5>Perfil</h5>
            <form @submit.prevent="save()">

              <div class="form-group">
                <label for="formAtivo">Ativo {{ user.active }}</label>
                <input type="checkbox" id="formAtivo" v-model="user.active"/>
              </div>

              <div class="form-group">
                <label class="sr-only" for="formNome">Nome</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                  <div class="input-group-addon">Nome</div>
                  <input type="text" class="form-control" id="formNome" placeholder="Seu nome..." v-model="user.name">
                </div>
              </div>

              <div class="form-group">
                <label class="sr-only" for="formCpf">CPF</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                  <div class="input-group-addon">CPF</div>
                  <input type="text" class="form-control" id="formCpf" placeholder="Seu CPF..." v-model="user.cpf">
                </div>
              </div>

              <div class="form-group">
                <label class="sr-only" for="formEmail">Email</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                  <div class="input-group-addon">Email</div>
                  <input type="text" class="form-control" id="formEmail" placeholder="Seu email..." v-model="user.email">
                </div>
              </div>

              <div class="form-group">
                <label class="sr-only" for="formSenha">Senha</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                  <div class="input-group-addon">Senha</div>
                  <input type="text" class="form-control" id="formSenha" placeholder="Sua senha..." v-model="user.password">
                </div>
              </div>

              <div class="form-group">
                <label class="sr-only" for="formGrupo">Grupo</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                  <div class="input-group-addon">Grupo</div>
                  <select id="formGrupo" class="form-control" v-model="user.role">
                    <option value="admin">Administrador</option>
                    <option value="comprador">Comprador</option>
                    <option value="vendedor">vendedor</option>
                    <option value="user">Usuário</option>
                  </select>
                </div>
              </div>

              <input type="submit" value="salvar" class="btn btn-primary">

            </form>

            <hr>
            <h5>Perfil de vendedor</h5>

            <hr>
            <h5>Perfil de comprador</h5>

          </div>
        </div>
      </div>
      <div class="card-footer">
        <router-link :to="'/admin/users' + user.id + '/ver'" class="btn btn-default">voltar</router-link>
        <router-link :to="'/admin/users/' + user.id + '/remove'" class="btn btn-danger">remover</router-link>
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
        user: {},
      }
    },
    methods: {
      save() {
        let data = this.user;
        delete data.avatar;

        if (!data.password) {
          delete data.password;
        }

        httpService.build('admin/v1/users')
        .update(this.$route.params['id'], this.user)
        .then(() => {
          // TODO: trocar por algo mais interessante
          alert('Salvo com sucesso');
          this.$router.push('/admin/users/' + this.$route.params['id'] + '/ver');
        });
      }
    },
    mounted() {
      let active = document.getElementById('formAtivo');

      let switchery = new Switchery(active, {
        color: '#ffde00'
      });

      httpService.build('admin/v1/users/' + this.$route.params['id'])
      .list()
      .then((res) => {
        this.user = res.data;
        this.user.password = null;
        if (!!res.data.active) {
          switchery.setPosition(true);
          switchery.handleOnchange(true);
        }
      });
    }
  }
</script>