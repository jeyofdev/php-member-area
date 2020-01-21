const webpack = require('webpack')
const path = require('path')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')


// plugins
const plugins = {
    extractCss: require('mini-css-extract-plugin'),
    html: require('html-webpack-plugin'),
    Manifest: require('webpack-manifest-plugin'),
    styleLint: require('stylelint-webpack-plugin'),
    copy: require('copy-webpack-plugin')
}


// the loaders to the css
let cssLoaders = [
    { 
        loader: plugins.extractCss.loader,
        options: {
            publicPath: '../',
        }
    },
    { loader: 'css-loader', options: { importLoaders: 1 } },
    'resolve-url-loader',
]



module.exports = (env, argv) => {
    // check that we are in development or production mode
    let dev = env.development ? true : false

    // apply postcss-loader only in production mode
    if (!dev) { cssLoaders.push('postcss-loader') }

    let config = {
        entry: {
            app: [
                './assets/js/app.js',
                './assets/scss/app.scss'
            ]
        },
        output: {
            path: path.resolve(__dirname, './public/assets/'),
            publicPath: (dev ? 'http://localhost:8080' : '') + '/assets/',
            filename: (dev) ? 'js/[name].js' : 'js/[name]-[hash:8].js'
        },
        devtool: (dev) ? 'source-map' : 'cheap-module-eval-source-map',
        resolve: {
            alias: {
                '@js': path.resolve(__dirname, './assets/js/'),
                '@scss': path.resolve(__dirname, './assets/scss/')
            }
        },
        watch: dev,
        devServer: {
            port: 8080,
            overlay: true,
            contentBase: path.resolve(__dirname, './public'),
            headers: {
                "Access-Control-Allow-Origin": "*",
                "Access-Control-Allow-Methods": "GET, POST, PUT, DELETE, PATCH, OPTIONS",
                "Access-Control-Allow-Headers": "X-Requested-With, content-type, Authorization"
            } 
        },
        module: {
            rules: [
                {
                    enforce: 'pre',
                    test: /\.js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: {
                        loader: 'eslint-loader'
                    }
                },
                {
                    test: /\.js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: {
                        loader: 'babel-loader'
                    }
                },
                {
                    test: /\.css$/,
                    use: cssLoaders
                },
                {
                    test: /\.scss$/,
                    use: [
                        ...cssLoaders,
                        'sass-loader'
                    ]
                },
                {
                    test: /\.(png|jpe?g|gif|svg)$/i,
                    use: [
                        {
                            loader: 'url-loader',
                            options: {
                                limit: 8192,
                                name: (dev) ? 'img/[name].[ext]' : 'img/[name]-[hash:8].[ext]'
                            }
                        },
                        {
                            loader: 'image-webpack-loader',
                            options: {
                                    bypassOnDebug: dev,
                                    mozjpeg: {
                                    progressive: true,
                                    quality: 65
                                },
                                optipng: {
                                    enabled: false
                                },
                                pngquant: {
                                    quality: [0.65, 0.90],
                                    speed: 4
                                },
                                gifsicle: {
                                    interlaced: false
                                }
                            }
                        }
                    ]
                },
                {
                    test: /\.(woff2?|eot|ttf|otf)$/,
                    use: [
                        {
                            loader: 'file-loader',
                            options: {
                                name: (dev) ? 'fonts/[name].[ext]' : 'fonts/[name]-[hash:8].[ext]'
                            }
                        }
                    ]
                },
                {
                    test: /\.(html)$/,
                    use: {
                        loader: 'html-loader',
                        options: {
                        minimize: !dev,
                        removeComments: !dev
                        }
                    }
                }
            ]
        },
        plugins: [
            new CleanWebpackPlugin({
                dry: false,  // set to true to verify that the correct files are targeted
                verbose: true,
            }),
            new plugins.extractCss({
                filename: (dev) ? 'css/[name].css' : 'css/[name]-[hash:8].css'
            }),
            new plugins.styleLint()
        ]
    }

    if(!dev){
        config.plugins.push(new plugins.Manifest({
            fileName: 'manifest.json'
        }))
    }

    return config
}