<template>
<div>
    <form action="/list" class="form-inline d-flex justify-content-center" method="post">
        <div>
            <the-mask name="q" class="form-control mb-2 mr-sm-2 mb-sm-0 search__input"
            :mask="'#####-###'"
            v-validate="'required'" data-vv-name="cep"
            :class="{'form-control': true, 'is-danger': errors.has('cep') }" 
            placeholder="Digite seu CEP" />
            <button class="btn search__button" type="submit">Buscar</button>
        </div>
    </form>
</div>
</template>

<script>
    export default {
        data: function () {
            return {
                address: {
                    cep: 'ergert'
                }
            }
        },
        methods: {
            validateBeforeSubmit() {
                this.$validator.validateAll().then(() => {

                }).catch(() => {

                });
            },
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script 