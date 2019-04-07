var path = require('path');
var webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const MinifyPlugin = require("babel-minify-webpack-plugin");
const CompressionPlugin = require("compression-webpack-plugin");
var tran = process.hrtime()[1];
if (process.env.NODE_ENV === 'css_js') {
    process.noDeprecation = true;
    module.exports = {
        entry: {
            'external.bundle.css': [
                path.resolve(__dirname, 'public/css/font-awesome.css'),
                path.resolve(__dirname, 'public/css/bulma.css'),
                path.resolve(__dirname, 'public/css/main.css'),
                path.resolve(__dirname, 'public/css/select2.edit.css'),
            ],
            'external.bundle.js': [
                "jquery",
                path.resolve(__dirname, 'public/js/select2.min.js'),
                path.resolve(__dirname, 'index.js'),
            ]
        },
        output: {
            filename: '[name]',
            path: path.resolve(__dirname, 'public', 'home'),
            chunkFilename: `lazy.${tran}.[hash].[name]`,
        },
        module: {
            rules: [
                {
                    test: /\.css$/,
                    use: ExtractTextPlugin.extract({
                        fallback: 'style-loader',
                        use: [{
                            loader: "css-loader",
                            options: {
                                url: false,
                                minimize: true,
                            }
                        },],
                    })
                },
                {
                    test: /\.sass$/,
                    use: ExtractTextPlugin.extract({
                        fallback: 'style-loader',
                        use: [{
                            loader: "css-loader",
                            options: {
                                url: false,
                                minimize: true,
                            }
                        },
                            {
                                loader: "sass-loader"
                            }
                        ]
                    })
                },
                {
                    test: /\.less$/,
                    use: ExtractTextPlugin.extract({
                        fallback: 'style-loader',
                        use: [{
                            loader: "css-loader",
                            options: {
                                url: false,
                                minimize: true,
                            }
                        },
                            {
                                loader: "less-loader"
                            }
                        ]
                    })
                },
                {
                    test: /\.js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: {
                        loader: 'babel-loader',
                        options: {}
                    }
                },
            ],
        },
        plugins: [
            new ExtractTextPlugin("external.bundle.css"),
            new MinifyPlugin({}, {})
        ]
    }; //css
    module.exports.devtool = '#source-map'
    module.exports.plugins = (module.exports.plugins || []).concat([
        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: '"production"'
            }
        }),
        new webpack.optimize.UglifyJsPlugin({
            minimize: true,
            sourceMap: true,
            compress: {
                warnings: false
            }
        }),
        new webpack.LoaderOptionsPlugin({
            minimize: true
        })
    ]);
    //css minify
} else if (process.env.NODE_ENV === 'development') {
    var type = process.env.DEV.toLowerCase();
    var entries = {
        general: path.resolve(__dirname, 'vue', 'starter', 'mainGeneral.js'),
        admin: path.resolve(__dirname, 'vue', 'starter', 'mainAdmin.js'),
        user: path.resolve(__dirname, 'vue', 'starter', 'mainUser.js'),
    };
    console.log('Type => ', type);
    console.log('Set Entry Path => ', entries[type]);
    module.exports = {
        entry: entries[type],
        output: {
            path: path.resolve(__dirname, 'public', 'js'),
            filename: 'bundle.js',
            chunkFilename: `[name].lazy.[hash].${tran}.js`,
            publicPath: '/public/'
        },
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                    options: {
                        loaders: {
                            sass: [
                                'vue-style-loader',
                                'css-loader',
                                'sass-loader?indentedSyntax=1',
                                {
                                    loader: 'sass-resources-loader',
                                    options: {
                                        resources: [path.resolve(__dirname, 'public', 'css', 'main.scss')]
                                    },
                                },
                            ],
                            scss: [
                                'vue-style-loader',
                                'css-loader',
                                'sass-loader',
                                {
                                    loader: 'sass-resources-loader',
                                    options: {
                                        resources: [path.resolve(__dirname, 'public', 'css', 'main.scss')]
                                    },
                                },
                            ],
                        },
                    },
                },
                {
                    test: /\.css$/,
                    loader: 'style-loader!css-loader'
                },
                {
                    test: /\.js$/,
                    loader: 'babel-loader',
                    exclude: /(node_modules)/
                },
                {
                    test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
                    loader: 'url-loader',
                    exclude: /(node_modules)/
                },
                {
                    test: /\.(mp4|webm|ogg|mp3|wav|flac|aac)(\?.*)?$/,
                    exclude: /(node_modules)/,
                    loader: 'url-loader',
                },
                {
                    test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
                    exclude: /(node_modules)/,
                    loader: 'url-loader',
                },
                {
                    test: /\.(png|jpg|gif|svg)$/,
                    loader: 'file-loader',
                    exclude: /(node_modules)/,
                    options: {
                        name: '[name].[ext]?[hash]'
                    }
                },
                {
                    test: /\.scss$/,
                    loader: ["style", "css?sourceMap", "sass?sourceMap"],
                    exclude: /(node_modules)/
                }
            ]
        },
        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.esm.js',
                '@cus-com': path.resolve(__dirname, 'vue/customize-components'),
                '@com': path.resolve(__dirname, 'vue/components'),
                '@store': path.resolve(__dirname, 'vue/stores'),
                '@route': path.resolve(__dirname, 'vue/routes'),
                '@vue': path.resolve(__dirname, 'vue'),
                '@bases': path.resolve(__dirname, 'vue', 'components', 'Bases'),
            }
        },
        devServer: {
            historyApiFallback: true,
            noInfo: true,
        },
        performance: {
            hints: false
        },
        devtool: '#eval-source-map'
    }
} else {//production config
    module.exports = {
        entry: {
            general: path.resolve(__dirname, 'vue', 'starter', 'mainGeneral.js'),
            admin: path.resolve(__dirname, 'vue', 'starter', 'mainAdmin.js'),
            user: path.resolve(__dirname, 'vue', 'starter', 'mainUser.js'),
        },
        output: {
            path: path.resolve(__dirname, 'public', 'js'),
            filename: '[name].bundle.js',
            chunkFilename: `[name].lazy.[hash].${tran}.js`,
            publicPath: './js/',
        },
        module: {
            loaders: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                    exclude: /(node_modules)/,
                    options: {
                        loaders: {
                            sass: [
                                'vue-style-loader',
                                'css-loader',
                                'sass-loader?indentedSyntax=1',
                                {
                                    loader: 'sass-resources-loader',
                                    options: {
                                        resources: [path.resolve(__dirname, 'public', 'css', 'main.scss')]
                                    },
                                },
                            ],
                            scss: [
                                'vue-style-loader',
                                'css-loader',
                                'sass-loader',
                                {
                                    loader: 'sass-resources-loader',
                                    options: {
                                        resources: [path.resolve(__dirname, 'public', 'css', 'main.scss')]
                                    },
                                },
                            ],
                        },
                    },
                },
                {
                    test: /\.css$/,
                    loader: 'style-loader!css-loader',
                },
                {
                    test: /\.js$/,
                    loader: 'babel-loader',
                    exclude: /(node_modules)/
                },
                {
                    test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
                    loader: 'url-loader',
                    exclude: /(node_modules)/
                },
                {
                    test: /\.(mp4|webm|ogg|mp3|wav|flac|aac)(\?.*)?$/,
                    exclude: /(node_modules)/,
                    loader: 'url-loader',
                },
                {
                    test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
                    exclude: /(node_modules)/,
                    loader: 'url-loader',
                },
                {
                    test: /\.(png|jpg|gif|svg)$/,
                    loader: 'file-loader',
                    exclude: /(node_modules)/,
                    options: {
                        name: '[name].[ext]?[hash]'
                    }
                },
                {
                    test: /\.scss$/,
                    loader: ["style", "css?sourceMap", "sass?sourceMap"],
                    exclude: /(node_modules)/
                },
            ]
        },
        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.esm.js',
                '@cus-com': path.resolve(__dirname, 'vue/customize-components'),
                '@com': path.resolve(__dirname, 'vue/components'),
                '@store': path.resolve(__dirname, 'vue/stores'),
                '@route': path.resolve(__dirname, 'vue/routes'),
                '@vue': path.resolve(__dirname, 'vue'),
                '@bases': path.resolve(__dirname, 'vue', 'components', 'Bases'),
            }
        },
        devServer: {
            historyApiFallback: true,
            noInfo: true
        },
        performance: {
            hints: false
        },
        devtool: '#eval-source-map'
    };
    if (process.env.NODE_ENV === 'production') {
        module.exports.devtool = '#source-map'
        // http://vue-loader.vuejs.org/en/workflow/production.html
        module.exports.plugins = (module.exports.plugins || []).concat([
            new webpack.DefinePlugin({
                'process.env': {
                    NODE_ENV: '"production"'
                }
            }),
            new webpack.optimize.UglifyJsPlugin({
                minimize: true,
                sourceMap: true,
                compress: {
                    warnings: false
                },
                output: {
                    comments: false,
                },
                exclude: [/\.min\.js$/gi] // skip pre-minified libs
            }),
            new webpack.LoaderOptionsPlugin({
                minimize: true
            }),
            new webpack.NoEmitOnErrorsPlugin(),
            new CompressionPlugin({
                asset: "[path].gz[query]",
                algorithm: "gzip",
                test: /\.vue$|\.js$|\.css$|\.html$/,
                threshold: 10240,
                minRatio: 0
            })
        ])
    }
}
