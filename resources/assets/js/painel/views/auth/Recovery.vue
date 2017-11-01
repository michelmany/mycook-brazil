<template>
    <form id="recoveryForm" method="post" @submit.prevent="validateBeforeSubmit">
        <input type="hidden" name="_token" :value="csrf_token">
        <div :class="{'form-group' : true , 'has-danger': errors.has('email') }">
            <input type="email" class="form-control form-control-lg form-control-danger" placeholder="Digite seu email" name="email"
                   v-model="loginData.email" v-validate data-vv-rules="required|email">
        </div>

        <button class="btn btn-green btn-full btn-md ladda-button" data-style="zoom-out">
            <span class="ladda-label">Enviar link para redefinir senha</span></button>

    </form>
</template>

<script type="text/babel">
    import Auth from '../../services/auth'

    export default {
        data() {
            return {
                loginData: {
                    email: ''
                },
                csrf_token: Laravel.csrfToken,
            }
        },
        methods: {
            validateBeforeSubmit(e){

                this.$validator.validateAll().then((result) => { 
                    if(result) {
                        Auth.recovery(this.loginData).then(() => {
                            this.$router.push('/recovery')
                        })
                        return;
                    }
                    toastr.error('Preencha seu email para receber um link de redefinição de senha', 'Atenção');
                });

            }
        },
        mounted() {
            Ladda.bind( '.ladda-button', { timeout: 2000 } );
        }
    }
</script>