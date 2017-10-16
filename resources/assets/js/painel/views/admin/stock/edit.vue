<template>
    <div class="main-content">
        <div class="page-header">
            <h4>Configurar produto</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link :to="{name: 'panel.seller.cardapio-list'}">Cardapio</router-link></li>
                <li class="breadcrumb-item active">Configurar</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Dia</th>
                                        <th>Hora início</th>
                                        <th>Hora término</th>
                                        <th>Quantidade</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(extra, index) in extras" :key="index">
                                        <td>{{ weekdays[index] }}:</td>
                                        <td>
                                            <div class="input-group">
                                                <!-- -->
                                                <input type="text"
                                                       class="form-control ls-timepicker"
                                                       v-model="extras[index].start_time"
                                                       :data-index="index"
                                                       data-type="start"
                                                       @blur="updateTime({value: $event.target._value, type: 'start', index})">
                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control ls-timepicker"
                                                       v-model="extras[index].end_time"
                                                       :data-index="index"
                                                       data-type="end"
                                                       @blur="updateTime({value: $event.target._value, type: 'end', index})">
                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                            </div>
                                        </td>
                                        <td>
                                            <input 
                                            class="form-control" 
                                            placeholder="Quantidade" 
                                            v-model.trim="extras[index].quantity" 
                                            @blur="updateQty({qty: $event.target.value, index})"
                                            v-validate="'numeric'" data-vv-as="quantidade" data-vv-name="quantidade"
                                            :class="{'form-control': true, 'is-danger': errors.has('quantidade') }">

                                            <div v-show="errors.has('quantidade')" class="help is-danger">{{ errors.first('quantidade') }}</div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /row -->
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div class="mt-1">
                            <router-link :to="'/seller/cardapio/' + $route.params['id'] + '/edit'" class="btn btn-default btn-sm">
                                <i class="fa fa-arrow-left"></i> Voltar</router-link>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success" @click.prevent="updateProductExtras({id: $route.params['id']})">
                                <i class="fa fa-check" aria-hidden="true"></i> Salvar Produto
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /row -->
    </div><!-- /main-content -->
</template>

<script>

    import bus from '../../../services/bus'
    import { mapActions, mapGetters, mapMutations } from 'vuex'

    export default {
        data() {
            return {
                weekdays: ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado', 'Domingo'],
            }
        },
        methods: {
            ...mapActions({getData: 'stock/getProductExtra', updateProductExtras: 'stock/updateProductExtras'}),
            ...mapMutations({updateQty: 'stock/UPDATE_EXTRA_QTY', updateTime: 'stock/UPDATE_EXTRA_TIME'}),
        },
        computed: {
            ...mapGetters({extras: 'stock/getExtras'})
        },
        beforeUpdate() {

            $('input.ls-timepicker').timepicker({
                scrollDefault: 'now',
                minTime: '6:00am',
                maxTime: '23:30am',
                timeFormat: 'H:i',
                showDuration: false
            });

            $('input.ls-timepicker').on('changeTime', function($e) {
                bus.$emit('changeTime', {
                    index: $(this).data('index'),
                    value: $(this).val(),
                    type: $(this).data('type')
                })
            })
        },
        created() {
            this.getData({id: this.$route.params['id']})

            bus.$on('redirect', (payload) => {
                this.$router.push(payload.url)
            })

            // update time input
            bus.$on('changeTime', ({index, value, type}) => {
                this.updateTime({value, type, index})
            })
        }
    }

</script>


