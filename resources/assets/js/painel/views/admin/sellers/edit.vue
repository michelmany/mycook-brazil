<template>
    <div class="main-content">
        <div class="page-header">
            <h3>Editar vendedor</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
              <li class="breadcrumb-item"><router-link to="/admin/sellers">Vendedores</router-link></li>
              <li class="breadcrumb-item active">Editar </li>
            </ol>
        </div>
        <div class="card">
            <div class="card-block">
                <div class="row">

                    <div class="col-lg-12">
                        <form id="formNewSeller">

                            <div class="form-group row">
                                <label for="formAtivo" class="col-12 col-md-3 col-lg-2 col-form-label">Status </label>
                                <div class="col-12 col-md-9 col-lg-10">
                                    <input type="checkbox" id="formAtivo" v-model="user.active"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="form-group row">
                                        <label for="formNome" class="col-12 col-md-3 col-form-label">Nome</label>
                                        <div class="col-12 col-md-9">
                                            <input type="text" class="form-control" id="formNome" 
                                            :class="{'form-control': true, 'is-danger': errors.has('name') }"
                                            v-validate="'required|max:35'" data-vv-name="name" v-model="user.name">
                                            <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="formCpf" class="col-12 col-md-3 col-form-label">CPF</label>
                                        <div class="col-12 col-md-9">
                                            <the-mask v-model="user.cpf" id="formCpf" placeholder="" 
                                            :mask="'###.###.###-##'"
                                            v-validate="'required|cpf|digits:11'" data-vv-as="CPF" data-vv-name="cpf"
                                            :class="{'form-control': true, 'is-danger': errors.has('cpf') }" 
                                            class="form-control"/>
                                            <div v-show="errors.has('cpf')" class="help is-danger">{{ errors.first('cpf') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="formEmail" class="col-12 col-md-3 col-form-label">Email</label>
                                        <div class="col-12 col-md-9">
                                            <input type="email" class="form-control" id="formEmail" 
                                            v-validate="'required|email|max:35'" data-vv-name="email"
                                            :class="{'form-control': true, 'is-danger': errors.has('email') }" 
                                            v-model="user.email">
                                            <div v-show="errors.has('email')" class="help is-danger">{{ errors.first('email') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="formSenha" class="col-12 col-md-3 col-form-label">Senha</label>
                                        <div class="col-12 col-md-9">
                                            <input type="text" class="form-control" id="formSenha" 
                                            v-validate="'min:4|max:8'" data-vv-name="senha"
                                            :class="{'form-control': true, 'is-danger': errors.has('senha') }"
                                            placeholder="Digite uma nova senha" 
                                            v-model="user.password" >
                                            <div v-show="errors.has('senha')" class="help is-danger">{{ errors.first('senha') }}</div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group row">
                                        <label for="formPhone" class="col-12 col-md-3 col-form-label">Telefone</label>
                                        <div class="col-12 col-md-9">
                                            <the-mask type="text" class="form-control" id="formPhone" 
                                            :mask="['(##) ####-####', '(##) #####-####']"
                                            data-vv-name="telefone"
                                            :class="{'form-control': true, 'is-danger': errors.has('telefone') }" 
                                            v-model="user.seller.phone"/>
                                            <div v-show="errors.has('telefone')" class="help is-danger">{{ errors.first('telefone') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="formPhone2" class="col-12 col-md-3 col-form-label">Celular</label>
                                        <div class="col-12 col-md-9">
                                            <the-mask type="text" class="form-control" id="formPhone2" 
                                            :mask="['(##) ####-####', '(##) #####-####']"
                                            v-validate="'required'" data-vv-name="celular"
                                            :class="{'form-control': true, 'is-danger': errors.has('celular') }" 
                                            v-model="user.seller.phone2"/>
                                            <div v-show="errors.has('celular')" class="help is-danger">{{ errors.first('celular') }}</div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="formFacebook" class="col-12 col-md-3 col-form-label">Facebook</label>
                                        <div class="col-12 col-md-9">
                                            <input type="text" class="form-control" id="formFacebook" placeholder="Ex. @mycook" 
                                            v-validate="'max:35'" data-vv-name="facebook"
                                            v-model="user.seller.facebook">
                                            <div v-show="errors.has('facebook')" class="help is-danger">{{ errors.first('facebook') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="formInstagram" class="col-12 col-md-3 col-form-label">Instagram</label>
                                        <div class="col-12 col-md-9">
                                            <input type="text" class="form-control" id="formInstagram" placeholder="Ex. @mycook" 
                                            v-validate="'max:35'" data-vv-name="instagram"
                                            v-model="user.seller.instagram">
                                            <div v-show="errors.has('instagram')" class="help is-danger">{{ errors.first('instagram') }}</div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-md-2 col-form-label">Tipo de entrega:</label>
                                <div class="col-12 col-md-8 col-form-label">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="type_delivery" 
                                            v-validate="'required'"
                                            v-model="user.seller.type_delivery" value="Sob encomenda"> Sob encomenda
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="type_delivery" 
                                            v-model="user.seller.type_delivery" value="Pronta entrega"> Pronta entrega
                                        </label>
                                    </div>
                                    <div v-show="errors.has('type_delivery')" class="help is-danger">Selecione no mínimo uma opção.</div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <div>
                    <router-link :to="'/admin/sellers/' + user.id + '/ver'" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Voltar</router-link>
                    <router-link :to="'/admin/sellers/' + user.id + '/remove'" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i>Excluir</router-link>
                </div>
                <div>
                    <button type="submit" class="btn btn-success" v-on:click="submitForm($event)">
                        <i class="fa fa-check" aria-hidden="true"></i> Salvar alterações
                    </button>
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
                },
            }
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
            save() {
                let data = this.user;
                delete data.avatar;

                if (!data.password) {
                    delete data.password;
                }

                httpService.build('admin/v1/users')
                .update(this.$route.params['id'], data)
                .then(() => {
                    toastr.success('Editado com sucesso!', 'Usuário '+ this.user.name);
                    this.$router.push('/admin/sellers/' + this.$route.params['id'] + '/ver');
                })
                .catch((error) => {
                    toastr.error('Não foi possível editar seus dados!', 'Erro de servidor');
                });
            }
        },
        mounted() {
          let active = document.getElementById('formAtivo');

          let switchery = new Switchery(active, {
              color: '#38A866'
          });

          switchery.element.addEventListener('change', () => {
            this.user.active = active.checked;
          });

          httpService.build('admin/v1/users/' + this.$route.params['id'])
          .list()
          .then((res) => {
              this.user = res.data[1];
              this.user.password = null;
              this.user.seller = res.data.seller || {type_delivery: []};
              if (!!res.data.active) {
                  switchery.setPosition(true);
                  switchery.handleOnchange(true);
              }
          });
        }
    }
</script>