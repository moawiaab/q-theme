import './bootstrap';
// import '../css/app.css';

import { createApp, h } from 'vue';
import { Head, Link, createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';


import quasarLangAr from 'quasar/lang/ar'

import { createI18n } from 'vue-i18n'
//Quasar
import { Quasar, Notify } from "quasar";
import quasarIconSet from "quasar/icon-set/mdi-v7";

// Import icon libraries
import "@quasar/extras/material-icons/material-icons.css";
import "@quasar/extras/mdi-v7/mdi-v7.css";

// Import Quasar css
import "quasar/src/css/index.sass";
import "../sass/custom.scss"

import DataTable  from "@/Components/tables/data.vue"
import Loader  from "@/Components/loader.vue"
import ActionMessage from "@/Components/ActionMessage.vue";


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

import messages from './i18n'
// import messages from '@intlify/vite-plugin-vue-i18n/messages'
const i18n = createI18n({
    locale: "ar",
    legacy : false,
    globalInjection: true,
    allowComposition: true,
    messages
})

import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
        .use(pinia)
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .use(Quasar, {

                plugins: { Notify }, // import Quasar plugins and add here
                lang: quasarLangAr,
                iconSet: quasarIconSet,
                build: {
                    rtl: true
                },
                config: {
                    notify: { position: "top" },
                },
            })
            .component('h-title', Head)
            .component('v-link', Link)
            .component('DataTable', DataTable)
            .component('Loader', Loader)
            .component('a-message', ActionMessage)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
