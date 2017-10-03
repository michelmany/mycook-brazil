<template>
    <div class="sidebar-left" id="mobile-nav">
        <div class="sidebar-body scroll-pane">
            <ul class="metismenu side-nav" id="menu">
                <router-link to="/" tag="li" exact><a><i class="fa fa-dashboard"></i> Painel </a></router-link>

                <template v-if="user.role === 'admin'">
                    <router-link to="/admin/sellers" tag="li"><a><i class="fa fa-user"></i> Vendedores </a></router-link>
                    <router-link to="/admin/buyers" tag="li"><a><i class="fa fa-user"></i> Compradores </a></router-link>
                    <li :class="{ active : isActive('/admin/settings') }">
                        <a href="#" aria-expanded="true"><i class="fa fa-cogs"></i> Sistema <span class="fa arrow fa-fw"></span></a>
                        <ul aria-expanded="true">
                            <router-link to="/admin/settings" tag="li"><a>Configurações</a></router-link>
                            <router-link to="/admin/users" tag="li"><a>Usuários</a></router-link>
                        </ul>
                    </li>
                </template>
                
                <template v-if="user.role === 'vendedor'">

                    <router-link :to="{name: 'orders.list'}" tag="li" exact><a><i class="fa fa-shopping-cart"></i> Minhas vendas </a></router-link>

                    <li :class="{ active : isActive('/admin/cardapio') }">
                        <a href="#" aria-expanded="true"><i class="fa fa-cutlery"></i> Cardapio <span class="fa arrow fa-fw"></span></a>
                        <ul aria-expanded="true">
                            <router-link to="/admin/cardapio/" tag="li" exact><a>Produtos cadastrados</a></router-link>
                            <router-link :to="{ name: 'cardapio-new' }" tag="li"><a>Adicionar novo produto</a></router-link>
                        </ul>
                    </li>
                    <li :class="{ active : isActive('/admin/settings') }">
                        <a href="#" aria-expanded="true"><i class="fa fa-cog"></i> Configurações <span class="fa arrow fa-fw"></span></a>
                        <ul aria-expanded="true">
                            <router-link to="/" tag="li" exact><a>Minha Página</a></router-link>
                            <router-link :to="{ name: 'settings-moip' }" tag="li"><a>Moip Pagamentos</a></router-link>
                        </ul>
                    </li>
                </template>

            </ul>
        </div>
    </div>
</template>

<script type="text/babel">
    // import Auth from '../../../services/auth'
    import Ls from '../../../services/ls'

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
            },
            setUser() {
                let user = Ls.get('auth.user');

                if (user !== null) {
                  this.user = JSON.parse(user);
                }
            }
        },
        created() {
            this.setUser()
        }

    }
</script>