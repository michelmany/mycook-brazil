<template>
    <div class="main-content" id="moipPage">
        <div class="page-header">
            <h4>Categorias</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link :to="{name: 'system-categories'}">Categorias</router-link></li>
                <li class="breadcrumb-item active">Editar Categoria</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Editar Categoria </h3>
                    </div>
                    <div class="card-block">
                        <form method="post" @submit.prevent="save">
                            <div class="form-body col-lg-9">
                                <!-- input group -->
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-lg-4 form-control-label">Nome da Categoria</label>
                                    <div class="col-md-8 col-lg-8">
                                        <div class="input-icon">
                                            <i class="fa fa-bookmark-o"></i>
                                            <input type="text" class="form-control" id="name" :value="category.name">
                                        </div>
                                    </div>
                                </div>
                                <!-- input group -->

                                <!-- input group -->
                                <div class="form-group row">
                                    <label class="col-md-4 col-lg-4 control-label">Status</label>
                                    <div class="col-md-8 col-lg-8">
                                        <!-- switch -->
                                        <div class="onoffswitch">
                                            <input type="checkbox" class="onoffswitch-checkbox" id="status" :checked="category.status">
                                            <label class="onoffswitch-label" for="status"></label>
                                        </div>
                                        <!-- switch -->
                                    </div>
                                </div>
                                <!-- input group -->



                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {

        computed: {
            ...mapGetters({category: 'categories/item'})
        },

        methods: {
            ...mapActions({find: 'categories/find', update: 'categories/update'}),
            save(event) {
                let target = $(event.target);

                let payload = {
                    id: this.$route.params.id,
                    data: {
                        name: target.find('input#name').val(),
                        status: target.find('input#status')[0].checked
                    }
                };

                this.update(payload)
            }
        },

        created() {
            // get category by id.
            this.find(this.$route.params.id);
        }
    }
</script>