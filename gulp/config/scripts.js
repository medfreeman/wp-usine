/**
 * Override the Default
 * Core Scripts
 * Config
 *
 */

const webpack = require('webpack');

module.exports = {
	options: {
		webpack: {
			watch: {
				watchOptions: {
					aggregateTimeout: 300,
					poll: 1000
				},
			},
			defaults: {
				plugins: [
					new webpack.ProvidePlugin({
						$: 'jquery'
					})
				],
				externals: {
					jquery: 'window.jQuery',
					vox: 'window.vox'
				}
			}
		}
	}
};
