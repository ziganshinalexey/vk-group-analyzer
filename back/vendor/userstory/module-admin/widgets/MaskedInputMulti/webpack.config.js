var ISDEV = 'production' !== process.env.NODE_ENV;

var path = require('path');
var webpack = require('webpack');

var ExtractTextPlugin = require('extract-text-webpack-plugin');
var SvgStore = require('webpack-svgstore-plugin');
var CleanWebpackPlugin = require('clean-webpack-plugin');

var extractCSS = new ExtractTextPlugin({filename: '[name].min.css', disable: false, allChunks: true});

var paths = {
    src: path.join(__dirname, './assetsSource'),
    build: path.join(__dirname, './www/build/')
};

module.exports = {
    context: paths.src,
    entry: {
        'jquery.maskedinput-multi': './index'
    },
    output: {
        path: paths.build,
        filename: '[name].min.js',
        publicPath: './'
    },
    externals: {
        jquery: 'jQuery',
        $: 'jQuery'
    },
    module: {
        rules: [
            {
                test: /\.(js|es)$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'babel-loader',
                        query: {
                            cacheDirectory: true
                        }
                    }
                ]
            },
            {
                test: /\.less/,
                use: extractCSS.extract({
                    fallback: 'style-loader',
                    use: [
                        'css-loader',
                        'postcss-loader',
                        'less-loader'
                    ]
                })
            },
            {
                test: /\.css$/,
                use: extractCSS.extract({
                    fallback: 'style-loader',
                    use: [
                        'css-loader',
                        'postcss-loader'
                    ]
                })
            },
            {
                test: /\.(ttf|eot|svg|woff(2)?)(\?[a-z0-9=&.]+)?$/,
                use: {
                    loader: 'url-loader',
                    query: {
                        limit: 5000,
                        name: 'font/[hash:10].[ext]?[hash:4]'
                    }
                }
            },
            {
                test: /.*\.(jpe?g|png|gif|svg)$/i,
                use: {
                    loader: 'url-loader',
                    query: {
                        limit: 5000,
                        name: 'images/[hash:10].[ext]?[hash:4]'
                    }
                }
            }
        ]
    },
    devtool: ISDEV ? 'inline-source-map' : false,
    watchOptions: {
        aggregateTimeout: 100
    },
    resolve: {
        alias: {
            app: paths.src
        },
        extensions: ['.js', '.es'],
        modules: [
            paths.src,
            'node_modules'
        ]
    },
    plugins: [
        new webpack.NoEmitOnErrorsPlugin(),
        // new webpack.optimize.CommonsChunkPlugin({
        //     name: 'common',
        //     minChunks: 2,
        //     filename: '[name].min.js',
        // }),
        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: ISDEV ? 'development' : 'production'
            }
        }),
        new SvgStore({
            prefix: '',
            svgOptions: {
                // options for svgo
                plugins: [
                    {
                        removeTitle: true,
                        sortAttrs: true
                    }
                ]
            }
        }),
        extractCSS
    ]
};

if (!ISDEV) {
    module.exports.plugins.push(new CleanWebpackPlugin(['*'], {
        root: paths.build,
        verbose: true,
        dry: false
    }));
}