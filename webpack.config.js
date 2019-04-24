var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/lib/')
    .setPublicPath('/lib')

    .copyFiles({
        from: './assets/img',
        to: 'img/[path][name].[hash:8].[ext]',
        pattern: /\.(png|jpg|gif)$/
    })

    .addEntry('app', './assets/js/app.js')

    .splitEntryChunks()

    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3
    })

    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
