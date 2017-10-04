import Vue from 'vue'
import VueRouter from 'vue-router'

import AuthService from './services/auth'
import Ls from './services/ls'

/*
 |--------------------------------------------------------------------------
 | Admin Views
 |--------------------------------------------------------------------------|
 */

//Dashboard
import Basic from './views/admin/dashboard/Basic.vue'

import AddressesNew from './views/admin/addresses/new.vue'

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

//Painel Vendedor
import Cardapio         from './views/admin/cardapio/index.vue'
import CardapioNew      from './views/admin/cardapio/new.vue'
import CardapioEdit     from './views/admin/cardapio/edit.vue'
import CardapioDelete   from './views/admin/cardapio/delete.vue'

import StockEdit from './views/admin/stock/edit.vue'

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

        //Address
        {
          path: 'admin/address/new/:user_id/:user_role',
          component: AddressesNew,
          name: 'address-new',
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

        //Admin - Cardapio
        {
            path: 'admin/cardapio/:id?',
            component: Cardapio,
            name: 'cardapio-list',
        },
        {
            path: 'admin/cardapio/:id?/new/',
            component: CardapioNew,
            name: 'cardapio-new',
        },
        {
            path: 'admin/cardapio/:id/edit',
            component: CardapioEdit,
            name: 'cardapio-edit',
        },
        {
            path: 'admin/cardapio/:id/delete',
            component: CardapioDelete,
            name: 'cardapio-delete',
        },
        {
            path: 'admin/stock/edit/:id/:sellerid',
            component: StockEdit,
            name: 'stock-edit',
            beforeEnter: (to, from, next) => {
                let user = JSON.parse(Ls.get('auth.user'));
                // Estou protegendo a rota para não acessar dados de outro vendedor
                if (to.params.sellerid != user.seller.id){
                    //Se for diferente encaminho para a pagina correta
                    return next({ path : 'admin/stock/edit/'+ to.params.id +'/'+ user.seller.id})
                }

                return next()

            }
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
        },
        {
            path: 'admin/settings',
            component: require('../painel/views/admin/Settings.vue'),
            name: 'system-settings'
        },
        // Categorias
        {
            path: 'admin/categories',
            component: require('../painel/views/admin/categories/Index.vue'),
            name: 'system-categories'
        },
        {
            path: 'admin/categories/new',
            component: require('../painel/views/admin/categories/New.vue'),
            name: 'system-categories-new'
        },
        {
            path: 'admin/categories/:id',
            component: require('../painel/views/admin/categories/Edit.vue'),
            name: 'system-categories-edit'
        },
        // Sellers - Orders
        {
            path: 'seller/orders',
            component: require('../painel/views/admin/orders/Index.vue'),
            name: 'orders.list'
        },
        {
            path: 'seller/orders/:id',
            component: require('../painel/views/admin/orders/Show.vue'),
            name: 'orders.view'
        },
        // Sellers - Moip
        {
            path: 'seller/settings/moip',
            component: require('../painel/views/admin/moip/Index.vue'),
            name: 'settings-moip',
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