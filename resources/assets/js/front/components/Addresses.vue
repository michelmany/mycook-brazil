<template>
    <div>
        <vue-loading v-show="loading" type="bubbles" color="#F95700" :size="{ width: '50px', height: '50px' }" key="1"></vue-loading>

        <transition-group name="fade">
            <div class="address__item d-flex justify-content-between align-items-center"
                v-for="(address, key, index) in addresses" :key="key">
                <div class="radio">
                    <input type="radio" name="address_default" :id="'address_'+key" :checked="address.default" @change="updateDefault(address)">
                </div>
                <div class="pl-5">
                    <div class="address__title"v-if="address.name">{{ address.name }}</div>
                    <div class="address__address">
                        <p class="mb-0">{{ address.address }}, {{ address.number }}</p>
                        <p class="mb-0" v-if="address.complement">{{ address.complement }}</p>
                        <p class="mb-0">{{ address.neighborhood }} - {{ address.city }}/{{ address.state }}</p>
                    </div>
                </div>
                <div class="ml-auto address__close-icon">
                    <a href="#" @click.prevent="removeAddress(address,key)" v-tooltip.top-center="tooltipMessage">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div v-if="addresses.length == 0" :key="1">
                <div class="alert alert-warning" role="alert">
                    Nenhum endereço de entrega cadastrado na plataforma
                </div>
            </div>
        </transition-group>

    </div>
</template>

<script>
    import { HttpService } from '../services/httpService';
    let httpService = new HttpService();
    import vueLoading from 'vue-loading-template'

    export default {
        data() {
            return {
                loading: false,
                tooltipMessage: "Excluir",
                addresses: {},
            }
        },
        methods: {
            listAddresses() {
                this.loading = true;

                setTimeout(() => {
                    axios.get('get-addresses')
                    .then((res) => {
                        this.addresses = _.orderBy(res.data, 'default', 'desc');
                        this.loading = false;
                        console.log(this.addresses)
                    })
                }, 500);

            },
            removeAddress(address, index) {
                //remove from database
                axios.delete('enderecos' + '/' + address.id)
                .then((res) => {
                    // remove from front-end
                    if(res.status === 204) {
                      toastr.success('Endereço excluído com sucesso!', '', {
                        onHidden: () => {
                            this.addresses.splice(index, 1);
                        }
                      })
                    }
                })
            },
            updateDefault(address) {
                axios.patch(`enderecos/${address.id}`, {status: true})
                     .then(res => {
                       if(res.status === 204) {
                         toastr.success('Endereço padrão alterado');
                       }
                     }).catch(error => {
                        toastr.info(error.response.data.error)
                     })
            }

        },
        mounted() {
            this.listAddresses();

            // receive the data from NewAddressForm.vue
            Event.$on('added', (res) => {
                console.log(res);
                this.addresses.push(res);
                if(this.addresses.length >= 1) {
                    this.noAddress = false;
                }

                toastr.success('Endereço adicionado com sucesso!');
            });

        }
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
