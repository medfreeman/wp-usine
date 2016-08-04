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
						'$': 'jquery',
						'IASCallbacks': 'exports?IASCallbacks!jquery-ias/src/callbacks'
					})
				],
				externals: {
					jquery: 'window.jQuery',
					urls: 'window.urls',
					vox: 'window.vox'
				}
			}
		}
	}
};
