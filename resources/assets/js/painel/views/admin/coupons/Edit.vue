<template>
    <div class="main-content" id="moipPage">
        <div class="page-header">
            <h4>Cupons</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link :to="{name: 'system-coupons'}">Cupons</router-link></li>
                <li class="breadcrumb-item active">Editar Cupom</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Editar Cupom </h3>
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
                                        <!--<div v-if="!edit_expiresIn">-->
                                            <!--<div class="input-icon">-->
                                                <!--<div class="form-control">-->
                                                    <!--{{ $moment(expiresIn).format('DD/MM/YYYY HH:mm:ss') }}-->
                                                <!--</div>-->
                                            <!--</div>-->
                                        <!--</div>-->
                                        <!--<div class="input-icon" v-else>-->
                                            <!--<i class="fa fa-calendar"></i>-->
                                            <!--<input type="number" class="form-control" id="expires_in" v-model="coupon.expires_in">-->
                                        <!--</div>-->
                                        <!--<div class="col-md-12 mt-1">-->
                                            <!--Editar Data de Validade?-->
                                            <!--&lt;!&ndash; switch &ndash;&gt;-->
                                            <!--<div class="onoffswitch">-->
                                                <!--<input type="checkbox" class="onoffswitch-checkbox" id="edit_expiresIn" v-model="edit_expiresIn">-->
                                                <!--<label class="onoffswitch-label" for="edit_expiresIn"></label>-->
                                            <!--</div>-->
                                            <!--&lt;!&ndash; switch &ndash;&gt;-->
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
    import {mapActions, mapGetters, mapState} from 'vuex'

    export default {
        data() {
            return {
                simulation: 100.00,
                edit_expiresIn: false,
                expiresIn: ''
            }
        },

        watch: {
            edit_expiresIn(current) {
                if(!current) {
                    this.coupon.expires_in = this.expiresIn
                }
            }
        },

        computed: {
            ...mapGetters({coupon: 'coupons/item'}),
            discount() {
                return (this.coupon.settings.discount * this.simulation) / 100
            }
        },

        methods: {
            ...mapActions({find: 'coupons/find', update: 'coupons/update'}),

            save(coupon) {
                this.update({id: this.$route.params.id, data: coupon})
            },

            get() {
                this.find(this.$route.params.id);
                this.expiresIn = this.coupon.expires_in
            }
        },

        created() {

            this.get();

            this.$bus.$on('coupon update success', () => {
                toastr.success('Cupom atualizado com sucesso.', null, {timeOut: 1500, onHidden: () => this.$router.push({name: 'system-coupons'}) })
            })
        }
    }
</script>