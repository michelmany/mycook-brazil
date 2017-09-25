<template>
    <div>
        <h6 class="card-title text-uppercase">Endereço</h6>
        <!--<p class="card-text"></p>-->
        <div class="mb-3">
            <select class="form-control" v-if="authGuest" v-model="address" @change="save">
                <option value="" selected> Escolha o endereço para entrega</option>
                <option v-for="(address, index) in list" :key="index" :value="address">
                    <small>{{address.address}} {{ address.number}}, {{address.neighborhood}} - {{address.city}}/{{address.state}}</small>
                </option>
            </select>
        </div>
    </div>
</template>

<script>
    import auth from '../../services/auth'

    export default {
        data() {
          return {
              list: [],
              authGuest: false,
              address: ''
          }
        },
        methods: {
            all() {
                axios.get('/minha-conta/get-addresses')
                    .then((res) => {
                        this.list = _.orderBy(res.data, 'default', 'desc');

                        this.get();
                    })
            },
            save()
            {
                if(this.address !== '') {
                    // salvar endereço em uma sessão
                    axios.post('/moip/services/cart/address', {address: this.address})
                        .then(res => {
                            toastr.info('Okay, endereço anotado!', '', {
                                timeOut: 1500
                            })
                        })
                }
            },
            get() {
                axios.get('/moip/services/cart/address')
                     .then(res => {
                         if(res.status !== 204) {
                             this.address = res.data
                         }
                     })
            }
        },
        created() {
            auth.check()
                .then(data => {
                    this.authGuest = data;

                    this.all();

                })
                .catch(err => this.authGuest = false)
        }

    }
</script>