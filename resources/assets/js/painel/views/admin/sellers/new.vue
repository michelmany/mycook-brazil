<template>
  <div class="main-content">
    <div class="page-header">
      <h3>Novo vendedor</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
        <li class="breadcrumb-item active">Vendedores</li>
        <li class="action">
          <router-link :to="'/admin/sellers'" class="btn btn-primary btn-xs">voltar</router-link>
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

                  <div class="form-group row">
                    <label for="formPhone" class="col-12 col-md-3 col-form-label">Telefone</label>
                    <div class="col-12 col-md-9">
                      <input type="text" class="form-control" id="formPhone" placeholder="Digite telefone comercial" v-model="user.seller.phone">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="formPhone2" class="col-12 col-md-3 col-form-label">Telefone Celular</label>
                    <div class="col-12 col-md-9">
                      <input type="text" class="form-control" id="formPhone2" placeholder="Digite outro telefone comercial" v-model="user.seller.phone2">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="formFacebook" class="col-12 col-md-3 col-form-label">Facebook</label>
                    <div class="col-12 col-md-9">
                      <input type="text" class="form-control" id="formFacebook" placeholder="URL da página no Faceook" v-model="user.seller.facebook">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="formInstagram" class="col-12 col-md-3 col-form-label">Instagram</label>
                    <div class="col-12 col-md-9">
                      <input type="text" class="form-control" id="formInstagram" placeholder="URL da página no Instagram" v-model="user.seller.instagram">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-12 col-md-3 col-form-label">Tipo de entrega</label>
                    <div class="col-12 col-md-9">
                      <input type="checkbox" name="type_delivery" v-model="user.seller.type_delivery" value="Sob encomenda">Sob encomenda<br>
                      <input type="checkbox" name="type_delivery" v-model="user.seller.type_delivery" value="Pronta entrega">Pronta entrega
                    </div>
                  </div>

<!--                   <div class="form-group row">
                    <label for="formDistanceDelivery" class="col-12 col-md-3 col-form-label">Distância máxima de entrega</label>
                    <div class="col-12 col-md-9">
                      <input type="text" class="form-control" id="formDistanceDelivery" placeholder="Distancia em kilometros máxima de entrega" v-model="user.seller.distance_delivery" required>
                    </div>
                  </div> -->

<!--                   <div class="form-group row">
                    <label for="formQuantityPlates" class="col-12 col-md-3 col-form-label">Quantidade de pratos</label>
                    <div class="col-12 col-md-9">
                      <input type="text" class="form-control" id="formQuantityPlates" placeholder="Quantidade máxima de entrega de pratos em uma hora" v-model="user.seller.plates_quantity" required>
                    </div>
                  </div> -->

                  <hr>
                  <button type="submit" class="btn btn-success">
                    <i class="fa fa-check" aria-hidden="true"></i> Salvar alterações
                  </button>

                </form>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <router-link :to="'/admin/sellers/'" class="btn btn-default btn-sm">
              <i class="fa fa-arrow-left"></i> Voltar</router-link>
            <router-link :to="'/admin/sellers/' + user.id + '/remove'" class="btn btn-danger btn-sm">
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
        user: {
          seller: {}
        }
      }
    },
    methods: {
      save: function () {
        this.user.role = 'vendedor';
        httpService.build('admin/v1/users')
          .create(this.user)
          .then((res) => {
            toastr.success('Usuario cadastrado com sucesso!', 'Usuário '+ this.user.name);
            this.$router.push('/admin/sellers/' + res.data.id + '/ver');
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