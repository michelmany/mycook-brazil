<template>
    <div class="sidebar-left" id="mobile-nav">
        <div class="sidebar-body scroll-pane">
            <ul class="metismenu side-nav" id="menu">
                <router-link to="/" tag="li" exact><a><i class="fa fa-dashboard"></i> Painel </a></router-link>
                <router-link to="/admin/sellers" tag="li"><a><i class="fa fa-user"></i> Vendedores </a></router-link>
                <router-link to="/admin/buyers" tag="li"><a><i class="fa fa-user"></i> Compradores </a></router-link>
                <li :class="{ active : isActive('/admin/settings') }">
                    <a href="#" aria-expanded="true"><i class="fa fa-cogs"></i> Sistema <span class="fa arrow fa-fw"></span></a>
                    <ul aria-expanded="true">
                        <router-link to="#" tag="li"><a>Configurações</a></router-link>
                        <router-link to="/admin/users" tag="li"><a>Usuários</a></router-link>
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