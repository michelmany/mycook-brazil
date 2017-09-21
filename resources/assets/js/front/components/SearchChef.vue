<template>
    <div class="search-chef" v-if="showFilterBar">
        <div class="container">
            <form class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></div>
                    <input v-model="search" type="search" class="form-control form-control-lg input__entrar" id="search-chef" placeholder="Buscar por nome" @keyup.prevent="searchChef" @keydown.enter.prevent="">
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { eventBus } from '../app';

    export default {
        data() {
            return {
                search: '',
                showFilterBar: ''
            }
        },
        methods: {
            searchChef: function() {
                eventBus.$emit('search-chef', this.search);
                // console.log('submitted');
            },
            hasChef(res) {
                this.showFilterBar = res;
            },

        },
        mounted() {
            eventBus.$on('has-chef', this.hasChef);
        }
    }
</script>