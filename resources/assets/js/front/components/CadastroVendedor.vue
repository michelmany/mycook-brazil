<template>
    <div>
        <form id="formCadastroVendedor" @submit.prevent="validateBeforeSubmit()" ref="formCadastroVendedor">
            <div class="form-group row">

                <div class="col-lg-5">
                    <input type="text" name="name" v-model="user.name" placeholder="Nome completo"
                    v-validate="'required|max:35'" data-vv-as="nome completo"
                    :class="{'form-control': true, 'is-danger': errors.has('name') }"
                    class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</div>
                </div>

                <div class="col-lg-3">
                    <the-mask v-model="user.cpf" placeholder="CPF" 
                            :mask="'###.###.###-##'"
                            v-validate="'required|cpf|digits:11'" data-vv-as="CPF" data-vv-name="cpf"
                            :class="{'form-control': true, 'is-danger': errors.has('cpf') }"
                            id="cpfField"
                            class="form-control form-control-lg input__entrar"></the-mask>
                    <div v-show="errors.has('cpf')" class="help is-danger">{{ errors.first('cpf') }}</div>
                </div>

                <div class="col-lg-4">
                    <input type="email" v-model="user.email" placeholder="Email" 
                            v-validate="'required|email|max:35'" data-vv-name="email"
                            :class="{'form-control': true, 'is-danger': errors.has('email') }"
                            class="form-control form-control-lg input__entrar"
                            @blur="checkEmail(user.email)">
                    <div v-show="errors.has('email')" class="help is-danger">{{ errors.first('email') }}</div>
                </div>

            </div>
            <div class="form-group row">

                <div class="col-lg-3">

                    <the-mask id="cep_field" v-model="address.cep" placeholder="CEP"
                            :mask="'#####-###'" 
                            v-validate="'required'" data-vv-name="cep"
                            :class="{'form-control': true, 'is-danger': errors.has('cep') }" 
                            class="form-control form-control-lg input__entrar" @keyup.native="getcep()"/>
                    <div v-show="errors.has('cep')" class="help is-danger">{{ errors.first('cep') }}</div>
                </div>

                <div class="col-lg-6">
                    <input  id="address_field" type="text" v-model="address.address" placeholder="Endereço" 
                            v-validate="'required|max:45'" data-vv-name="endereço"
                            :class="{'form-control': true, 'is-danger': errors.has('endereço') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('endereço')" class="help is-danger">{{ errors.first('endereço') }}</div>
                </div>

                <div class="col-lg-3">
                    <input type="text" v-model="address.number" placeholder="Número" 
                            v-validate="'required|max:8'" data-vv-as="número" data-vv-name="número"
                            :class="{'form-control': true, 'is-danger': errors.has('número') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('número')" class="help is-danger">{{ errors.first('número') }}</div>
                </div>

            </div>

            <div class="form-group row">

            <div class="col-lg-4">
                <input type="text"  v-model="address.complement" placeholder="Complemento" 
                     class="form-control form-control-lg input__entrar">
            </div>

                <div class="col-lg-3">
                    <input id="neighborhood_field" type="text" v-model="address.neighborhood" placeholder="Bairro" 
                            v-validate="'required|max:35'" data-vv-as="bairro" data-vv-name="neighborhood"
                            :class="{'form-control': true, 'is-danger': errors.has('neighborhood') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('neighborhood')" class="help is-danger">{{ errors.first('neighborhood') }}</div>
                </div>

                <div class="col-lg-3">
                    <input id="city_field" type="text"  v-model="address.city" placeholder="Município" 
                            v-validate="'required|max:35'" data-vv-as="município" data-vv-name="city"
                            :class="{'form-control': true, 'is-danger': errors.has('city') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('city')" class="help is-danger">{{ errors.first('city') }}</div>
                </div>

                <div class="col-lg-2">
                    <input id="state_field" type="text"  v-model="address.state" placeholder="UF" 
                            v-validate="'required|max:2'" data-vv-as="UF" data-vv-name="state"
                            :class="{'form-control': true, 'is-danger': errors.has('state') }" 
                            class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('state')" class="help is-danger">{{ errors.first('state') }}</div>
                </div>

            </div>
            <div class="form-group row">

                <div class="col-lg-3">
                    <the-mask v-model="user.seller.phone" placeholder="Telefone Fixo"
                            :mask="['(##) ####-####', '(##) #####-####']" 
                            v-validate="'min:10'" data-vv-as="telefone fixo" data-vv-name="phone"
                            :class="{'form-control': true, 'is-danger': errors.has('phone') }"
                            class="form-control form-control-lg input__entrar"/>
                    <div v-show="errors.has('phone')" class="help is-danger">{{ errors.first('phone') }}</div>
                </div>


                <div class="col-lg-3">
                    <the-mask v-model="user.seller.phone2" placeholder="Telefone Celular" 
                            :mask="['(##) ####-####', '(##) #####-####']" 
                            v-validate="'required|min:10'" data-vv-as="telefone celular" data-vv-name="phone2"
                            :class="{'form-control': true, 'is-danger': errors.has('phone2') }" 
                            class="form-control form-control-lg input__entrar"/>
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
                        placeholder="Quais pratos deseja vender no mycook?" rows="6" v-validate="'required'" data-vv-as="quais pratos..." data-vv-name="dishes"
                        :class="{'form-control': true, 'is-danger': errors.has('dishes') }"></textarea>
                        <div v-show="errors.has('dishes')" class="help is-danger">{{ errors.first('dishes') }}</div>
                </div>

                <div class="col-lg-3 mt-3">
                    <label class="form-chef__label">Você cozinha?</label>
                    <p><small>Caso faça ambos, selecione as duas caixas</small></p>
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
<!--                     <div v-show="errors.has('images[estabelecimento][]')" class="help is-danger">Selecione imagens JPG ou PNG.</div> -->

                    <span class="btn btn-file-blue btn-file" style="cursor: pointer" data-toggle="modal" data-target="#modalImages">Selecionar imagens...</span><br>
                    <span v-if="this.dropFilesLength > 0"><small>Fotos selecionadas: {{this.dropFilesLength}}</small></span>
 
                    <!-- Modal Images -->
                    <div class="modal fade" id="modalImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color:#F95700">
                                    <h5 class="modal-title" style="color:#fff" id="exampleModalLabel">Envie fotos do ambiente de trabalho e dos produtos.</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <dropzone id="myVueDropzone" ref="myVueDropzone" url="/api/quero-vender-fotos"
                                    v-on:vdropzone-success="dropShowSuccess"
                                    v-on:vdropzone-error="dropShowError"
                                    v-on:vdropzone-files-added="dropFilesAdded"
                                    v-on:vdropzone-removed-file="dropFilesRemoved"
                                    v-on:vdropzone-sending="dropSending"
                                    :useCustomDropzoneOptions="true"
                                    :dropzoneOptions="dropOptions">
                                        <!-- Optional parameters if any! -->
                                        <input type="hidden" name="token" :value="dropOptions.token" >
                                    </dropzone>
                                </div>
                                <div class="modal-footer">
                                    <span v-show="showErrorMessage" class="badge badge-pill badge-danger">{{ this.dropErrorMessage }}</span>
                                    <button v-show="!showErrorMessage" type="button" class="btn btn-file-blue" data-dismiss="modal">Já selecionei!</button>
                                </div>

                            </div>
                        </div>
                    </div>


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

       </form>   

        <!-- modal errors -->
       <div v-show="modalErrors" class="preloader" @click="modalErrors = false">
           <div class="preloader__box" style="background-color: #fd9e42;">
               <div>
                   <i class="fa fa-exclamation-triangle mb-3" aria-hidden="true" style="color: #fff;"></i>
                   <div class="preloader__copy" v-if="user.name" style="color: #fff;">Olá <strong>{{ user.name }}</strong>,<br> confira seus dados preenchidos!</div>
                   <div class="preloader__copy" v-else style="color: #fff;">Por favor confira seus dados preenchidos!</div>
               </div>
           </div>
       </div>

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
    import TheMask from 'vue-the-mask'
    import { HttpService } from '../services/httpService'
    import Dropzone from 'vue2-dropzone'

    let httpService = new HttpService();

    export default {
        data: function () {
            return {
                loading: false,
                modalErrors: false,
                showErrorMessage: false,
                dropErrorMessage: "",
                dropFilesLength: 0,
                dropOptions: {
                  addRemoveLinks: true,
                  acceptedFiles: '.jpg,.jpeg,.png,.gif',
                  autoProcessQueue: false,
                  thumbnailHeight: 205,
                  thumbnailWidth: 205,
                  maxFiles: 6,
                  maxFileSizeInMB: 15,
                  parallelUploads: 6,
                  uploadMultiple: false,
                  token: Laravel.csrfToken,
                  dictDefaultMessage: '<i class="fa fa-cloud-upload"></i><br>Arraste e solte fotos aqui <br>ou <b>clique para enviar</b> <br><small>(Máximo 6 fotos)</small>',
                  dictRemoveFile: 'Remover',
                  dictMaxFilesExceeded: 'Limite de 6 imagens excedido!'
                },
                user: {
                    seller: {
                        type_delivery: [],
                        dishes: ''
                    },
                },
                address: {
                    cep: '',
                    address: '',
                    number: '',
                    complement: '',
                    neighborhood: '',
                    city: '',
                    state: ''
                }
            }
        },
        components: {
          Dropzone
        },
        methods: {
            validateBeforeSubmit() {
                this.$validator.validateAll().then(() => {
                    if (this.dropFilesLength >= 1) {
                        this.loading = true;
                        httpService.build('quero-vender').create({
                          'user': this.user,
                          'address': this.address,
                        }).then((res) => {
                          this.user.id = res.data[1]['id'];
                          this.$refs.myVueDropzone.processQueue();
                        })
                    } else {
                        // Mostra o Warning Modal o usuário tentar enviar o form sem fotos.
                        this.modalErrors = true;
                    }
                }).catch(() => {
                    // Mostra o Warning Modal se tiver erro de validação de campos.
                    this.modalErrors = true;
                });
            },
            checkEmail(email) {
              if (email) {
                  axios.post('/entrar/check-email', {email: email}).then((res) => {
                    if (res.data.status === 'founded') {
                      alert('Oia, esse email já existe, oxe, use ele pra entrar!');
                      this.user.email = null;
                    }
                  });
              }
            },
            checkCpf(cpf) {
              if (cpf) {
                  axios.post('/entrar/check-cpf', {cpf: cpf}).then((res) => {
                    if (res.data.status === 'founded') {
                      alert('Amigo, larga de ser espertão, esse cpf ja tem conta aqui, acessa com ela!');
                      this.user.cpf = null;
                    }
                  });
              }
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
            },
            dropShowSuccess: function(file, response) {

              this.loading = false;
              this.$refs.formCadastroVendedor.className = "form_seller_hidden";
              this.$refs.salvoCadastroVendedor.className = "form-chef__thank-you form_seller_show";
              console.log('A file was successfully uploaded');
            },
            dropShowError: function(file, error) {
                this.loading = false;
                this.dropErrorMessage = error;
                this.showErrorMessage = true;
                console.log(this.dropErrorMessage);
            },
            dropFilesAdded: function(file) {
                this.dropFilesLength += file.length;
                console.log(this.dropFilesLength)
                console.log('files uploaded');
                // console.log(this.$refs.myVueDropzone.getQueuedFiles());
                // console.log(this.$refs.myVueDropzone.getUploadingFiles());
            },
            dropFilesRemoved: function(file) {
                if (this.dropFilesLength >= 0) {
                  this.dropFilesLength -= 1;
                  if (this.dropFilesLength <= 6) {
                    this.showErrorMessage = false;
                  }
                }
                console.log('files removed');
                // console.log(this.$refs.myVueDropzone.getQueuedFiles());
                // console.log(this.$refs.myVueDropzone.getUploadingFiles());
            },
            dropSending: function(file, xhr, formData) {
                formData.append('id', this.user.id);
            }
        },
          mounted() {
              let cpfField = document.getElementById('cpfField');
              cpfField.addEventListener('blur', ($event) => {
                this.checkCpf(cpfField.value);
              });
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
    .dropzone .dz-preview .dz-image {
        width: 205px !important;
        height: 205px !important;
    }
    .vue-dropzone .dz-preview .dz-error-mark, .vue-dropzone .dz-preview .dz-success-mark {
        top: 35%!important;
        left: 35%!important;
    }
    .dropzone .dz-preview .dz-error-message {
        top: 60px!important;
        left: 30px!important;
    }
</style>
