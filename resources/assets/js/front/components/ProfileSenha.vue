<template>
<div>

    <transition name="component-fade" mode="out-in">
        <div v-if="passwordIsNull">
            <p>Você se logou com facebook, aproveite e crie uma senha segura para habilitar login com email.</p>
        </div>
    </transition>

    <form @submit.prevent="validateBeforeSubmit()">

            <div class="form-group" v-if="!passwordIsNull">
           <!--      <input type="password" v-model="password" id="formSenha" 
                    class="form-control form-control-lg input__entrar" placeholder="Senha atual"> -->

                    <input type="password" v-model="password" id="formSenha" placeholder="Senha atual" 
                            v-validate="'required|min:6'" data-vv-name="senha"
                            :class="{'form-control': true, 'is-danger': errors.has('senha') }"
                            class="form-control form-control-lg input__entrar disabled" >
                    <div v-show="errors.has('senha')" class="help is-danger">{{ errors.first('senha') }}</div>
            </div>

            <div class="form-group">
               <!--  <input type="password" v-model="new_password" id="formNovaSenha" 
                class="form-control form-control-lg input__entrar" placeholder="Nova senha"> -->

                <input type="password" v-model="new_password" id="formNovaSenha" placeholder="Nova senha" 
                        v-validate="'required|min:6'" data-vv-name="new_password"
                        :class="{'form-control': true, 'is-danger': errors.has('new_password') }"
                        class="form-control form-control-lg input__entrar">
                <div v-show="errors.has('new_password')" class="help is-danger">{{ errors.first('new_password') }}</div>
            </div>

            <div class="form-group">
            <!--     <input type="password" v-model="confirm_password" id="formConfirmarSenha" 
                    class="form-control form-control-lg input__entrar" placeholder="Confirmar nova senha"> -->

                    <input type="password" v-model="confirm_password" id="formConfirmarSenha" placeholder="Confirmar nova senha"
                        v-validate="'required|min:6'" data-vv-name="confirm_password"
                        :class="{'form-control': true, 'is-danger': errors.has('confirm_password') }"
                        class="form-control form-control-lg input__entrar">
                    <div v-show="errors.has('confirm_password')" class="help is-danger">{{ errors.first('confirm_password') }}</div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-submit-orange">
                    Salvar nova senha
                </button>
            </div>

    </form>
</div>
</template>

<script>
    export default {
        data() {
            return {
                password: '',
                new_password: '',
                confirm_password: ''
            }
        },
        props: [
            'passwordIsNull'
        ],
        methods: {
            validateBeforeSubmit() {
                this.$validator.validateAll().then((res) => {
                    if(res) {
                        if(this.new_password != this.confirm_password) {
                            toastr.warning('As senhas não conferem!', 'Atenção');
                        } else {
                            this.updateData();
                            return;
                        }
                        toastr.warning('Favor conferir seus dados!', 'Atenção');
                    }
                });
            },
            updateData() {
                axios.post('troca-senha', {
                    'password': this.password,
                    'new_password': this.new_password,
                    'confirm_password': this.confirm_password,
                  })
                  .then(function (res) {
                    console.log(res);
                    if (res.data.msg === "As senhas não conferem") {
                        toastr.warning('As senhas não conferem!', 'Atenção');
                    }
                    if (res.data.id > 0) {
                        toastr.success('Sua senha foi atualizada com sucesso!', 'Olá');
                        location.reload();
                    }
                  })
                  .catch(function (error) {
                    // console.log(error);
                    toastr.error('Não foi possível atualizar sua senha. Tente outra vez!', 'Erro de servidor');
                  });
            }
        },
        mounted() {

        }

    }
</script>

<style>
    .component-fade-enter-active, .component-fade-leave-active {
      transition: opacity .5s ease;
    }
    .component-fade-enter, .component-fade-leave-to {
      opacity: 0;
    }
</style>