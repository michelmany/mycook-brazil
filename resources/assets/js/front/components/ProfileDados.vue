<template>
    <form @submit.prevent="validateBeforeSubmit()">

        <div class="form-group">
            <input type="text" name="name" v-model="user.name" placeholder="Seu nome"
            v-validate="'required|max:35'" data-vv-as="nome completo"
            :class="{'form-control': true, 'is-danger': errors.has('name') }"
            class="form-control form-control-lg input__entrar disabled" readonly="readonly">
            <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</div>
        </div>

        <div class="form-group">
            <input type="email" v-model="user.email" placeholder="Seu email" 
                    v-validate="'email|max:35'" data-vv-name="email"
                    :class="{'form-control': true, 'is-danger': errors.has('email') }"
                    class="form-control form-control-lg input__entrar disabled" readonly="readonly">
            <div v-show="errors.has('email')" class="help is-danger">{{ errors.first('email') }}</div>
        </div>

        <div class="form-group row">
            <div class="col-6">
                <the-mask v-model="user.buyer.phone" placeholder="Seu telefone"
                        :mask="['(##) ####-####', '(##) #####-####']" 
                        v-validate="'required|min:10'" data-vv-as="telefone" data-vv-name="phone"
                        :class="{'form-control': true, 'is-danger': errors.has('phone') }"
                        class="form-control form-control-lg input__entrar"/>
                <div v-show="errors.has('phone')" class="help is-danger">{{ errors.first('phone') }}</div>

            </div>
            <div class="col-6">
                <the-mask v-model="user.cpf" placeholder="Seu CPF" 
                    :mask="'###.###.###-##'"
                    v-validate="'cpf|digits:11'" data-vv-as="CPF" data-vv-name="cpf"
                    :class="{'form-control': true, 'is-danger': errors.has('cpf') }"
                    id="cpfField"
                    class="form-control form-control-lg input__entrar"></the-mask>
                <div v-show="errors.has('cpf')" class="help is-danger">{{ errors.first('cpf') }}</div>
            </div>
        </div>

        <div class="form-group">
            <the-mask v-model="user.buyer.birth" placeholder="Data de nascimento" 
                :mask="'##/##/####'"
                v-validate="'min:8'"
                data-vv-as="Data de nascimento" data-vv-name="birth"
                :class="{'form-control': true, 'is-danger': errors.has('birth') }"
                id="birthField"
                class="form-control form-control-lg input__entrar"></the-mask>
            <div v-show="errors.has('birth')" class="help is-danger">{{ errors.first('birth') }}</div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-submit-orange">
                Salvar alterações
            </button>
        </div>
    </div><!-- /col-md-6 -->

</form>
</template>

<script>
    import TheMask from 'vue-the-mask'
    import { HttpService } from '../services/httpService'
    let httpService = new HttpService();

    export default {
        data() {
            return {
                user: {}
            }
        },
        props: [
            'userdata'
        ],
        methods: {
            validateBeforeSubmit() {
                this.$validator.validateAll().then((res) => {
                    if(res) {
                        this.updateData();
                        return;
                    }
                    toastr.warning('Favor conferir seus dados!', 'Atenção');
                });
            },
            updateData() {
                axios.post('perfil', {
                    'user': this.user,
                    'buyer': this.user.buyer,
                  })
                  .then(function (res) {
                    console.log(res);
                    toastr.success('Seus dados foram atualizados com sucesso!', 'Olá ' + res.data.name);
                  })
                  .catch(function (error) {
                    console.log(error);
                    toastr.error('Não foi possível editar seus dados!', 'Erro de servidor');
                  });
            }
        },
        created() {
            if(this.$props.userdata.buyer === null) {
                this.$props.userdata.buyer = {}
            }
            this.user = this.$props.userdata
        }
    }
</script>
<style lang="scss" scoped>
    .disabled {
        border: 1px solid rgba(0, 0, 0, 0.15);
        background-color: #eceeef;
        pointer-events: unset;
    }
</style>