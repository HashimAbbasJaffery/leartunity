import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia';
import { i18nVue, trans } from 'laravel-vue-i18n';
import { createI18n } from 'vue-i18n';
import {ref, watch} from "vue"
import Layout from "../../resources/js/Shared/Layout.vue";

import "./bootstrap.js";

const pinia = createPinia();
let isLoaded = ref(false);

const i18n = createI18n({
    locale: 'ur',  // Set your default locale
    fallbackLocale: 'en',  // Fallback locale
    saveMissing: true,  // Enable saveMissing
    missing: async (locale, key) => {
      try {
        await axios.post('/api/log-missing-translation', {
          locale: locale,
          key: key,
          message: key,  // Log the key or a default message
        });
      } catch (error) {
        console.error('Failed to log missing translation:', error);
      } finally {
        console.log(key)
      }
    }
  });

let app = createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
    setup({ el, App, props, plugin }) {

    createApp({ render: () => h(App, props) })

      .use(plugin)
      .use(pinia)
      .component("Layout", Layout)
      .use(i18nVue, {
        lang: "ur",
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

        .use(i18n)
      .mount(el)
  },
})

