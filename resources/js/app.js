import { createApp } from 'vue';
import App from './app.vue';
import { createRouter, createWebHistory } from 'vue-router';
import adminPanel from './adminPanel.vue';
import bookingForm from './bookingForm.vue';

const routes = [
    { path: '/admin', component: adminPanel },
    { path: '/book-slots', component: bookingForm },
];

const router = createRouter({
    history: createWebHistory(),
    routes 
});

const app = createApp(App);
app.use(router);
app.mount('#app');
