const path = require('path');
// const fs = require('fs');
// const HtmlWebPackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
// const lessToJs = require('less-vars-to-js');
// const FaviconsWebpackPlugin = require('favicons-webpack-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');

const isProd = 'production' === process.env.NODE_ENV;
// const port = process.env.PORT || 8080;
// const host = '0.0.0.0';
const paths = {
    build: path.resolve(__dirname, 'protected/assetsSource/dist/build'),
    dist: path.resolve(__dirname, 'protected/assetsSource/dist'),
    src: path.resolve(__dirname, 'protected/assetsSource/src'),
};

// const varsFile = fs.readFileSync(path.join(paths.src, './styles/variables.less'), 'utf8');
// const vars = lessToJs(varsFile, {stripPrefix: true});
//
// const antdVars = fs.readFileSync(path.join(paths.src, './styles/antd-variables.less'), 'utf8');
// const themeVariables = lessToJs(antdVars, {dictionary: vars, resolveVariables: true});

// const htmlPlugin = new HtmlWebPackPlugin({
//     filename: 'index.html',
//     template: path.resolve(paths.src, 'index.html'),
// });
const cssPlugin = new MiniCssExtractPlugin({
    chunkFilename: 'css/chunk-[id].min.css?[chunkhash:8]',
    filename: 'css/[name].min.css?[chunkhash:8]',
});
const optimizePlugin = new OptimizeCssAssetsPlugin({
    cssProcessorOptions: {
        autoprefixer: false,
        discardUnused: false,
        map: {
            inline: false,
        },
        mergeIdents: false,
        reduceIdents: false,
        safe: true,
        zIndex: false,
    },
});

// const favIconPlugin = new FaviconsWebpackPlugin({
//     background: '#fff',
//     emitStats: false,
//     icons: {
//         android: true,
//         appleIcon: true,
//         appleStartup: true,
//         coast: true,
//         favicons: true,
//         firefox: true,
//         opengraph: true,
//         twitter: true,
//         windows: true,
//         yandex: true,
//     },
//     inject: true,
//     logo: path.resolve(paths.src, 'favicon.svg'),
//     persistentCache: false,
//     prefix: 'icons/',
//     // statsFilename: 'iconstats.json',
//     title: 'Touch-TV',
// });

let plugins = [
    cssPlugin,
    // htmlPlugin,
    // favIconPlugin,
    optimizePlugin,
];

if (isProd) {
    plugins = [new CleanWebpackPlugin([path.resolve(paths.build, '*')])].concat(plugins);
}

function getCssLoader(options = {}, loaders = []) {
    return [isProd ? MiniCssExtractPlugin.loader : 'style-loader', {loader: 'css-loader', options}, 'postcss-loader', ...loaders];
}

const cssLocalIdentName = isProd ? '[hash:base64]' : '[path][name]__[local]--[hash:base64:8]';

module.exports = {
    context: paths.src,
    // devServer: {
    //     contentBase: paths.public,
    //     disableHostCheck: true,
    //     historyApiFallback: true,
    //     host,
    //     port,
    //     proxy: {
    //         '/api/v1/config': {
    //             changeOrigin: true,
    //             secure: false,
    //             target: 'http://touch-tv-front.local',
    //         },
    //     },
    // },
    devtool: isProd ? 'source-map' : 'cheap-module-source-map',
    entry: {
        main: ['./styles.less', './public.js'],
    },
    module: {
        rules: [
            {
                exclude: /node_modules/,
                test: /\.(js|jsx)$/,
                use: ['babel-loader'],
            },
            {
                exclude: /\.local\.css$/,
                test: /\.css$/,
                use: getCssLoader({
                    importLoaders: 1,
                    sourceMap: true,
                }),
            },
            {
                test: /\.local\.css$/,
                use: getCssLoader({
                    importLoaders: 1,
                    localIdentName: cssLocalIdentName,
                    modules: true,
                    sourceMap: true,
                }),
            },
            {
                exclude: /\.local\.less$/,
                test: /\.less$/,
                use: getCssLoader(
                    {
                        importLoaders: 1,
                        sourceMap: true,
                    },
                    [
                        {
                            loader: 'less-loader',
                            options: {
                                javascriptEnabled: true,
                                // modifyVars: themeVariables,
                            },
                        },
                    ]
                ),
            },
            {
                test: /\.local\.less$/,
                use: getCssLoader(
                    {
                        importLoaders: 1,
                        localIdentName: cssLocalIdentName,
                        modules: true,
                        sourceMap: true,
                    },
                    [
                        {
                            loader: 'less-loader',
                            options: {
                                javascriptEnabled: true,
                                // modifyVars: themeVariables,
                            },
                        },
                    ]
                ),
            },
            {
                test: /\.svg$/,
                use: ['svg-sprite-loader', 'svgo-loader'],
            },
            {
                test: /\.(woff2?|ttf|eot)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: 'fonts/[hash:8].[ext]',
                        },
                    },
                ],
            },
            {
                test: /\.(jpe?g|png|gif)$/,
                use: {
                    loader: 'url-loader',
                    options: {
                        limit: 5000,
                        name: 'images/[hash:8].[ext]',
                    },
                },
            },
        ],
    },
    optimization: {
        minimizer: [
            new UglifyJsPlugin({
                cache: true,
                parallel: true,
                sourceMap: true,
            }),
            new OptimizeCSSAssetsPlugin(),
        ],
        splitChunks: {
            cacheGroups: {
                commons: {
                    chunks: 'all',
                    name: 'vendors',
                    test: /[\\/]node_modules[\\/]/,
                },
            },
        },
    },
    output: {
        chunkFilename: 'js/chunk-[id].min.js?[chunkhash:8]',
        filename: 'js/[name].min.js?[chunkhash:8]',
        path: paths.build,
        publicPath: '../',
    },
    plugins,
    resolve: {
        extensions: ['*', '.js'],
        modules: [paths.src, 'node_modules'],
    },
    watchOptions: {
        aggregateTimeout: 700, // The default
    },
};
