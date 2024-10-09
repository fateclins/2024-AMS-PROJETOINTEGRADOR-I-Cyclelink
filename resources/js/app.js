import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import '@flaticon/flaticon-uicons/css/all/all.css';

const routes = [
    { path: '/teste', component: () => import('./components/App.vue') },
    { path: '/signUp', component: () => import('./components/views/signUp.vue') }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp({});

app.use(router);

app.mount('#app');
