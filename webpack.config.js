const path = require("path");

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CopyPlugin = require("copy-webpack-plugin");
var ZipPlugin = require('zip-webpack-plugin');

module.exports = {
    mode: "development",
    entry: {
        main: "./src/js/main.js",
        vendors: "./src/js/vendors.js"
    },
    output: {
        filename: "js/[name].js",
        path: path.resolve(__dirname,"dist"),
        clean: true,
    },
    watch: false,
    watchOptions:{
        ignored: /node_modules/
    },
    module: {
        rules:[
            {
                test: /\.js$/,                
                exclude:/node_modules/,
                loader: "babel-loader"
            },
            {
                test: /\.scss$/,
                use: [
                    /*"style-loader",*/
                    MiniCssExtractPlugin.loader,  /* Cambiar style-loader por este para tener archivos css */
                    {
                        loader: "css-loader",
                        options:{
                            url: false,
                        }
                    },
                    "sass-loader"
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "css/[name].css",
            chunkFilename: "css/[id].css"
        }),
        new CopyPlugin({
            patterns: [                
                { from: path.resolve(__dirname,"src","site"), to: "site" },
                { from: path.resolve(__dirname,"src","admin"), to: "admin" },
                { from: "./src/com_base.xml", to: "com_base.xml" },
                { from: "./src/com_base.xml", to: "admin/com_base.xml" },                  
            ],
        }),
        new ZipPlugin({
            path : '../dist_zip',
            filename : 'j4_component_base.zip'
        }),
    ],
};