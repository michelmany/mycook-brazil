<template>
    <div class="main-content" id="moipPage">
        <div class="page-header">
            <h4>Cupons</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link :to="{name: 'system-coupons'}">Cupons</router-link></li>
                <li class="breadcrumb-item active">Adicionar Cupom</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Adicionar Cupom</h3>
                    </div>
                    <div class="card-block">
                        <form method="post" @submit.prevent="save(coupon)">
                            <div class="form-body col-lg-9">

                                <!-- input group -->
                                <div class="form-group row">
                                    <label for="code" class="col-md-4 col-lg-4 form-control-label">Código do Cupom</label>
                                    <div class="col-md-8 col-lg-8">
                                        <div class="input-icon">
                                            <i class="fa fa-bookmark-o"></i>
                                            <input type="text" class="form-control" id="code" v-model="coupon.code">
                                        </div>
                                    </div>
                                </div>
                                <!-- input group -->

                                <!-- input group -->
                                <!--<div class="form-group row">-->
                                    <!--<label for="expires_in" class="col-md-4 col-lg-4 form-control-label">Expira em</label>-->
                                    <!--<div class="col-md-8 col-lg-8">-->
                                        <!--<div class="input-icon">-->
                                            <!--<i class="fa fa-calendar"></i>-->
                                            <!--<input type="number" class="form-control" id="expires_in" v-model="coupon.expires_in">-->
                                        <!--</div>-->
                                    <!--</div>-->
                                <!--</div>-->
                                <!-- input group -->

                                <!-- input group -->
                                <div class="form-group row">
                                    <label for="settings.minimum_purchase" class="col-md-4 col-lg-4 form-control-label">Valor Mínimo de Compra</label>
                                    <div class="col-md-8 col-lg-8">
                                        <div class="input-icon">
                                            <i class="fa fa-money"></i>
                                            <input type="number" class="form-control" id="settings.minimum_purchase" v-model="coupon.settings.minimum_purchase">
                                        </div>
                                    </div>
                                </div>
                                <!-- input group -->

                                <!-- input group -->
                                <div class="form-group row">
                                    <label for="settings.limit_of_user" class="col-md-4 col-lg-4 form-control-label">Limite de Usos</label>
                                    <div class="col-md-8 col-lg-8">
                                        <div class="input-icon">
                                            <i class="fa fa-cog"></i>
                                            <input type="number" class="form-control" id="settings.limit_of_user" v-model="coupon.settings.limit_of_user">
                                        </div>
                                    </div>
                                </div>
                                <!-- input group -->

                                <!-- input group -->
                                <div class="form-group row">
                                    <label for="settings.discount" class="col-md-4 col-lg-4 form-control-label">Valor do Desconto</label>
                                    <div class="col-md-8 col-lg-8">
                                        <div class="input-icon">
                                            <i class="fa fa-percent"></i>
                                            <input type="number" class="form-control" id="settings.discount" v-model="coupon.settings.discount">
                                        </div>
                                    </div>
                                </div>
                                <!-- input group -->

                                <div class="form-group row">
                                    <p class="col-md-12 card-text">
                                        <b>Simulação</b> Fulano tem em seu carrinho R$ <input type="text" style="max-width: 100px; border-radius: 2px; border: 1px solid #ddd;" v-model="simulation"> em produtos.
                                        Com esse cupom ele tera o desconto de {{ coupon.settings.discount }}% a tera o desconto de R$ {{ discount }}
                                        ou seja a compra sairá no valor de R$ {{ simulation - discount}}
                                    </p>
                                </div>

                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                simulation: 130.00,
                coupon: {
                    code: '',
                    expires_in: '',
                    settings: {
                        minimum_purchase: '',
                        limit_of_user: '',
                        discount: 0
                    }
                }
            }
        },

        computed: {
            discount() {
                return (this.coupon.settings.discount * this.simulation) / 100
            }
        },

        methods: {
            ...mapActions({store: 'coupons/store'}),

            save(coupon) {
                this.store(coupon)
            },

            reset() {
                this.coupon = {
                    code: '',
                    expires_in: '',
                    settings: {
                        minimum_purchase: '',
                        limit_of_user: '',
                        discount: 0
                    }
                }
            }
        },

        created() {
            this.$bus.$on('coupon store success', () => {
                toastr.success('Cupom criado com sucesso.', null, {timeOut: 1500, onHidden:() => this.reset() })

            })
        }
    }
</script>