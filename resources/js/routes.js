import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Articles from './pages/articles/index';
import Login from './pages/Login';

let routes = [
    { path: '/', component: Articles , name: 'Articles', meta: { auth: true} },
    { path: '/login', component: Login , name: 'Login' },
];

// default
routes.push(
    { path: '*', component:  require('./pages/404.vue').default }
);

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    routes: routes
});

router.beforeEach((to, from, next) => {
    var withToken = localStorage.getItem('bearer_token');
    if (to.matched.some(record => record.meta.auth)) {
        if (!withToken) {
            next({
                path: '/login'
            });
        } else {
            next();
        }
    } else if (['/login'].includes(to.path) && withToken) {
        next({
            path: '/'
        });
    } else {
        next();
    }
});

export default router;