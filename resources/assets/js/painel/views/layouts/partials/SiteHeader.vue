<template>
    <header class="site-header">
        <a href="#" class="brand-main">
            <img src="/assets/img/logo_white.png" id="logo-desk" alt="Mycook Logo" class="hidden-sm-down">
            <img src="/assets/img/logo-mobile.png" id="logo-mobile" alt="Mycook Logo" class="hidden-md-up">
        </a>

        <a href="#" class="nav-toggle" @click="onNavToggle">
            <div class="hamburger hamburger--htla">
                <span>toggle menu</span>
            </div>
        </a>

        <ul class="action-list">
            <li>
                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <router-link to="/admin/buyers/new">Novo comprador</router-link>
                    <router-link to="/admin/sellers/new">Novo vendedor</router-link>
                    <div class="dropdown-divider"></div>
                    <router-link to="/admin/users/new">Novo administrador</router-link>
                </div>
            </li>
            <li>
                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i></a>
                <div class="dropdown-menu dropdown-menu-right notification-dropdown">
                    <h6 class="dropdown-header">Notifications</h6>
                    <a class="dropdown-item" href="#"><i class="fa fa-user"></i> New User was Registered</a>
                    <a class="dropdown-item" href="#"><i class="fa fa-comment"></i> A Comment has been posted.</a>
                </div>
            </li>
            <li>
                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="avatar"><img :src="user.avatar_full_url" alt="Avatar"></a>
                <div class="dropdown-menu dropdown-menu-right notification-dropdown">
                    <router-link class="dropdown-item" to="/admin/settings"><i class="fa fa-cogs"></i> Settings</router-link>
                    <a href="#" class="dropdown-item" @click.prevent="logout"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
            </li>
        </ul>
    </header>
</template>


<script type="text/babel">

    import Layout from '../../../helpers/layout'
    import Auth from '../../../services/auth'
    import Ls from '../../../services/ls'

    export default {
        data() {
            return {
              'header' : 'header',
              user: {}
            }
        },
        methods : {
            onNavToggle(){
                Layout.toggleSidebar()
            },
            logout(){
                Auth.logout().then(() => {
                    this.$router.replace('/login')
                })
            }
        },
      mounted() {
        let user = Ls.get('auth.user');

        if (user !== null) {
          this.user = JSON.parse(user);
        }
      }

    }
</script>