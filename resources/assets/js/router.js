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
import UsersDelete from './views/admin/users/delete.vue'

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

        //Admin
        {
            path: 'admin/users',
            component: Users,
            name: 'users-list',
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