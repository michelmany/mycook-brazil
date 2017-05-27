<template>
    <div>
        <form id="formCadastroVendedor" @submit.prevent="validateBeforeSubmit()" ref="formCadastroVendedor">
            <div class="form-group row">

                <div class="col-lg-5">
                    <input type="text" name="user[name]" v-model="user.name" placeholder="Nome completo"
                    v-validate="'required'" data-vv-as="NOME COMPLETO"
                    :class="{'form-control': true, 'is-danger': errors.has('user[name]') }"
                    class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('user[name]')" class="help is-danger">{{ errors.first('user[name]') }}</div>
                </div>

                <div class="col-lg-3">
                    <input  type="number" name="user[cpf]" v-model="user.cpf" placeholder="CPF" 
                            v-validate="'required|cpf|digits:11'" data-vv-as="CPF" 
                            :class="{'form-control': true, 'is-danger': errors.has('user[cpf]') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('user[cpf]')" class="help is-danger">{{ errors.first('user[cpf]') }}</div>
                </div>

                <div class="col-lg-4">
                    <input type="email" name="user[email]" v-model="user.email" placeholder="Email" 
                            v-validate="'required|email'" data-vv-as="EMAIL" 
                            :class="{'form-control': true, 'is-danger': errors.has('user[email]') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('user[email]')" class="help is-danger">{{ errors.first('user[email]') }}</div>
                </div>

            </div>
            <div class="form-group row">

                <div class="col-lg-3">
                    <input  id="cep_field" type="number" v-model="address.cep" placeholder="CEP"
                            v-validate="'required|digits:8'" data-vv-as="CEP" data-vv-name="cep"
                            :class="{'form-control': true, 'is-danger': errors.has('cep') }" 
                            class="form-control form-control-lg input__entrar" @keyup="getcep()">
                    <div v-show="errors.has('cep')" class="help is-danger">{{ errors.first('cep') }}</div>
                </div>

                <div class="col-lg-6">
                    <input  id="address_field" type="text" v-model="address.address" placeholder="Endereço" 
                            v-validate="'required'" data-vv-as="ENDEREÇO" data-vv-name="fulladdress"
                            :class="{'form-control': true, 'is-danger': errors.has('fulladdress') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('fulladdress')" class="help is-danger">{{ errors.first('fulladdress') }}</div>
                </div>

                <div class="col-lg-3">
                    <input type="text" v-model="address.number" placeholder="Número" 
                            v-validate="'required'" data-vv-as="NÚMERO" data-vv-name="number"
                            :class="{'form-control': true, 'is-danger': errors.has('number') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('number')" class="help is-danger">{{ errors.first('number') }}</div>
                </div>

            </div>

            <div class="form-group row">

            <div class="col-lg-4">
                <input type="text"  v-model="address.complement" placeholder="Complemento" 
                     class="form-control form-control-lg input__entrar">
            </div>

                <div class="col-lg-3">
                    <input id="neighborhood_field" type="text" v-model="address.neighborhood" placeholder="Bairro" 
                            v-validate="'required'" data-vv-as="BAIRRO" data-vv-name="neighborhood"
                            :class="{'form-control': true, 'is-danger': errors.has('neighborhood') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('neighborhood')" class="help is-danger">{{ errors.first('neighborhood') }}</div>
                </div>

                <div class="col-lg-3">
                    <input id="city_field" type="text"  v-model="address.city" placeholder="Município" 
                            v-validate="'required'" data-vv-as="MUNICÍPIO" data-vv-name="city"
                            :class="{'form-control': true, 'is-danger': errors.has('city') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('city')" class="help is-danger">{{ errors.first('city') }}</div>
                </div>

                <div class="col-lg-2">
                    <input id="state_field" type="text"  v-model="address.state" placeholder="UF" 
                            v-validate="'required'" data-vv-as="UF" data-vv-name="state"
                            :class="{'form-control': true, 'is-danger': errors.has('state') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('state')" class="help is-danger">{{ errors.first('state') }}</div>
                </div>

            </div>
            <div class="form-group row">

                <div class="col-lg-3">
                    <input type="text" v-model="user.seller.phone" placeholder="Telefone Fixo" 
                            v-validate="'required'" data-vv-as="TELEFONE FIXO" data-vv-name="phone"
                            :class="{'form-control': true, 'is-danger': errors.has('phone') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('phone')" class="help is-danger">{{ errors.first('phone') }}</div>

                </div>

                <div class="col-lg-3">

                    <input type="text" v-model="user.seller.phone2" placeholder="Telefone Celular" 
                            v-validate="'required'" data-vv-as="TELEFONE CELULAR" data-vv-name="phone2"
                            :class="{'form-control': true, 'is-danger': errors.has('phone2') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('phone2')" class="help is-danger">{{ errors.first('phone2') }}</div>

                </div>

                <div class="col-lg-3">
                    <input  type="text" v-model="user.seller.facebook" placeholder="Facebook" 
                            class="form-control form-control-lg input__entrar">
                </div>

                <div class="col-lg-3">
                    <input  type="text" v-model="user.seller.instagram" placeholder="Instagram"
                            class="form-control form-control-lg input__entrar">
                </div>

            </div>

            <div class="form-group row">
                <div class="col-lg-5">
                    <textarea v-model="user.seller.dishes" class="form-control form-control-lg input__entrar input__entrar--textarea"
                        placeholder="Quais pratos deseja vender no mycook?" rows="6" v-validate="'required'" data-vv-as="QUAIS PRATOS..." data-vv-name="dishes"
                        :class="{'form-control': true, 'is-danger': errors.has('dishes') }"></textarea>
                        <div v-show="errors.has('dishes')" class="help is-danger">{{ errors.first('dishes') }}</div>
                </div>

                <div class="col-lg-3 mt-3">
                    <label class="form-chef__label">Você cozinha?</label>
                    <p><small>Caso faça ambos, selecione as duas caixas</small></p>
                    .
                    <div class="form-check mb-2 mr-sm-2 mb-sm-0">
                       <label class="form-check-label">
                         <input class="form-check-input" type="checkbox" name="type_delivery" 
                         v-model="user.seller.type_delivery" v-validate="'required'" data-vv-name="type_delivery"
                         value="Pronta entrega"> Pronta entrega
                       </label>
                     </div>
                    <div class="form-check mb-2 mr-sm-2 mb-sm-0">
                       <label class="form-check-label">
                         <input class="form-check-input" type="checkbox" name="type_delivery" 
                            v-model="user.seller.type_delivery" value="Sob encomenda"> Sob encomenda
                       </label>
                     </div>
                     <div v-show="errors.has('type_delivery')" class="help is-danger">Selecione no mínimo uma opção.</div>

                </div>

                <div class="col-lg-4 mt-3">
                    <label class="form-chef__label">Por favor envie três fotos do ambiente de trabalho e + três fotos dos produtos que você pretende vender.</label>
    <!--                     <span class="btn btn-file-blue btn-file" style="cursor: pointer">
                        Selecionar imagens...<input type="file" name="images[estabelecimento][]" multiple 
                        v-validate="'required|ext:jpg,png'" @change="selectedFile($event)">
                    </span> -->
                    <!-- <p><small>Apenas imagens (JPG, PNG).</small></p> -->
                    <div v-show="errors.has('images[estabelecimento][]')" class="help is-danger">Selecione imagens JPG ou PNG.</div>
                </div>
            </div>
            <div class="form-check text-center mb-3">
                <label class="form-check-label">
                    <input class="form-check-input" v-validate="'required'" type="checkbox" name="termos" checked>
                </label>
                <span class="form-chef__concordo" data-toggle="modal" data-target="#modalTermos">Concordo com os termos de contrato.</span>
                <div v-show="errors.has('termos')" class="help is-danger">É necessário concordar com os termos de contrato.</div>
            </div>
            <div class="submit-button text-center mt-3">
                <button type="submit" class="btn btn-submit-orange btn-lg">Cadastrar</button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modalTermos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">TERMOS E CONDICOES DE USO MyCook</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Ao se cadastrar no MyCook, você <strong>ESTÁ DE ACORDO COM OS TERMOS E CONDIÇÕES</strong> da plataforma. Note que a recusa destes Termos, você ficara impedido de solicitar pedidos, quanto para se candidatar como fornecedor na plataforma. </p>
                            <h6>SERVIÇOS OFERECIDOS</h6>

                        </div>
                    </div>
                </div>
            </div>
       </form>   

        <div v-show="loading" class="preloader">
            <div class="preloader__box">
                <div>
                    <i class="fa fa-spinner fa-spin mb-3"></i>
                    <div class="preloader__copy">Olá <strong>{{user.name}}</strong>,<br> estamos enviando seu cadastro...</div>
                </div>
            </div>
        </div>
        <div id="salvoCadastroVendedor" class="form-chef__thank-you form_seller_hidden" ref="salvoCadastroVendedor">
            <div class="thank-you__headline">Obrigado!</div>
            <div class="thank-you__subline">Seus dados foram enviados com sucesso!</div>
            <div class="thank-you__copy">Você receberá uma confirmação em seu email cadastrado!</div>
        </div>

    </div>
