<template>
    <div class="main-content">
        <div class="page-header">
            <h3>Editar usuário</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link to="/admin">Admin</router-link></li>
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
        </div>
        <div class="card">
            <div class="card-block">
                <div class="row">
                <div class="col-lg-4">
                    <img :src="user.avatar_full_url + '?s=200'" class="img-fluid" v-if="user.avatar_full_url"></div>
                    <div class="col-lg-6 mt-3 mt-lg-0">
                        <form @submit.prevent="save()">

                            <div class="form-group row">
                                <label for="formAtivo" class="col-12 col-md-2 col-form-label">Status </label>
                                <input type="checkbox" id="formAtivo" v-model="user.active"/>
                            </div>

                            <div class="form-group row">
                                <label for="formNome" class="col-12 col-md-2 col-form-label">Nome</label>
                                <div class="col-12 col-md-10">
                                    <input type="text" class="form-control" id="formNome" placeholder="Seu nome" v-model="user.name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="formCpf" class="col-12 col-md-2 col-form-label">CPF</label>
                                <div class="col-12 col-md-10">
                                    <input type="text" class="form-control" id="formCpf" placeholder="Seu CPF" v-model="user.cpf">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="formEmail" class="col-12 col-md-2 col-form-label">Email</label>
                                <div class="col-12 col-md-10">
                                    <input type="text" class="form-control" id="formEmail" placeholder="Seu email" v-model="user.email">
                                </div>
                            </div>
                
                            <div class="form-group row">
                                <label for="formSenha" class="col-12 col-md-2 col-form-label">Senha</label>
                                <div class="col-12 col-md-10">
                                    <input type="text" class="form-control" id="formSenha" placeholder="Digite uma nova senha" v-model="user.password">
                                </div>
                            </div>
          
                            <div class="form-group row">
                                <label for="formGrupo" class="col-12 col-md-2 col-form-label">Função</label>
                                <div class="col-12 col-md-10">
                                    <select id="formGrupo" class="form-control" v-model="user.role">
                                        <option value="admin">Admin</option>
                                        <option value="comprador">Comprador</option>
                                        <option value="vendedor">Vendedor</option>
                                        <option value="user">Usuário</option>
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check" aria-hidden="true"></i> Salvar alterações
                            </button>

                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <router-link :to="'/admin/users/' + user.id + '/ver'" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Voltar</router-link>
                <router-link :to="'/admin/users/' + user.id + '/remove'" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i>Excluir</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import { HttpService } from '../../../services/httpService';
    let httpService = new HttpService();

    export default {
        data: function () {
            return {
                user: {},
            }
        },
        methods: {
            save() {
                let data = this.user;
                delete data.avatar;

                if (!data.password) {
                    delete data.password;
                }

                httpService.build('admin/v1/users')
                .update(this.$route.params['id'], this.user)
                .then(() => {
                    toastr.success('Editado com sucesso!', 'Usuário '+ this.user.name);
                    this.$router.push('/admin/users/' + this.$route.params['id'] + '/ver');
                });
            }
        },
        mounted() {
            let active = document.getElementById('formAtivo');

            let switchery = new Switchery(active, {
                color: '#38A866'
            });

            switchery.element.addEventListener('change', () => {
              this.user.active = active.checked;
            });

            httpService.build('admin/v1/users/' + this.$route.params['id'])
            .list()
            .then((res) => {
                this.user = res.data;
                this.user.password = null;
                if (!!res.data.active) {
                    switchery.setPosition(true);
                    switchery.handleOnchange(true);
                }
            });
        }
    }
</script>