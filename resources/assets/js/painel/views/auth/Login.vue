<template>
    <form id="loginForm" method="post" @submit.prevent="validateBeforeSubmit">
        <div :class="{'form-group' : true , 'has-danger': errors.has('email') }">
            <input type="email" class="form-control form-control-lg form-control-danger" placeholder="Digite seu email" name="email"
                   v-model="loginData.email" v-validate data-vv-rules="required|email">
        </div>
        <div :class="{'form-group' : true , 'has-danger': errors.has('password') }">
            <input type="password" class="form-control form-control-lg form-control-danger" placeholder="Digite sua senha" name="password"
                   v-model="loginData.password" v-validate data-vv-rules="required">
        </div>
        <div class="other-actions row">
            <div class="col-sm-6">
                <div class="checkbox">
                    <label class="c-input c-checkbox">
                        <input type="checkbox" name="remember" v-model="loginData.remember">
                        <span class="c-indicator"></span>
                        Lembrar de mim?
                    </label>
                </div>
            </div>
            <div class="col-sm-6 text-sm-right">
                  <router-link :to="{ name: 'recovery' }" class="forgot-link">Recuperar senha?</router-link>
            </div>
        </div>
        <button class="btn btn-theme btn-full btn-lg">Acessar</button>
    </form>
</template>

<script type="text/babel">
    import Auth from '../../services/auth'

    export default {
        data() {
            return {
                loginData: {
                    email: '',
                    password: '',
                    remember: ''
                }
            }
        },
        methods: {
            validateBeforeSubmit(e){
                this.$validator.validateAll().then((result) => { 
                    if(result) {
                        Auth.login(this.loginData).then(() => {
                            this.$router.push('/')
                        })
                        return;
                    }
                    toastr.error('Favor preencher os campos obrigatórios', 'Atenção');
                });
            },
        }
    }
</script>