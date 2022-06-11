import Vue from 'vue'
import VueRouter from 'vue-router'
import i18n from '../i18n';

Vue.use(VueRouter)

const Routes = [
    {
        name:'login',
        path:'/login',
        component: () => import('../views/Login.vue' /* webpackChunkName: 'login' */),
        meta:{
            middleware: 'guest',
            title: `Login`
        }
    },
    {
        path:'/',
        component: () => import('../components/Layout.vue' /* webpackChunkName: 'layout' */),
        meta:{
            middleware: 'auth'
        },
        children:[
            {
                name: 'dashboard',
                path: '/',
                component: () => import('../views/Dashboard.vue' /* webpackChunkName: 'dashboard' */),
                meta:{
                    title: i18n.t('dashboard.title')
                }
            }
        ]
    }
]

const index  = new VueRouter({
    mode: 'history',
    routes: Routes
})

index.beforeEach((to, from, next) => {
    document.title = `${to.meta.title}`

    if(to.meta.middleware === 'guest'){
        if(localStorage.getItem('token')){
            next({ name: 'dashboard' })
        }
        next()
    }else{
        if(localStorage.getItem('token')){
            next()
        }else{
            next({ name: 'login' })
        }
    }
})

export default index
