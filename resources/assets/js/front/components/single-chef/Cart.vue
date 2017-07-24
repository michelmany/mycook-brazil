<template>
    <div class="card">
        <div class="card-header text-center">
            <h5>Seu carrinho<br><strong>{{ chefName}}</strong></h5>
            <div v-if="courier.date && courier.time">
                <p>{{ courier.fulldate }} <br> {{ courier.time }}</p>
            </div>
        </div>
        <div class="card-block">
            <div v-if="items.length == 0" class="text-center">
                <h4 class="card-title">Carrinho vazio</h4>
                <p class="card-text">Tá esperando o que?</p>
            </div>

            <ul v-for="item in items" >
                <li class="list-unstyled">{{ item.name }}</li>
            </ul>
        </div>
        <div v-if="items.length != 0" class="card-footer text-muted">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Código do cupom">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button">Aplicar</button>
                </span>
            </div>
            <a href="#" class="btn btn-primary btn-block">Finalizar compra</a>
        </div>
    </div>
</template>

<script>
    import { eventBus } from '../../app';

    export default {
        props: {
            chefName: String
        },
        data() {
            return {
                items: '',
                courier: ''
            }
        },
        created() {
            eventBus.$on('cartItems', (cartItems) => {
                // console.log(cartItems)
                this.items = cartItems;
            })
            eventBus.$on('cartData', (cartData) => {
                // console.log(cartData)
                this.courier = cartData;
            })

        }
    }
</script>