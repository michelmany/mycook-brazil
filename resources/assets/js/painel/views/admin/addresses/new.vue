<template>
  <div class="main-content">
    <div class="page-header">
      <h3>Novo endereço</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
        <li class="breadcrumb-item"><router-link to="/admin">Admin</router-link></li>
        <li class="breadcrumb-item active">Endereço</li>
        <li class="action">
          <router-link :to="'/admin/' + user_role + '/' + user_id + '/ver'" class="btn btn-primary btn-xs">voltar</router-link>
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
                    <label for="formCep" class="col-12 col-md-2 col-form-label">CEP</label>
                    <div class="col-12 col-md-10">
                      <input type="text" class="form-control" id="formCep" placeholder="Seu CEP..." v-model="address.cep" @keyup="getcep()">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="formEndereco" class="col-12 col-md-2 col-form-label">Endereço</label>
                    <div class="col-12 col-md-10">
                      <input type="text" class="form-control" id="formEndereco" placeholder="Seu Endereço..." v-model="address.address">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="formNumero" class="col-12 col-md-2 col-form-label">Número</label>
                    <div class="col-12 col-md-10">
                      <input type="text" class="form-control" id="formNumero" placeholder="Seu número..." v-model="address.number">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="formComplemento" class="col-12 col-md-2 col-form-label">Complemento</label>
                    <div class="col-12 col-md-10">
                      <input type="text" class="form-control" id="formComplemento" placeholder="Complemento..." v-model="address.complement">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="formBairro" class="col-12 col-md-2 col-form-label">Bairro</label>
                    <div class="col-12 col-md-10">
                      <input type="text" class="form-control" id="formBairro" placeholder="Seu Bairro..." v-model="address.neighborhood">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="formCidade" class="col-12 col-md-2 col-form-label">Cidade</label>
                    <div class="col-12 col-md-10">
                      <input type="text" class="form-control" id="formCidade" placeholder="Seu cidade..." v-model="address.city">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="formEstado" class="col-12 col-md-2 col-form-label">Estado</label>
                    <div class="col-12 col-md-10">
                      <input type="text" class="form-control" id="formEstado" placeholder="Seu estado..." v-model="address.state">
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
            <router-link :to="'/admin/' + user_role + '/' + user_id + '/ver'" class="btn btn-default btn-sm">
              <i class="fa fa-arrow-left"></i> Voltar</router-link>
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
        address: {
          cep: '',
          address: '',
          number: '',
          complement: '',
          neighborhood: '',
          city: '',
          state: ''
        },
      }
    },
    computed: {
      user_role: function () {
        switch (this.$route.params.user_role) {
          case 'vendedor':
            return 'sellers';
          case 'comprador':
            return 'buyers';
          default :
            return 'users';
        }
      },
      user_id: function () {
        return this.$route.params.user_id
      },
    },
    methods: {
      save: function () {
        this.address.user_id = this.user_id;
        httpService.build('admin/v1/address')
          .create(this.address)
          .then((res) => {
            toastr.success('Endereço incluido com sucesso!', 'Sucesso');
            this.$router.push('/admin/' + this.user_role + '/' + this.user_id + '/ver');
          });
      },
      getcep: function () {
        if (this.address.cep.length === 8) {
          httpService.xmlHttpRequest('https://viacep.com.br/ws/' + this.address.cep + '/json/').then((res) => {
            let cep = JSON.parse(res);
            this.address.address = cep.logradouro;
            this.address.neighborhood = cep.bairro;
            this.address.city = cep.localidade;
            this.address.state = cep.uf;
          })
        }
      }
    },
  }
</script>

<style>
  .breadcrumb .action {
    float: left;
    padding-left: 10px;
  }
</style>