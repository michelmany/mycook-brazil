<template>
    <div>
        <form class="input-group mb-3" method="post" @submit.prevent="send(code)">
            <input type="text" class="form-control" placeholder="Código do cupom" v-model="code">
            <span class="input-group-btn">
                <button class="btn btn-secondary" :disabled="!code && !total">Aplicar</button>
            </span>
        </form>
    </div>
</template>

<script>

    import {number_format} from '../../../painel/helpers/functions'

    export default {
        props: ['total'],
        data() {
            return {
                code: '',
                coupon: ''
            }
        },

        methods: {
            send(code) {
                axios.post('/moip/services/coupon-verify?settings=true', {code})
                     .then(response => {
                         this.coupon = response.data
                         this.calc(this.total, this.coupon.settings.discount)
                     })
                      .catch(error => toastr.error(error.response.data.error, 'Cupom inválido'))
            },

            verifyTotalOfUser() {
               return axios.post('/moip/services/coupon-verify', {code: this.code})
                           .then(response => {

                               if(response.data >= this.coupon.settings.limit_of_user) {
                                   toastr.info('Este cupom já utrapassou o limite de uso.', 'Cupom esgotou', {timeOut: 1500});
                                   return;
                               }

                           })
                            .catch(error => toastr.error(error.response.data.error, 'Cupom inválido'))
            },

            calc(total, discount) {

                // check compatibility
                if(this.coupon.settings.minimum_purchase && total <= parseFloat(this.coupon.settings.minimum_purchase)) {
                    toastr.info(`Sua compra deve ser no mínimo R$ ${ number_format(this.coupon.settings.minimum_purchase, 2, ',', '.')}`, 'Cupom inválido', {timeOut: 1500});
                    return;
                }

                // check limit usage
                if(this.coupon.settings.limit_of_user) {
                    this.verifyTotalOfUser();
                }

                this.$emit('couponDiscount', {
                    code: this.code.toUpperCase(),
                    discount: (total * discount) / 100,
                    real: parseFloat(((total - (total * discount) / 100)).toFixed(2)),
                    detail: 'Cupom promocional',
                    id: this.coupon.id
                })
            }
        },

        watch: {
            code(current) {
                this.code = current.toUpperCase()
            },
            total(current) {

                if(!this.coupon) {
                    return;
                }

                return this.calc(current, this.coupon.settings.discount);
            }
        }
    }
</script>

<style scoped>
::-webkit-input-placeholder {
    font-size: 14px!important;
}
::-moz-placeholder {
    font-size: 14px!important;
}
::-moz-placeholder {
    font-size: 14px!important;
}
</style>