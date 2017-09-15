<template>
    <div>
        <transition name="component-fade" appear mode="out-in">
            <div v-if="!toCompleteAddress" key="cep">
                <div class="form-inline d-flex justify-content-center" style="margin-top: 35px">
                        <the-mask v-model="address.cep" placeholder="Digite seu CEP"
                        :mask="'#####-###'"
                        v-validate="'required|min:8'" data-vv-name="cep"
                        :class="{'form-control': true, 'is-danger': errors.has('cep') }" 
                        class="form-control mb-2 mr-sm-2 mb-sm-0 search__input" @keyup.native="getcep()"
                         />
                        <button class="btn search__button" @click="getcep()">Buscar</button>
                  </div>
                <div>
                    <p class="search__text mt-3">Não sabe o CEP? <br class="hidden-sm-up"><strong>Clique aqui</strong> e digite seu endereço.</p>
                </div>
            </div>
            <div v-else key="number">
                <div class="row no-gutters">
                    <div class="col-lg-6">
                        <input id="address_disabled" type="text" class="form-control form-control-lg input__entrar disabled" v-model="address.address" disabled>
                    </div>
                    <div class="col-lg-2">
                        <input id="city_disabled" type="text" v-model="address.city"
                                class="form-control form-control-lg input__entrar disabled" disabled>
                    </div>
                    <div class="col-lg-2">
                        <input id="state_disabled" type="text" v-model="address.state"
                                class="form-control form-control-lg input__entrar disabled" disabled>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" v-model="address.number" placeholder="Nº" 
                                v-validate="'required|min:1'" data-vv-name="número"
                                :class="{'form-control': true, 'is-danger': errors.has('número') }" 
                                class="form-control form-control-lg input__entrar">
                        <div v-show="errors.has('número')" class="help is-danger">{{ errors.first('número') }}</div>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-link btn-lg" @click="backToHomeQuery()">Voltar</button>
                    <button class="btn search__button" @click="getLocation()">Buscar</button>
                </div>
            </div>
        </transition>

    </div>
</template>

<script>
import { HttpService } from '../services/httpService'
let httpService = new HttpService();
import { eventBus } from '../app';

    export default {
        data: function () {
            return {
                toCompleteAddress: false,
                address: {
                    cep: '',
                    number: ''
                }
            }
        },
        methods: {
            validateBeforeSubmit() {
                this.$validator.validateAll().then(() => {

                    // this.getLocation()

                }).catch(() => {
                    toastr.warning('Digite seu CEP corretamente!', 'Atenção');
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

                        //show the inputs with number empty to complete address
                        if (typeof this.address.address !== "undefined") {
                            this.toCompleteAddress = true;
                        } else {
                            toastr.warning('Digite seu CEP corretamente!', 'Atenção');
                        }

                    })
                }
            },
            backToHomeQuery() {
                this.toCompleteAddress = false;
            },
            getLocation() {
                var address = this.address.address + ",+" + this.address.number + "+-+" + this.address.neighborhood + ",+" + this.address.city + "+-+" + this.address.state + ",+Brasil";
                var addressUrl = address.replace(/ /g,"+");
                var key = 'AIzaSyAwgqK1Q77MA7youjVulJUH7rsRC9ikOY8';

                httpService.xmlHttpRequest('https://maps.googleapis.com/maps/api/geocode/json?address=' + addressUrl + '&sensor=true&key=' + key).then((res) => {

                    // get coordinates 
                    let resObj = JSON.parse(res);
                    if(resObj.status == "OK") {
                        let location = resObj.results[0].geometry.location;
                        this.address.latitude = location.lat;
                        this.address.longitude = location.lng;
                        // console.log(this.address)

                        this.goToListPage();

                    } else {
                        toastr.warning('Confira seu CEP e tente outra vez!', 'Atenção');
                        console.log('ERROR');
                    }

                })
            },
            goToListPage() {
                // console.log(id)
                if(typeof this.address.address !== "undefined") {
                    window.location.href = "/lista-chefs/" + this.address.latitude + "/" + this.address.longitude;
                } else {
                    toastr.error('Ocorreu algum erro com o servidor, por favor tente outra vez!', 'Erro');
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
<style lang="scss" scoped>
    .disabled {
        background: #cecece;
        -webkit-appearance: none;
        opacity: 1;
        pointer-events: none;
        border: 0;
        border-radius: 0;
    }
    .input__entrar {
        border: 0;
        border-radius: 0;
    }

    .component-fade-enter-active, .component-fade-leave-active {
      transition: opacity .5s ease;
    }
    .component-fade-enter, .component-fade-leave-to {
      opacity: 0;
    }
</style>