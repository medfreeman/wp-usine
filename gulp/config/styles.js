/**
 * Override the Default
 * Core Styles
 * Config
 *
 */
var ExtractTextWebpackPlugin = require('extract-text-webpack-plugin');

// config
var assets = require('../core/config/common').paths.assets;

module.exports = {
	options: {
		webpack: {
			watch: {
				module: {
					loaders: [
						{
							test: /\.less$/,
							loader: ExtractTextWebpackPlugin.extract(
								'style-loader',
								'css-loader?sourceMap!postcss-loader!less-loader?sourceMap',
								{ publicPath: '../' }
							)
						}
					]
				}
			},
			prod: {
				module: {
					loaders: [
						{
							test: /\.less$/,
							loader: ExtractTextWebpackPlugin.extract(
								'style-loader',
								'css-loader!postcss-loader!less-loader',
								{ publicPath: '../' }
							)
						}
					]
				}
			}
		}
	}
};
