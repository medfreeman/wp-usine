/**
 * Override the Default
 * Core Styles
 * Config
 *
 */

const ExtractTextWebpackPlugin = require('extract-text-webpack-plugin');

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
