const path = require('path');
const HtmlWebPackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
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
let plugins = [cssPlugin, htmlPlugin, optimizePlugin];

if (isProd) {
    plugins = [new CleanWebpackPlugin([path.resolve(paths.dist, 'build/*')])].concat(plugins);
}

function getCssLoader(options = {}, loaders = []) {
    return [isProd ? MiniCssExtractPlugin.loader : 'style-loader', {loader: 'css-loader', options}, 'postcss-loader', ...loaders];
}

const cssLocalIdentName = isProd ? '[hash:base64]' : '[path][name]__[local]--[hash:base64:8]';

module.exports = {
    context: paths.src,
    devServer: {
        contentBase: paths.public,
        disableHostCheck: true,
        historyApiFallback: true,
        host,
        port,
    },
    devtool: isProd ? 'source-map' : 'cheap-module-source-map',
    entry: {
        main: ['./index.less', './index'],
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