</template>

<script>
    import { HttpService } from '../services/httpService';
    let httpService = new HttpService();

    export default {
        data: function () {
            return {
                loading: false,
                address: {
                    cep: '',
                    address: '',
                    number: '',
                    complement: '',
                    neighborhood: '',
                    city: '',
                    state: ''
                },
                user: {
                    seller: {
                        type_delivery: []
                    }
                }
            }
        },
        methods: {
            validateBeforeSubmit() {
                this.$validator.validateAll().then(() => {
                    // this.$refs.preloader.className = "form_seller_show";
                    this.loading = true;
                    this.save();
                }).catch(() => {
                    // alert('Correct them errors!');
                });
            },
            save: function () {
                this.user.role = 'vendedor';
                this.user.active = 0;
                httpService.build('admin/v1/users')
                .create(this.user)
                .then((res) => {
                    this.loading = false;
                    this.$refs.formCadastroVendedor.className = "form_seller_hidden";
                    this.$refs.salvoCadastroVendedor.className = "form-chef__thank-you form_seller_show";
                    // this.$refs.preloader.className = "form_seller_hidden";
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
        }
    }
</script>

<style>
    .help.is-danger {
        color: red;
        margin-top: 5px;
        font-size: 12px;
    }
    .form-control.is-danger {
        border: 1px solid red;
    }
</style>
