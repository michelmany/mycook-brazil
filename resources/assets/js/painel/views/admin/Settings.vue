<template>
    <div class="main-content">
        <div class="page-header">
            <h4>Definições do Sistema</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item active">Configurações</li>
            </ol>
        </div>
        <div class="card">
            <div class="card-header">
                <h6>Configurações Básicas</h6>
            </div>
            <div class="card-block">
                <div class="form-body">
                    <div class="form-group row">
                        <label class="col-md-12 col-lg-4 form-control-label">
                            Valor de Entrega
                        </label>
                        <div class="col-md-12 col-lg-6">
                            <div class="input-icon">
                                <i class="fa fa-money"></i>
                                <input type="number"
                                       class="form-control"
                                       :value="settings.delivery_fee"
                                       min="1"
                                       max="100"
                                       @blur="update($event, 'delivery_fee')">
                            </div>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-md-12 col-lg-4 form-control-label">
                                Radio de Distância Atendida (Km)
                            </label>
                            <div class="col-md-12 col-lg-6">
                                <div class="input-icon">
                                    <i class="fa fa-home"></i>
                                    <input type="number"
                                           class="form-control"
                                           min="1"
                                           max="10"
                                           step="0,1"
                                           :value="settings.radius"
                                           @blur="update($event, 'radius')">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {

        computed: {
            ...mapGetters({settings: 'settings/all'})
        },
        methods: {
            ...mapActions({all: 'settings/all', updateSetting: 'settings/update'}),
            update(event, column) {

                let value = event.target.value;

                if(_.get(this.settings, column) === value) {
                    return;
                }

                this.updateSetting({column, value})
            }
        },

        created() {
            this.all()
        }

    }
</script>
