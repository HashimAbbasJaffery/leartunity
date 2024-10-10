import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia';
import { i18nVue, trans } from 'laravel-vue-i18n';
import { createI18n } from 'vue-i18n';
import {ref, watch} from "vue"
import Layout from "../../resources/js/Shared/Layout.vue";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


import "./bootstrap.js";

const pinia = createPinia();
let isLoaded = ref(false);

const i18n = createI18n({
    locale: 'en',  // Set your default locale
    fallbackLocale: 'en',  // Fallback locale
    saveMissing: true,  // Enable saveMissing

  });

let app = createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
    setup({ el, App, props, plugin }) {

    const app = createApp({ render: () => h(App, props) })

        .use(plugin)
        .use(pinia)
        .use(VueSweetalert2)
        .component("Layout", Layout)
        .use(i18nVue, {
        lang: "en",
        globalInjection: true,
        resolve: lang => import(`../../lang/${lang}.json`),
        onLoad: () => isLoaded.value = true
        })
        .directive('translate', {
            mounted(el, binding, vnode) {
                watch(isLoaded, function() {
                    el.innerText = trans(binding.value || el.innerText);
                })
            }
        })

        .use(i18n);

        app.config.globalProperties.$route = route
        app.mount(el)
  },
})

