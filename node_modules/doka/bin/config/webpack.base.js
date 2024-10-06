var webpack = require('webpack')
var ExtractTextPlugin = require('extract-text-webpack-plugin');
var rucksack = require('rucksack-css')
var path = require('path')
var _ = require('lodash')
var pkg = require('../../package.json')


module.exports = {
    output: {
        library:_.capitalize(_.camelCase(pkg.name)),
        libraryTarget: 'umd'
    },
    plugins: [
        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: JSON.stringify(process.env.NODE_ENV || 'development')
            }
        })
    ],

    resolve: {
        extensions: ['', '.js', '.jsx'],
        alias: require('../alias')
    },
    module: {
        loaders: [
            {
                test: /\.html$/,
                loader: 'file?name=[name].[ext]'
            }, {
                test: /\.htm$/,
                loaders: ['string-loader']
            }, {
                test: /\.css$/,
                loader: ExtractTextPlugin.extract('style', 'css-loader')
            },{
                test: /\.less$/,
                loader:ExtractTextPlugin.extract('style', 'css-loader!less-loader')
            }, {
                test: /\.(png|woff|woff2|eot|ttf|svg|gif)/,
                loaders: ['url?limit=100000,img?minimize']
            }, {
                test: /\.(js|jsx)$/,
                exclude: /node_modules/,
                loaders: [
                    'babel-loader'
                ]
            }
        ]
    },
    postcss: function () {
        return [
            rucksack({
                autoprefixer: true
            })
        ]
    }
};