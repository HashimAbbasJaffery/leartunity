
let mix = require('laravel-mix');

// const { assertSupportedNodeVersion } = require('../src/Engine');

module.exports = async () => {
    // @ts-ignore
    process.noDeprecation = true;


    const mix = require('../src/Mix').primary;

    require(mix.paths.mix());

    await mix.installDependencies();
    await mix.init();

    return mix.build();
};

mix.js('resources/js/app.js', 'public/js')
    .vue(3)
    .babelConfig({
        presets: ['@babel/preset-env'],
    })
    .postCss('resources/css/app.css', 'public/css', [

    ])
    .version();
