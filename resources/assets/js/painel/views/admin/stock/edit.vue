<template>
    <div class="main-content">
        <div class="page-header">
            <h4>Configurar produto</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link to="/admin/cardapio">Cardapio</router-link></li>
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
                                    <tr v-for="(extra, index) in extras">
                                        <td>{{ weekdays[index] }}:</td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control ls-timepicker" v-model="extra.start_time">
                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control ls-timepicker" v-model="extra.end_time">
                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" placeholder="Quantidade" v-model.number="extra.quantity" >
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /row -->
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div class="mt-1">
                            <router-link :to="'/admin/cardapio/' + $route.params['id'] + '/edit'" class="btn btn-default btn-sm">
                                <i class="fa fa-arrow-left"></i> Voltar</router-link>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success" v-on:click="updateData($event)">
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
    import { HttpService } from '../../../services/httpService';
    let httpService = new HttpService();

    export default {
        data() {
            return {
                weekdays: ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado', 'Domingo'],
                extras: [
                    { date: 'Seg', start_time: "09:00",  end_time: "22:30", quantity: 0 },
                    { date: 'Ter', start_time: "09:00", end_time: "22:30", quantity: 0},
                    { date: 'Qua', start_time: "09:00", end_time: "22:30", quantity: 0},
                    { date: 'Qui', start_time: "09:00", end_time: "22:30", quantity: 0},
                    { date: 'Sex', start_time: "09:00", end_time: "22:30", quantity: 0},
                    { date: 'Sáb', start_time: "09:00", end_time: "22:30", quantity: 0},
                    { date: 'Dom', start_time: "09:00", end_time: "22:30", quantity: 0},
                ]
            }
        },
        methods: {
            getData() {
                httpService.build('admin/v1/extras')
                .list({query: 'where[product_id]='+ this.$route.params['id']})
                .then((res) => {
                    // console.log(res.data)
                    if(res.data.data.length > 0) {
                        this.extras = res.data.data;
                    }
                    // this.user.seller = res.data.seller || {type_delivery: []};
                });
            },
            updateData(evt) {
                evt.preventDefault();
                let data = this.extras;

                httpService.build('admin/v1/extras')
                .update(this.$route.params['id'], data)
                .then((res) => {
                    console.log(res)
                    toastr.success('Configurado com sucesso!', 'Produto');
                    this.$router.push('/admin/cardapio/' + this.$route.params['id'] + '/edit');
                })
                .catch((error) => {
                    console.log(error)
                    toastr.error('Não foi possível editar seus dados!', 'Erro de servidor');
                });
            }
        },
        mounted() {

            jQuery('input.ls-timepicker').timepicker({
                scrollDefault: 'now',
                minTime: '6:00am',
                maxTime: '23:30am',
                timeFormat: 'H:i',
                showDuration: false
            });


        },
        created() {
            this.getData()
        }
    }

</script>


