<template>
    <div class="main-content" id="moipPage">
        <div class="page-header">
            <h4>Vendas</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link to="/seller/orders">Minhas Vendas</router-link></li>
                <li class="breadcrumb-item active">Pedido Detalhado</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title pull-left"> Pedido Nº <span class="badge badge-primary">{{ order.orderId }}</span> </h3>
                        <div class="pull-right">
                            <!-- <a href="javascript:;" target="_blank" class="btn btn-sm btn-outline-info">Visualizar Pedido #MOIP</a> -->
                        </div>
                    </div>
                    <div class="card-block">

                        <table class="table table-stripped">
                            <thead>
                            <tr>
                                <th style="width: 300px;">Status de Entrega</th>
                                <th>Valor Total da Compra</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <select class="form-control" v-model="order.status_delivery" @change="updateDeliveryStatus(order.status_delivery)">
                                        <option v-for="(item,index) in status_lists" :value="item.value">
                                            {{ item.text }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <h4>R${{ order.amount.total | number_format }}</h4>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <br>

                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Nome do comprador:</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                </tr>

                                <tr>
                                    <td>{{ order.buyer.user.name }}</td>
                                    <td>{{ order.buyer.user.email }}</td>
                                    <td>
                                        {{ order.buyer.phone }}
                                        <the-mask style="display: none;" :masked="true" 
                                        :mask="['(##) ####-####', '(##) #####-####']" v-model="order.buyer.phone"></the-mask>
                                    </td>
                                </tr>
                            </thead>
                        </table>

                        <br>

                        <!-- order detail -->
                        <table class="table table-stripped" v-if="order.payment">
                            <thead>
                                <tr>
                                    <th>Final <span class="badge badge-info">{{order.payment.detail.last}}</span></th>
                                    <th>Status Pedido / Pagamento</th>
                                    <th>Criado em</th>
                                    <th>Última atualização pedido</th>
                                    <th>Última atualização pagamento</th>
                                </tr>

                                <tr>
                                    <th>
                                        <i class="fa fa-2x fa-credit-card"
                                           :class="{'fa-cc-visa': order.payment.detail.brand, 'fa-cc-mastercard': order.payment.detail.brand}"></i>
                                    </th>
                                    <th>{{ order.status }} / {{ order.payment.status.formatted }}</th>
                                    <th>{{ order.created_at }}</th>
                                    <th>{{ order.updated_at }}</th>
                                    <th>{{ order.payment.timestamps.updated_at }}</th>
                                </tr>
                            </thead>
                        </table>
                        <!-- order detail -->
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h3> Detalhes Entrega </h3>
                    </div>
                    <div class="card-block">
                        <table class="table table-stripped">
                            <tbody>
                            <tr>
                                <td>Dia</td>
                                <td>{{ order.address.fulldate }}</td>
                            </tr>
                            <tr>
                                <td>Horário</td>
                                <td>{{ $moment(order.address.time).format('LT') }} às {{ $moment(order.address.time).add({minutes: 30}).format('LT') }}</td>
                            </tr>
                            <tr>
                                <td>Endereço</td>
                                <td>{{ order.address.address.address }}<br>
                                    {{ order.address.address.neighborhood }}<br>
                                    {{ order.address.address.city }} -  {{ order.address.address.state }}<br>
                                    {{ order.address.address.complement }}<br>
                                    CEP:  {{ order.address.address.cep }}
                            </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h3> Produtos Comprados </h3>
                    </div>
                    <div class="card-block">
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Descrição</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                </tr>
                            </thead>
                            <tbody v-for="item in order.items">
                                <tr >
                                    <td>{{ item.product }}</td>
                                    <td>{{ item.detail }}</td>
                                    <td>{{ item.quantity }}x</td>
                                    <td>R$ {{ item.price | number_format }}</td>
                                </tr>

                                <tr class="bg-color-gray" v-if="!item.type">
                                    <td colspan="1"><i class="fa fa-info-circle"></i> Observações </td>
                                    <td colspan="3">{{ item.note }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import {chunk_split, number_format} from '../../../helpers/functions'
    import {mapGetters, mapActions} from 'vuex'
    export default {
        data() {
          return {
              status_lists: [
                  {text: 'Aguardando', value: 0},
                  {text: 'Encaminhando', value: 1},
                  {text: 'Saiu para Entrega', value: 2},
                  {text: 'Endereço não Localizado', value: 3},
                  {text: 'Entregue', value: 4},
                  {text: 'Finalizado', value: 5},
              ]
          }
        },
        computed: {
            ...mapGetters({order: 'orders/getOrder'})
        },
        methods: {
            ...mapActions({find: 'orders/find', update: 'orders/update'}),

            updateDeliveryStatus(status) {
                let payload = {id: this.order.id, data: {status_delivery: status}}
                this.update(payload)
            }
        },
        created() {
            this.find(this.$route.params.id)
        }
    }
</script>