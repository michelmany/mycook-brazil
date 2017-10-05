<template>
    <div>
        <form class="input-group mb-3" method="post" @submit.prevent="send(code)">
            <input type="text" class="form-control" placeholder="Código do cupom" v-model="code">
            <span class="input-group-btn">
                <button class="btn btn-secondary">Aplicar</button>
            </span>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                code: ''
            }
        },

        methods: {
            send(code) {
                axios.post('/moip/services/coupon-verify', {code})
                     .then(response => console.log(response))
                     .catch(error => console.log(error))
            }
        }
    }
</script>