/**
 * Override the Default
 * Core Theme
 * Config
 *
 */

// config
var paths = require('../core/config/common').paths;
var theme = paths.theme;

module.exports = {
	paths: {
		watch: theme.src + '/**/*.{json,php,png,jpg,less}',
		src:   theme.src + '/**/*.{json,php,png,jpg,less}',
		clean: [
			theme.dest + '/**/*.{css,json,php,png,less}',
			'!' + paths.assets.dest + '/**/*'
		]
	},
};