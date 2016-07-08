/**
 * Override the Default
 * Core Scripts
 * Config
 *
 */
var webpack = require('webpack');

module.exports = {
	options: {
		webpack: {
			defaults: {
				plugins: [
					new webpack.ProvidePlugin({
						'$': 'jquery'
					})
				],
				externals: {
					jquery: 'window.jQuery'
				}
			}
		}
	}
};
