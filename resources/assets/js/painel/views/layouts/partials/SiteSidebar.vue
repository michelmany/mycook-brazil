<template>
    <div class="sidebar-left" id="mobile-nav">
        <div class="sidebar-body scroll-pane">
            <ul class="metismenu side-nav" id="menu">
                <li :class="{ active : isActive('/') }">
                    <router-link to="/" tag="li"><a><i class="fa fa-dashboard"></i> Painel </a></router-link>
                </li>
                <li :class="">
                    <router-link to="" tag="li"><a><i class="fa fa-cogs"></i> Vendedores </a></router-link>
                </li>
                <li :class="">
                    <router-link to="" tag="li"><a><i class="fa fa-cogs"></i> Compradores </a></router-link>
                </li>
                <li :class="{ active: isActive('/admin/settings') }">
                    <router-link to="/admin/users" tag="li"><a><i class="fa fa-cogs"></i> Usuários </a></router-link>
                </li>
                <li :class="{ active: isActive('/admin/settings') }">
                    <router-link to="/admin/users" tag="li"><a><i class="fa fa-cogs"></i> Configurações </a></router-link>
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