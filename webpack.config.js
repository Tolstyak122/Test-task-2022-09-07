const path = require('path');

module.exports = {
    module: {
        rules: [
            {
                test: /\.svg$/,
                use: [
                    'babel-loader',
                    'vue-svg-loader',
                ],
            },
            {
                test: /\.(postcss)$/,
                use: [
                  'vue-style-loader',
                  { loader: 'css-loader', options: { importLoaders: 1 } },
                  'postcss-loader'
                ]
            }
        ],
    },
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
    devServer: {
        host: 'localhost',
        port: 8080,
    },
};
