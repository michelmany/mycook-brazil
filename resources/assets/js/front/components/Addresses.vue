<template>
    <div>
        <transition-group name="fade" mode="out-in">
            <div class="address__item d-flex justify-content-between align-items-center" 
                v-if="addresses.length >= 1" v-for="address in addresses" key="1">
                <div>
                    <div class="address__title"v-if="address.name">{{ address.name }}</div>
                    <div class="address__address">
                        <p class="mb-0">{{ address.address }}, {{ address.number }}</p>
                        <p class="mb-0" v-if="address.complement">{{ address.complement }}</p>
                        <p class="mb-0">{{ address.neighborhood }} - {{ address.city }}/{{ address.state }}</p>
                    </div>
                </div>
                <div class="ml-auto address__close-icon">
                    <a href="#" @click.prevent="removeAddress(address)" v-tooltip.top-center="tooltipMessage">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

        </transition-group>

        <transition name="fade" mode="out-in">
            <div v-if="noAddress" class="address__item d-flex justify-content-between align-items-center">
                Você não tem nenhum endereço cadastrado ainda.
            </div>
        </transition>

    </div>
</template>

<script>
    import { HttpService } from '../services/httpService';
    let httpService = new HttpService();

    export default {
        data() {
            return {
                tooltipMessage: "Excluir",
                noAddress: false,
                addresses: "",
            }
        },
        methods: {
            listAddresses() {
                axios.get('get-addresses')
                .then((res) => {
                    this.addresses = res.data;
                    if (this.addresses.length === 0) {
                        this.noAddress = true
                    }
                })
            },
            removeAddress(address) {

                //remove from database
                axios.delete('enderecos' + '/' + address.id)
                .then((res) => {
                    // remove from front-end
                    var index = this.addresses.indexOf(address);
                    this.addresses.splice(index, 1);

                    toastr.success('Endereço excluído com sucesso!');

                    if(this.addresses.length === 0) {
                        this.noAddress = true;
                    }

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