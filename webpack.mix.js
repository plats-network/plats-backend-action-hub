const mix = require('laravel-mix');
const glob = require('glob');
const path = require('path');

mix.options({
    processCssUrls : false,
    //publicPath: 'public/static/'
}).disableNotifications();

if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: 'inline-source-map'
    }).sourceMaps();
}
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
let resourcePath = 'resources/assets/';
let publicPath = 'public/static/';

// Admin path variables
let resourcePath_admin = resourcePath + 'admin/';
let js_path_admin = publicPath + 'js/admin';
let css_path_admin = publicPath + 'css/admin';
/*
 |--------------------------------------------------------------------------
 | Admin Controller Assets
 |--------------------------------------------------------------------------
 */

mix
    .sass(resourcePath_admin + 'scss/vendor.scss', css_path_admin)
    .sass(resourcePath_admin + 'scss/template.scss', css_path_admin)
    .sass(resourcePath_admin + 'scss/custom.scss', css_path_admin);

mix
    .js(resourcePath_admin + 'js/vendor.js', js_path_admin)
    .js(resourcePath_admin + 'js/app.js', js_path_admin)
/*
 |--------------------------------------------------------------------------
 | Make file of single page
 |--------------------------------------------------------------------------
 */
// ['admin'].forEach($path => {
let $path = 'admin';
// Js pages (single page use)
(glob.sync(resourcePath + $path + '/js/pages/!(_)*.js') || []).forEach(file => {
    let fileName = path.basename(file);
    mix.js(file, publicPath + '/js/' + $path + '/pages/' + fileName);
});
// Css pages (single page use)
(glob.sync(resourcePath + $path + '/scss/pages/!(_)*.scss') || []).forEach(file => {
    let fileName = path.basename(file.replace(/\.scss$/, '.css'));
    mix.sass(file, publicPath + '/css/' + $path + '/pages/' + fileName);
});
// });

mix.version();
