import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import '@flaticon/flaticon-uicons/css/all/all.css';

const routes = [
    { path: '/home', component: () => import('./components/App.vue') },
    { path: '/signUp', component: () => import('./components/views/auth/signUp.vue') },
    { path: '/login', component: () => import('./components/views/auth/login.vue') },
    { path: '/refreshPassword', component: () => import('./components/views/auth/refreshPassword.vue') },
    { path: '/', component: () => import('./components/views/home.vue') }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('token');

    if (isAuthenticated && (to.path === '/login' || to.path === '/signUp' || to.path === '/refreshPassword')) {
        next({ path: '/home' });
    } else {
        next();
    }
});

export default router;

const app = createApp({});

app.use(router);

app.mount('#app');
