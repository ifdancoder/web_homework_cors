import './bootstrap';
import router from './vue/routes.js';
import store from './vue/store';
import App from './vue/App.vue';
import { createApp, h } from 'vue';

let vue = createApp({
    render: () => h(App),
    devtools: true,
  })
vue.config.devtools = true;
vue.use(router).use(store).mount('#app');
