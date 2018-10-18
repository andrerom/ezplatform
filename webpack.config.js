// webpack.config.default.js
const Encore = require('@symfony/webpack-encore');
//const Webpack = require('webpack'); // eslint-disable-line import/no-extraneous-dependencies
//const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

//Encore.reset();

/*const siteConfig = {
  name: 'default',
  buildLocation: Encore.isProduction() ? 'build' : 'build_dev'
  //resourcesLocation: 'src/Netgen/Bundle/MoreDemoBundle/Resources',
};*/



Encore
    // the project directory where all compiled assets will be stored
    .setOutputPath(`./web/build/`)

    // the public path used by the web server to access the previous directory
    .setPublicPath(`/build`)

    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())

    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();

