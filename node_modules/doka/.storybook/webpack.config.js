// you can use this file to add your custom webpack plugins, loaders and anything you like.
// This is just the basic way to add addional webpack configurations.
// For more information refer the docs: https://goo.gl/qPbSyX

// IMPORTANT
// When you add this file, we won't add the default configurations which is similar
// to "React Create App". This only has babel loader to load JavaScript.
var baseConfig = require('../bin/config/webpack.base.js')
var webpack = require('webpack')

module.exports = Object.assign({},baseConfig,{
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
                loaders: [
                    'style-loader',
                    'css-loader'
                ]
            },{
                test: /\.less$/,
                loaders:[
                    'style-loader',
                    'css-loader',
                    'less-loader'
                ]
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
    plugins: [
        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: JSON.stringify(process.env.NODE_ENV || 'development')
            }
        })
       
    ]
})
