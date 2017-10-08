<template>
    <div class="main-content">
        <div class="page-header">
            <h4>Definições do Vendedor</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item active">Configurações</li>
            </ol>
        </div>
        <div class="card">
            <div class="card-header">
                <h6>Configurar Minha Página</h6>
            </div>
            <div class="card-block">
                <div class="form-body">
                    <div class="col-md-9">

                        <div class="form-group row">
                            <label class="col-md-4 col-lg-3 form-control-label">Imagem</label>
                            <div class="col-md-8">
                                <avatar :photo-url="seller.data.avatar" :action-url="actionUrl"></avatar>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-lg-3 form-control-label">Titulo</label>
                            <div class="col-md-8 col-lg-9">
                                <input type="text" :value="seller.data.title" class="form-control" id="title" @blur="send($event, 'title')" placeholder="Como se chama seu estabelecimento?">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-lg-3 form-control-label">Descrição</label>
                            <div class="col-md-8 col-lg-9">
                                <textarea class="form-control" :value="seller.data.description" id="description" @blur="send($event, 'description')" placeholder="Descreva para o público seu estabelecimento"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex'
    import Avatar from '../../components/AvatarUpload.vue'
    import Ls from '../../services/ls'

    export default {
        components: {Avatar},

        data(){
            return {
            }
        },

        computed: {
            ...mapGetters({seller: 'sellers/get'}),
            info() {
                return this.seller.data
            },
            actionUrl() {
                return `/api/admin/v1/sellers/${this.seller.id}`
            },
            photoUrl() {
//                return this.info.avatar ? this.info.avatar : null
            }
        },

        methods: {
            ...mapActions({find: 'sellers/find', update: 'sellers/update'}),

            send(event, column) {
                let payload = {id: this.seller.id, data: {}}
                _.set(payload.data, column, event.target.value)
                this.update(payload)
            }
        },

        created() {
            let user = JSON.parse(Ls.get('auth.user'));

            this.find(user.id)
        }
    }
</script>
