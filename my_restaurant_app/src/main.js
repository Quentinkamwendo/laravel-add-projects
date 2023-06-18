import { createApp } from 'vue'
import 'vue-toast-notification/dist/theme-sugar.css';
import App from './App.vue'
import store from "@/stores/store";

import '../public/css/index.css'
// eslint-disable-next-line no-unused-vars
import router from './router'

createApp(App)
    .use(router)
    .use(store)
    .mount('#app')

