<template>
    <div class="sidebar-left" id="mobile-nav">
        <div class="sidebar-body scroll-pane">
            <ul class="metismenu side-nav" id="menu">
                <li :class="{ active : isActive('/') }">
                    <a href="#" aria-expanded="true"><i class="fa fa-dashboard"></i> Painel <span class="fa arrow fa-fw"></span></a>
                    <ul aria-expanded="true">
                        <router-link to="/" tag="li"><a>Home</a></router-link>
                        <router-link to="/ecommerce" tag="li"><a>Ecommerce</a></router-link>
                        <router-link to="/finance" tag="li"><a>Finance</a></router-link>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</template>

<script type="text/babel">

    export default {
        data() {
            return {
                'sidebar' : 'sidebar'
            }
        },
        mounted(){
            Plugin.initPlugins(['MetisMenu'])
        },
        methods : {
            initPlugins(){
                $(".scroll-pane").mCustomScrollbar({theme:"minimal-dark"});
            },
            isActive(url){
                return (this.$route.path.indexOf(url) > -1)
            }
        }

    }
</script>