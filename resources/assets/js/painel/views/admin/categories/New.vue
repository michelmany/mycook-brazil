<template>
    <div class="main-content" id="moipPage">
        <div class="page-header">
            <h4>Categorias</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link :to="{name: 'system-categories'}">Categorias</router-link></li>
                <li class="breadcrumb-item active">Adicionar Categoria</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Adicionar Categoria </h3>
                    </div>
                    <div class="card-block">
                        <form method="post" @submit.prevent="save(name)">
                            <div class="form-body col-lg-9">
                                <!-- input group -->
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-lg-4 form-control-label">Nome da Categoria</label>
                                    <div class="col-md-8 col-lg-8">
                                        <div class="input-icon">
                                            <i class="fa fa-bookmark-o"></i>
                                            <input type="text" class="form-control" id="name" v-model="name">
                                        </div>
                                    </div>
                                </div>
                                <!-- input group -->
                                <button type="submit" class="btn btn-primary" :disabled="!name">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                name: ''
            }
        },

        methods: {
            ...mapActions({store: 'categories/store'}),

            save(name) {
                this.store({name});
                this.name = ''
            }
        },
    }
</script>