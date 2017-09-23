<template>
    <div class="main-content">
        <div class="page-header">
            <h4>Adicionar Produto</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link to="/admin/cardapio">Cardapio</router-link></li>
                <li class="breadcrumb-item active">Adicionar produto</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="formNewSeller">

                                    <div class="row">
                                        <div class="col-lg-6">

                                            <div class="form-group row">
                                                <label for="product_name" class="col-12 col-md-3 col-form-label">Nome</label>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" class="form-control" id="product_name"
                                                    :class="{'form-control': true, 'is-danger': errors.has('name') }"
                                                    v-validate="'required|max:35'" data-vv-name="name" v-model.trim="product.name">
                                                    <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</div>
                                                    <small class="text-muted">Qual o nome do produto?</small>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="product_desc" class="col-12 col-md-3 col-form-label">Descrição</label>
                                                <div class="col-12 col-md-9">
                                                    <textarea v-model.trim="product.desc" id="product_desc" class="form-control"
                                                        rows="5" v-validate="'required'" data-vv-as="descrição" data-vv-name="desc"
                                                        :class="{'form-control': true, 'is-danger': errors.has('desc') }"></textarea>
                                                    <div v-show="errors.has('desc')" class="help is-danger">{{ errors.first('desc') }}</div>
                                                    <small class="text-muted">Dê mais detalhes sobre este produto.</small>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                              <label for="product_comments" class="col-12 col-md-3 col-form-label">Observações</label>
                                              <div class="col-12 col-md-9">
                                                  <textarea v-model="product.comments" id="product_comments" class="form-control" rows="5"></textarea>
                                                  <small class="text-muted">Observações sobre o produto.</small>
                                              </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-6">

                                        <div class="form-group row">
                                            <label for="serve" class="col-12 col-md-3 col-form-label">Serve</label>
                                            <div class="col-12 col-md-9">
                                                <input type="number" id="serve" class="form-control"
                                                :class="{'form-control': true, 'is-danger': errors.has('serve') }"
                                                v-model.number="product.serve">
                                                <div v-show="errors.has('serve')" class="help is-danger">{{ errors.first('serve') }}</div>
                                                <small class="text-muted">Este produto serve quantas pessoas?</small>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="product_number" class="col-12 col-md-3 col-form-label">Preço (R$)</label>
                                            <div class="col-12 col-md-9">
                                                <input type="number" class="form-control" id="product_number"
                                                v-validate="'required'" data-vv-name="preço"
                                                :class="{'form-control': true, 'is-danger': errors.has('preço') }"
                                                v-model.trim="product.price" >
                                                <div v-show="errors.has('preço')" class="help is-danger">{{ errors.first('preço') }}</div>
                                            </div>
                                        </div>

                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div><!-- /row -->
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div class="mt-1">
                            <router-link :to="'/admin/sellers/'" class="btn btn-default btn-sm">
                                <i class="fa fa-arrow-left"></i> Voltar</router-link>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success" v-on:click="submitForm($event)">
                                <i class="fa fa-check" aria-hidden="true"></i> Salvar Produto
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /row -->
    </div><!-- /main-content -->
</template>

    <script>
        import Ls from '../../../services/ls'
        import { HttpService } from '../../../services/httpService';
        let httpService = new HttpService();

        export default {
            data: function () {
                return {
                    user: {},
                    product: {},
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
                        toastr.warning('Favor preencher os campos obrigatórios', 'Atenção');
                    });
                },
                save: function () {

                    httpService.build('admin/v1/products')
                    .create(this.product)
                    .then((res) => {
                        console.log(res)
                        toastr.success('Cadastrado com sucesso!', 'Produto '+ this.product.name);
                        this.$router.push('/admin/cardapio/');
                    })
                    .catch((error) => {
                        toastr.error('Não foi possível enviar seus dados!', 'Erro de servidor');
                    })
                },
                setUser() {
                    let user = Ls.get('auth.user');

                    if (user !== null) {
                      this.user = JSON.parse(user);
                      this.product.seller_id = this.user.seller.id;
                    }
                }
            },
            mounted() {
                this.setUser()
            }
        }
    </script>

    <style>
        .breadcrumb .action {
            float: left;
            padding-left: 10px;
        }

        .help.is-danger {
            color: red;
            margin-top: 5px;
            font-size: 12px;
        }
        .form-control.is-danger {
            border: 1px solid red;
        }

    </style>
