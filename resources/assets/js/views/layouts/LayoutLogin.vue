<template>
    <div class="login-wrapper">
        <div class="login-box">
            <div class="brand-main">
                <a href="/">My Cook</a>
            </div>
            <router-view></router-view>
            <div class="page-copyright">
                <p>Powered by <a href="https://www.nitdesign.com.br/" target="_blank">NitDesign</a></p>
                <p>NitDesign © {{ year }}</p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">

    export default {
        methods: {
            setLayoutClasses(){
                let body = $('body');
                body.removeClass();
                body.addClass('login-page')
            },
        },
        computed: {
          year: function() {
            let d = new Date();
            return d.getFullYear();
          }
        },
        mounted() {
            this.setLayoutClasses()
        },
        destroyed(){
            $('body').removeClass('login-page')
        }
    }
</script>