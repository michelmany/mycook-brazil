<template>
  <div class="main-content">
    <div class="page-header">
      <h3>Novo endereço</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
        <li class="breadcrumb-item"><router-link to="/admin/sellers">Vendedores</router-link></li>
        <li class="breadcrumb-item active">Endereço</li>
      </ol>

    </div>
    <div class="row">
      <div class="col-sm-12">

        <div class="card">
          <div class="card-block">
            <div class="row">
              <div class="col-lg-12">
                <form>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label for="formCep" class="col-12 col-md-3 col-form-label">CEP</label>
                                <div class="col-12 col-md-9">
                                    <the-mask class="form-control" id="formCep" placeholder="" 
                                    :mask="'#####-###'"
                                    v-validate="'required'" data-vv-name="cep"
                                    :class="{'form-control': true, 'is-danger': errors.has('cep') }" 
                                    v-model="address.cep" @keyup.native="getcep()" />
                                    <div v-show="errors.has('cep')" class="help is-danger">{{ errors.first('cep') }}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="formEndereco" class="col-12 col-md-3 col-form-label">Endereço</label>
                                <div class="col-12 col-md-9">
                                    <input type="text" class="form-control" id="formEndereco" 
                                    v-validate="'required|max:45'" data-vv-name="endereço"
                                    :class="{'form-control': true, 'is-danger': errors.has('endereço') }"
                                    v-model="address.address">
                                    <div v-show="errors.has('endereço')" class="help is-danger">{{ errors.first('endereço') }}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="formNumero" class="col-12 col-md-3 col-form-label">Número</label>
                                <div class="col-12 col-md-9">
                                    <input type="text" class="form-control" id="formNumero"
                                    v-validate="'required|max:8'" data-vv-name="número"
                                    :class="{'form-control': true, 'is-danger': errors.has('número') }"
                                    v-model="address.number">
                                    <div v-show="errors.has('número')" class="help is-danger">{{ errors.first('número') }}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="formComplemento" class="col-12 col-md-3 col-form-label">Complemento</label>
                                <div class="col-12 col-md-9">
                                    <input type="text" class="form-control" id="formComplemento" v-model="address.complement">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label for="formBairro" class="col-12 col-md-3 col-form-label">Bairro</label>
                                <div class="col-12 col-md-9">
                                    <input type="text" class="form-control" id="formBairro"
                                    v-validate="'required|max:35'" data-vv-name="neighborhood"
                                    :class="{'form-control': true, 'is-danger': errors.has('neighborhood') }" 
                                    v-model="address.neighborhood">
                                    <div v-show="errors.has('neighborhood')" class="help is-danger">{{ errors.first('neighborhood') }}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="formCidade" class="col-12 col-md-3 col-form-label">Cidade</label>
                                <div class="col-12 col-md-9">
                                    <input type="text" class="form-control" id="formCidade"
                                    v-validate="'required|max:35'" data-vv-as="município" data-vv-name="city"
                                    :class="{'form-control': true, 'is-danger': errors.has('city') }" 
                                    v-model="address.city">
                                    <div v-show="errors.has('city')" class="help is-danger">{{ errors.first('city') }}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="formEstado" class="col-12 col-md-3 col-form-label">Estado</label>
                                <div class="col-12 col-md-9">
                                    <input type="text" class="form-control" id="formEstado" 
                                    v-validate="'required|max:2'" data-vv-as="UF" data-vv-name="state"
                                    :class="{'form-control': true, 'is-danger': errors.has('state') }" 
                                    v-model="address.state">
                                    <div v-show="errors.has('state')" class="help is-danger">{{ errors.first('state') }}</div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /row -->
                </form>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-between">
            <div>
              <router-link :to="'/admin/' + user_role + '/' + user_id + '/ver'" class="btn btn-default btn-sm">
                <i class="fa fa-arrow-left"></i> Voltar</router-link>
            </div>
            <div>
                <button type="submit" class="btn btn-success" v-on:click="submitForm($event)">
                    <i class="fa fa-check" aria-hidden="true"></i> Adicionar endereço
                </button>
            </div>
          </div>
        </div> <!-- /card -->

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
      submitForm(evt) {
          evt.preventDefault();
          this.validateBeforeSubmit();
      },
      validateBeforeSubmit() {
          this.$validator.validateAll().then(() => {
              this.save();
          }).catch(() => {
              toastr.warning('Favor conferir os dados cadastrados', 'Atenção');
          });
      },
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