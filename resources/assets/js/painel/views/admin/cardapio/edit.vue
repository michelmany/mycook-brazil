<template>
    <div class="main-content">
        <div class="page-header">
            <h4>Detalhes do Produto</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link :to="{name: 'panel.seller.cardapio-list'}">Cardapio</router-link></li>
                <li class="breadcrumb-item active">Detalhes do produto</li>
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
                                        <div class="col-lg-4">
                                            <photo :photo-url="product.photo_full_url"></photo>
                                            <div class="caption mt-3">
                                                <p><small>Envie uma logo ou foto<br>Tamanho ideal: 548x320 pixels</small></p>
                                            </div>
                                        </div>

                                        <div class="col-lg-8 col-xl-6">

                                            <div class="form-group row">
                                                <label for="formNome" class="col-12 col-md-3 col-form-label">Nome</label>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" class="form-control" id="formNome"
                                                    :class="{'form-control': true, 'is-danger': errors.has('name') }"
                                                    v-validate="'required|max:35'" data-vv-name="name" v-model="product.name">
                                                    <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</div>
                                                    <small class="text-muted">Qual o nome do produto?</small>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="formEmail" class="col-12 col-md-3 col-form-label">Descrição</label>
                                                <div class="col-12 col-md-9">
                                                    <textarea v-model="product.desc" class="form-control"
                                                    rows="5" v-validate="'required'" data-vv-as="descrição" data-vv-name="desc"
                                                    :class="{'form-control': true, 'is-danger': errors.has('desc') }"></textarea>
                                                    <div v-show="errors.has('desc')" class="help is-danger">{{ errors.first('desc') }}</div>
                                                    <small class="text-muted">Dê mais detalhes sobre este produto.</small>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="formEmail" class="col-12 col-md-3 col-form-label">Serve</label>
                                                <div class="col-12 col-md-9">
                                                    <input type="number" min="1" max="15" class="form-control"
                                                    v-validate="'max_value:15'" data-vv-name="serve"
                                                    :class="{'form-control': true, 'is-danger': errors.has('serve') }"
                                                    v-model="product.serve" >
                                                    <div v-show="errors.has('serve')" class="help is-danger">{{ errors.first('serve') }}</div>
                                                    <small class="text-muted">Este produto serve quantas pessoas?</small>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="formSenha" class="col-12 col-md-3 col-form-label">Preço (R$)</label>
                                                <div class="col-12 col-md-9">
                                                    <input type="number" class="form-control" id="formSenha"
                                                    v-validate="'required'" data-vv-name="preço"
                                                    :class="{'form-control': true, 'is-danger': errors.has('preço') }"
                                                    v-model="product.price" >
                                                    <div v-show="errors.has('preço')" class="help is-danger">{{ errors.first('preço') }}</div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="product_category_id" class="col-12 col-md-3 col-form-label">Categoria</label>
                                                <div class="col-12 col-md-9">
                                                    <app-category>
                                                        <template slot="all" scope="rows">
                                                            <select id="product_category_id" class="form-control" v-model="product.category_id">
                                                                <option value="" selected>Escolha a categoria referente ao produto</option>
                                                                <option v-for="category in rows.categories" :value="category.id">
                                                                    {{ category.name }}
                                                                </option>
                                                            </select>
                                                        </template>
                                                    </app-category>
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
                            <router-link :to="{name: 'panel.seller.cardapio-list'}" class="btn btn-default btn-sm">
                                <i class="fa fa-arrow-left"></i> Voltar</router-link>
                            </div>
                            <div>
                                <router-link :to="'/seller/cardapio/' + product.id + '/remove'" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>Excluir Produto</router-link>
                                    <button type="submit" class="btn btn-success" v-on:click="submitForm($event)">
                                        <i class="fa fa-check" aria-hidden="true"></i> Atualizar Produto
                                    </button>
                                </div>
                            </div>
                        </div><!-- /card -->

                        <!-- Endereços -->
                        <div class="card">
                            <div class="card-header">
                                <div class="caption">
                                    <h6><i class="fa fa-map-marker" aria-hidden="true"></i> Configurações de quantidade</h6>
                                </div>
                                <div class="actions" v-if="isConfigured">
                                    <router-link :to="'/seller/stock/edit/' + product.id + '/' + product.seller_id + '/'" class="btn btn-warning btn-sm"><i class="fa fa-plus-circle"></i> Editar configurações</router-link>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div v-if="!isConfigured" class="col-md-12">
                                        <p><small>Você ainda não configurou os horários e quantidades para esse produto. <br>Configure agora para que o produto apareça no site: <router-link :to="'/seller/stock/edit/' + product.id + '/' + product.seller_id + '/'" class="btn btn-link">Configurar agora!</router-link></small></p>
                                    </div>
                                    <div class="col-md-6" v-show="isConfigured">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <td>Dia</td>
                                                    <td>Hora Início</td>
                                                    <td>Hora Término</td>
                                                    <td>Quantidade</td>
                                                </tr>
                                                <tr v-for="(extra, index) in product.extras">
                                                    <td>{{ weekdays[index] }}</td>
                                                    <td>{{ extra.start_time}}</td>
                                                    <td>{{ extra.end_time}}</td>
                                                    <td>{{ extra.quantity }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /enderecos -->
                    </div>
                </div><!-- /row -->
            </div><!-- /main-content -->
        </template>

    <script>
        import { HttpService } from '../../../services/httpService';
        let httpService = new HttpService();
        import PhotoProductUpload from '../../../components/PhotoProductUpload';
        // import AvatarUpload from '../../../components/AvatarUpload';

        export default {
            data: function () {
                return {
                    isConfigured: false,
                    weekdays: ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado', 'Domingo'],
                    product: {},
                }
            },
            components: {
              photo: PhotoProductUpload
              // avatar: AvatarUpload
            },
            watch:{
                'product.serve'(current) {
                    if(current > 15) {
                        this.product.serve = 15
                    }
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
                    .update(this.$route.params['id'], this.product)
                    .then((res) => {
                        // console.log(res)
                        toastr.success('Atualizado com sucesso!', 'Produto '+ this.product.name, {
                            onHidden: () => {
                                this.$router.push('/seller/cardapio/');
                            }
                        });

                    })
                    .catch((error) => {
                        toastr.error('Não foi possível enviar seus dados!', 'Erro de servidor');
                    })
                }
            },
            mounted() {
                let httpService = new HttpService();
                httpService.build('admin/v1/products/' + this.$route.params['id'])
                .list()
                .then((res) => {
                    this.product = res.data;
                    if(this.product.extras.length > 0) {
                        this.isConfigured = true
                    }
                    // this.user.buyer = res.data.buyer || {};
                });
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
