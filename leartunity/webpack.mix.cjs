
let mix = require('laravel-mix');
require('laravel-vue-i18n/mix');


// const { assertSupportedNodeVersion } = require('../src/Engine');

module.exports = async () => {
    // @ts-ignore
    process.noDeprecation = true;


    const mix = require('../src/Mix').primary;

    require(mix.paths.mix());
    mix.i18n();

    await mix.installDependencies();
    await mix.init();

    return mix.build();
};

mix.webpackConfig({
    resolve: {
        fallback: {
            fs: false,
            path: false
        },
        extensions: ["*",".wasm",".mjs",".js",".jsx",".json",".vue",".*", ".cjs"], // Adjust extensions if needed
    }
});
mix.js('resources/js/app.js', 'public/js')
    .i18n()
    .vue(3)
    .babelConfig({
        presets: ['@babel/preset-env'],
    })
    .postCss('resources/css/app.css', 'public/css', [

    ])
    .version();
