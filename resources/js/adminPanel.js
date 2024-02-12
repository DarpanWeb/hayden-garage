import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import adminPanel from './adminPanel.vue';
import showBookings from './showBookings.vue';
import disabledSlots from './disabledSlots.vue';

const routes = [
    { path: '/admin/show-bookings', component: showBookings },
    { path: '/admin/disable-slots', component: disabledSlots },
  ];
  
  const router = createRouter({
    history: createWebHistory(),
    routes
  });
  
  const app = createApp(adminPanel);
  app.use(router);
  app.mount('#adminPanel');