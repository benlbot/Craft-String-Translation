let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

mix.js('src/assetbundles/src/js/stringtranslation.js', 'src/assetbundles/dist/js')
    .sass('src/assetbundles/src/sass/stringtranslation.scss', 'src/assetbundles/dist/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.js') ],
    })
    .copy('src/assetbundles/src/img/', 'src/assetbundles/dist/img/');