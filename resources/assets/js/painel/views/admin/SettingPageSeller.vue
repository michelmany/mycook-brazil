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
                                <avatar :photo-url="avatarUrl" :action-url="actionUrl"></avatar>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-lg-3 form-control-label">Titulo</label>
                            <div class="col-md-8 col-lg-9">
                                <input type="text" :value="checkProperty('title') ? seller.data.title : null" class="form-control" id="title" @blur="send($event, 'title')" placeholder="Como se chama seu estabelecimento?">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-lg-3 form-control-label">Descrição</label>
                            <div class="col-md-8 col-lg-9">
                                <textarea class="form-control" rows="7" :value="checkProperty('description') ? seller.data.description : null" id="description" @blur="send($event, 'description')" placeholder="Descreva para o público seu estabelecimento"></textarea>
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
            
            actionUrl() {
                return `/api/admin/v1/sellers/${this.seller.id}`
            },
            
            avatarUrl() {
                return this.checkProperty('avatar') ? this.seller.data.avatar : null
            }
        },

        methods: {
            ...mapActions({find: 'sellers/find', update: 'sellers/update'}),

            checkProperty(column) {
                return _.has(this.seller.data, column)
            },

            send(event, column) {

                let _value = event.target.value;

                if(_.get(this.seller.data, column) === _value) {
                    return;
                }

                let payload = {id: this.seller.id, data: {}}
                _.set(payload.data, column, _value)
                this.update(payload)
            }
        },

        created() {
            let user = JSON.parse(Ls.get('auth.user'));

            this.find(user.id)

            this.$bus.$on('seller update success', payload => {
                toastr.success('alterações aplicadas com sucesso.', 'Pagina Atualizada', {timeOut: 1000})
            })
        }
    }
</script>
