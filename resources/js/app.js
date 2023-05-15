require('./bootstrap');

// Import modules...

import Vue from 'vue';
import { InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';
//add these two line

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import VueSlimScroll from 'vue-slimscroll';  
import { InertiaProgress } from '@inertiajs/progress';  
import 'font-awesome/css/font-awesome.min.css' 
import * as VueSpinnersCss from "vue-spinners-css";
import VueApexCharts from 'vue-apexcharts'
import moment from 'moment';
import VueCompositionAPI from '@vue/composition-api'
import JsonExcel from "vue-json-excel";
import VueEllipseProgress from 'vue-ellipse-progress';
import * as faceapi from 'face-api.js';
Vue.prototype.$faceapi = faceapi;
// import '@mdi/font/css/materialdesignicons.css';
Vue.use(VueEllipseProgress);
Vue.component("downloadExcel", JsonExcel);
Vue.use(VueCompositionAPI)
Vue.use(VueApexCharts)
Vue.use(VueSpinnersCss)
InertiaProgress.init()
Vue.use(VueSlimScroll);
Vue.component('apexchart', VueApexCharts)


Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
//also add this line
Vue.use(Vuetify);

const app = document.getElementById('app');        

new Vue({ 
     //finally add this line 
    vuetify: new Vuetify(), 
render: (h) =>
    h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        },
    }),
    }).$mount(app);
