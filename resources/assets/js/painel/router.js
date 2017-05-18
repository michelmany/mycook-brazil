import Vue from 'vue'
import VueRouter from 'vue-router'

import AuthService from './services/auth'

/*
 |--------------------------------------------------------------------------
 | Admin Views
 |--------------------------------------------------------------------------|
 */

//Dashboard
import Basic from './views/admin/dashboard/Basic.vue'

import Users from './views/admin/users/index.vue'
import UsersView from './views/admin/users/view.vue'
import UsersEdit from './views/admin/users/edit.vue'
import UsersNew from './views/admin/users/new.vue'
import UsersDelete from './views/admin/users/delete.vue'

import Sellers from './views/admin/sellers/index.vue'
import SellersView from './views/admin/sellers/view.vue'
import SellersEdit from './views/admin/sellers/edit.vue'
import SellersNew from './views/admin/sellers/new.vue'
import SellersDelete from './views/admin/sellers/delete.vue'

import Buyers from './views/admin/buyers/index.vue'
import BuyersView from './views/admin/buyers/view.vue'
import BuyersEdit from './views/admin/buyers/edit.vue'
import BuyersNew from './views/admin/buyers/new.vue'
import BuyersDelete from './views/admin/buyers/delete.vue'

//Layouts
import LayoutBasic from './views/layouts/LayoutBasic.vue'
import LayoutLogin from './views/layouts/LayoutLogin.vue'

/*
 |--------------------------------------------------------------------------
 | Other
 |--------------------------------------------------------------------------|
 */

//Auth
import Login from './views/auth/Login.vue'
import Register from './views/auth/Register.vue'

import NotFoundPage from './views/errors/404.vue'

/*
 |--------------------------------------------------------------------------
 | Frontend Views
 |--------------------------------------------------------------------------|
 */

Vue.use(VueRouter)

const routes = [

    /*
     |--------------------------------------------------------------------------
     | Admin Backend Routes
     |--------------------------------------------------------------------------|
     */
    {
      path: '/', component: LayoutBasic,  // Change the desired Layout here
      meta: { requiresAuth: true },
      children: [

        //Dashboard
        {
            path: '',
            component: Basic,
            name: 'dashboard',
        },

        //Admin - Sellers
        {
            path: 'admin/sellers',
            component: Sellers,
            name: 'sellers-list',
        },
        {
            path: 'admin/sellers/new',
            component: SellersNew,
            name: 'sellers-new',
        },
        {
            path: 'admin/sellers/:id/ver',
            component: SellersView,
            name: 'sellers-view',
        },
        {
            path: 'admin/sellers/:id/edit',
            component: SellersEdit,
            name: 'sellers-edit',
        },
        {
            path: 'admin/sellers/:id/remove',
            component: SellersDelete,
            name: 'sellers-delete',
        },

        //Admin - Buyers
        {
            path: 'admin/buyers',
            component: Buyers,
            name: 'buyers-list',
        },
        {
            path: 'admin/buyers/new',
            component: BuyersNew,
            name: 'buyers-new',
        },
        {
            path: 'admin/buyers/:id/ver',
            component: BuyersView,
            name: 'buyers-view',
        },
        {
            path: 'admin/buyers/:id/edit',
            component: BuyersEdit,
            name: 'buyers-edit',
        },
        {
            path: 'admin/buyers/:id/remove',
            component: BuyersDelete,
            name: 'buyers-delete',
        },

        //Admin - Usuários
        {
            path: 'admin/users',
            component: Users,
            name: 'users-list',
        },
        {
            path: 'admin/users/new',
            component: UsersNew,
            name: 'users-new',
        },
        {
            path: 'admin/users/:id/ver',
            component: UsersView,
            name: 'users-view',
        },
        {
            path: 'admin/users/:id/edit',
            component: UsersEdit,
            name: 'users-edit',
        },
        {
            path: 'admin/users/:id/remove',
            component: UsersDelete,
            name: 'users-delete',
        }
      ]
    },

    {
      path: '/', component: LayoutLogin,  // Change the desired Layout here
      meta: { requiresAuth: false },
      children: [

        {
          path: 'login',
          component: Login,
          name: 'login'
        },
        {
          path: 'register',
          component: Register,
          name: 'register'
        },
      ]
    },

    /*
     |--------------------------------------------------------------------------
     | Auth & Registration Routes
     |--------------------------------------------------------------------------|
     */

    // DEFAULT ROUTE
    {   path: '*', component : NotFoundPage }
]

const router = new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active'
})

router.beforeEach((to, from, next) => {

    // If the next route is requires user to be Logged IN
    if (to.matched.some(m => m.meta.requiresAuth)){

        return AuthService.check().then(authenticated => {
            if(!authenticated){
              return next({ path : '/login'})
            }

            return next()
        })
    }

    return next()
});

export default router