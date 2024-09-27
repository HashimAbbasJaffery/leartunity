import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue"
import i18n from 'laravel-vue-i18n/vite';

export default defineConfig({
    plugins: [
        vue(),
        i18n(
            {
                lang: 'en',
                additionalLangPaths: [
                    'public/locales'
                ]
            }
        ),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        "@vue/babel-plugin-jsx",
    ],
    esbuild: {
        jsxFactory: 'h',
        jsxFragment: 'Fragment'
    }
});
