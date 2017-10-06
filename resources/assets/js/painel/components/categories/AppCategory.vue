<template>
    <div id="app-category">
        <slot name="all" :categories="filteredStatus"></slot>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex'

    export default {
        name: 'app-category',

        computed: {
            ...mapGetters({categories: 'categories/all'}),
            filteredStatus() {
                return _.filter(this.categories, category => category.status === 1)
            }
        },

        methods: {
            ...mapActions({all: 'categories/all'})
        },

        created() {

            this.all();

        }
    }
</script>