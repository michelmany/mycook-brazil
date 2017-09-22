<template>
    <form @submit.prevent="validateBeforeSubmit()">
        <div class="address__item">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-12 col-md-6 col-lg-9">
                    <div class="input-group input-group-lg">
                        <the-mask id="cep_field" v-model="address.cep" placeholder="Digite seu CEP"
                        :mask="'#####-###'"
                        v-validate="'required|min:8'" data-vv-name="cep"
                        :class="{'form-control': true, 'is-danger': errors.has('cep') }"
                        class="form-control form-control-lg input__entrar" @keyup.native="getcep()"/>
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" @click="openBuscaCep()"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 text-center mt-2 mt-md-0">
                    <a href="#" class="btn btn-link address__nocep-link">Não sabe seu CEP?</a>
                </div>
            </div>
        </div>

        <transition name="fade">
            <div class="address__item" v-show="showBuscaCep">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input  id="address_name" type="text" v-model="address.name" placeholder="Nome (Ex.: Minha casa)"
                            v-validate="'required'" data-vv-name="nome"
                            :class="{'form-control': true, 'is-danger': errors.has('nome') }"
                            class="form-control form-control-lg input__entrar">
                            <div v-show="errors.has('nome')" class="help is-danger">{{ errors.first('nome') }}</div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <input  id="address_address" type="text" v-model="address.address" placeholder="Endereço"
                            v-validate="'required|max:45'" data-vv-name="endereço"
                            :class="{'form-control': true, 'is-danger': errors.has('endereço') }"
                            class="form-control form-control-lg input__entrar">
                            <div v-show="errors.has('endereço')" class="help is-danger">{{ errors.first('endereço') }}</div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="text" placeholder="Número"
                            v-validate="'required|min:1'" data-vv-name="número"
                            :class="{'form-control': true, 'is-danger': errors.has('número') }"
                            class="form-control form-control-lg input__entrar"
                            v-model="address.number">
                            <div v-show="errors.has('número')" class="help is-danger">{{ errors.first('número') }}</div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text" v-validate="'max:30'" v-model="address.complement" placeholder="Complemento"
                            data-vv-as="complemento" data-vv-name="complemento"
                            :class="{'form-control': true, 'is-danger': errors.has('complemento') }"
                            class="form-control form-control-lg input__entrar">
                            <div v-show="errors.has('complemento')" class="help is-danger">{{ errors.first('complemento') }}</div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <input id="neighborhood_field" type="text" v-model="address.neighborhood" placeholder="Bairro"
                            v-validate="'required|max:35'" data-vv-as="bairro" data-vv-name="neighborhood"
                            :class="{'form-control': true, 'is-danger': errors.has('neighborhood') }"
                            class="form-control form-control-lg input__entrar">
                            <div v-show="errors.has('neighborhood')" class="help is-danger">{{ errors.first('neighborhood') }}</div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <input id="city_field" type="text"  v-model="address.city" placeholder="Município"
                            v-validate="'required|max:35'" data-vv-as="município" data-vv-name="city"
                            :class="{'form-control': true, 'is-danger': errors.has('city') }"
                            class="form-control form-control-lg input__entrar">
                            <div v-show="errors.has('city')" class="help is-danger">{{ errors.first('city') }}</div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <input id="state_field" type="text"  v-model="address.state" placeholder="UF"
                            v-validate="'required|max:2'" data-vv-as="UF" data-vv-name="state"
                            :class="{'form-control': true, 'is-danger': errors.has('state') }"
                            class="form-control form-control-lg input__entrar">
                            <div v-show="errors.has('state')" class="help is-danger">{{ errors.first('state') }}</div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group ">
                            <input type="text" v-model="address.reference" placeholder="Ponto de referência"
                            class="form-control form-control-lg input__entrar">
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="form-group">
                            <div class="submit-button text-center mt-3 mt-md-0">
                                <button type="submit" class="btn btn-submit-green btn-block btn-lg">Cadastrar endereço</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </transition>

</form>
</template>

<script>
    import { HttpService } from '../services/httpService';
    let httpService = new HttpService();

    window.Event = new Vue();

    export default {
        data() {
            return {
                showBuscaCep: false,
                tooltipMessage: "Excluir",
                noAddress: false,
                address: {
                    name: "",
                    address: "",
                    id: "",
                    cep: "",
                    number: "",
                    complement: "",
                    neighborhood: "",
                    state: "",
                    reference: "",
                    latitude: "",
                    longitude: ""
                }
            }
        },
        methods: {
            openBuscaCep() {
                if( this.address.cep.length === 8 ) {
                    this.showBuscaCep = true;
                } else {
                    this.showBuscaCep = false;
                    toastr.warning('Digite o seu CEP!', 'Atenção');
                }
            },
            validateBeforeSubmit() {
                this.$validator.validateAll().then(() => {
                    this.saveAddress();

                }).catch((res) => {
                    console.log(res);
                    toastr.warning('Favor conferir os dados cadastrados!', 'Atenção');
                });
            },
            saveAddress: function () {
              axios.post('save-address', this.address)
                  .then((res) => {
                      
                    // emit event to addresses component to show the box with the new address
                    Event.$emit('added', res.data);
                  })
            },
            getcep: function () {
                if (this.address.cep.length === 8) {
                    httpService.xmlHttpRequest('https://viacep.com.br/ws/' + this.address.cep + '/json/').then((res) => {
                        this.showBuscaCep = true;

                        //set data
                        let cep = JSON.parse(res);
                        this.address.address = cep.logradouro;
                        this.address.neighborhood = cep.bairro;
                        this.address.city = cep.localidade;
                        this.address.state = cep.uf;

                        // get coordinates (lat and lng)
                        this.getLocation();

                    })
                }
            },
            getLocation() {
                var address = this.address.address + ",+" + this.address.number + "+-+" + this.address.neighborhood + ",+" + this.address.city + "+-+" + this.address.state + ",+Brasil" || this.address.cep;

                var addressUrl = address.replace(/ /g,"+");
                var key = 'AIzaSyAwgqK1Q77MA7youjVulJUH7rsRC9ikOY8';

                httpService.xmlHttpRequest('https://maps.googleapis.com/maps/api/geocode/json?address=' + addressUrl + '&sensor=true&key=' + key).then((res) => {

                    // get coordinates
                    let resObj = JSON.parse(res);
                    if(resObj.status == "OK") {
                        let location = resObj.results[0].geometry.location;
                        this.address.latitude = location.lat;
                        this.address.longitude = location.lng;
                    } else {
                        console.log('ERRO');
                    }

                })
            }

        },

    }
</script>

<style>
    .tooltip {
      display: block !important;
      padding: 4px;
      z-index: 10000;
      margin-bottom: 15px;
  }

  .tooltip .tooltip-inner {
      background: black;
      color: white;
      border-radius: 16px;
      padding: 5px 10px 4px;
  }

  .tooltip tooltip-arrow{
      display: none;
  }

  .tooltip[aria-hidden='true'] {
      visibility: hidden;
      opacity: 0;
      transition: opacity .15s, visibility .15s;
  }

  .tooltip[aria-hidden='false'] {
      visibility: visible;
      opacity: 1;
      transition: opacity .15s;
  }
</style>
