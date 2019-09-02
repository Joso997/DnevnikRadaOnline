require('./bootstrap');
window.Vue = require('vue');

import App from './App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import {routes} from './routes';
import VueCookie from 'vue-cookie';
import VueGraph from 'vue-graph';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/index.css';


Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(VueCookie);
Vue.use(VueGraph);
Vue.use(VueToast);


const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});