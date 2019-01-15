const path = require('path');
const HtmlWebPackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const FaviconsWebpackPlugin = require('favicons-webpack-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');

const isProd = 'production' === process.env.NODE_ENV;
const port = process.env.PORT || 8080;
const host = '0.0.0.0';
const paths = {
    dist: path.resolve(__dirname, 'dist'),
    public: path.resolve(__dirname, 'dist'),
    src: path.resolve(__dirname, 'src'),
};
const htmlPlugin = new HtmlWebPackPlugin({
    filename: 'index.html',
    template: path.resolve(paths.src, 'index.html'),
});
const cssPlugin = new MiniCssExtractPlugin({
    chunkFilename: 'build/css/chunk-[id].min.css?[chunkhash:8]',
    filename: 'build/css/[name].min.css?[chunkhash:8]',
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
const favIconPlugin = new FaviconsWebpackPlugin({
    background: '#000000',
    emitStats: false,
    icons: {
        android: true,
        appleIcon: true,
        appleStartup: true,
        coast: true,
        favicons: true,
        firefox: true,
        opengraph: true,
        twitter: true,
        windows: true,
        yandex: true,
    },
    inject: true,
    logo: path.resolve(paths.src, 'favicon.svg'),
    persistentCache: false,
    prefix: 'build/icons/',
    title: 'analyzer',
});
let plugins = [cssPlugin, htmlPlugin, favIconPlugin, optimizePlugin];

if (isProd) {
    plugins = [new CleanWebpackPlugin([path.resolve(paths.dist, 'build/*')])].concat(plugins);
}

function getCssLoader(options = {}, loaders = []) {
    return [isProd ? MiniCssExtractPlugin.loader : 'style-loader', {loader: 'css-loader', options}, 'postcss-loader', ...loaders];
}

module.exports = {
    context: path.resolve(__dirname),
    devServer: {
        contentBase: paths.public,
        disableHostCheck: true,
        historyApiFallback: true,
        host,
        port,
    },
    devtool: isProd ? 'source-map' : 'cheap-module-source-map',
    entry: {
        main: ['./src/styles.less', './src/index.jsx'],
    },
    module: {
        rules: [
            {
                exclude: /node_modules/,
                test: /\.(js|jsx)$/,
                use: ['babel-loader'],
            },
            {
                test: /\.css$/,
                use: getCssLoader({
                    importLoaders: 1,
                    sourceMap: true,
                }),
            },
            {
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
                            },
                        },
                    ],
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
                            name: 'build/fonts/[hash:8].[ext]',
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
                        name: 'build/images/[hash:8].[ext]',
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
        chunkFilename: 'build/js/chunk-[id].min.js?[chunkhash:8]',
        filename: 'build/js/[name].min.js?[chunkhash:8]',
        path: paths.dist,
        publicPath: '/',
    },
    plugins,
    resolve: {
        extensions: ['*', '.js', '.jsx'],
        modules: [paths.src, 'node_modules'],
    },
    watchOptions: {
        aggregateTimeout: 700, // The default
    },
};
