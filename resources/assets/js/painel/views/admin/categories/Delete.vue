<template>
    <div class="main-content" id="moipPage">
        <div class="page-header">
            <h4>Categorias</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item"><router-link :to="{name: 'system-categories'}">Categorias</router-link></li>
                <li class="breadcrumb-item active">Remover Categoria</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Remover Categoria </h3>
                    </div>
                    <div class="card-block">
                        {{ category }}
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
            ...mapActions({find: 'categories/find'}),
        },

        created() {
            this.find(this.$route.params.id)
        }
    }
</script>