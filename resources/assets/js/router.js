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
            console.log(authenticated);
            if(!authenticated){
              return next({ path : '/login'})
            }

            return next()
        })
    }

    return next()
});

export default router