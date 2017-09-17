<template>
    <div>
        <vue-loading v-show="loading" type="bubbles" color="#F95700" :size="{ width: '50px', height: '50px' }" key="1"></vue-loading>
        
        <table class="table table-stripped" v-if="!loading">
            
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Chef</th>
                    <th>Meio</th>    
                    <th>Total Pago</th>
                    <th>Status</th>
                    <th>Atualizado em</th>
                    <th>Opções</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(order,index) in orders" :key="index">
                    <td>
                        <span class="badge badge-primary">{{ order.code }}</span>
                    </td>
                    <td>
                        chef
                    </td>
                    <td>
                        <i class="fa fa-2x" :class="{
                            'fa-barcode': order.payment.type == 'BOLETO',
                            'fa-credit-card': order.payment.type == 'CREDIT_CARD'
                            }" aria-hidden="true">
                        </i>
                    </td>
                    <td>
                        R$ {{ order.amount}}
                    </td>
                    <td>
                        {{ order.status}}
                    </td>
                    <td>
                        {{ order.timestamps.updated_at }}
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary">Detalhes</button>
                        <button class="btn btn-sm btn-primary">Cancelar</button>
                    </td>
                </tr>
            </tbody>
            
        </table>

    </div>
</template>

<script>
import vueLoading from 'vue-loading-template'

export default {
    name: 'list-orders',
    data() {
        return {
            loading: false,
            orders: []
        }
    },
    methods: {
        list() {
            this.loading = true
            axios.get('/moip/services/orders')
                 .then(res => {
                    this.orders = res.data;
                    this.loading = false;
                    console.log(res.data)
                })
        }
    },
    mounted() {
        this.list();
    }
}
</script>

<style>
        .fade-enter-active, 
        .fade-leave-active {
          transition: opacity .5s
        }
        .fade-enter, 
        .fade-leave-to {
          opacity: 0
        }
    </style>