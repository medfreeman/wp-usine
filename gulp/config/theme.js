/**
 * Override the Default
 * Core Theme
 * Config
 *
 */

// config
const paths = require('../core/config/common').paths;

const theme = paths.theme;

module.exports = {
	paths: {
		watch: `${theme.src}/**/*.{json,php,png,jpg,less}`,
		src: `${theme.src}/**/*.{json,php,png,jpg,less}`,
		clean: [
			`${theme.dest}/**/*.{json,php,png,jpg,less}`,
			`!${paths.assets.dest}/**/*`
		]
	},

	options: {
		watch: {
			usePolling: true
		}
	}
};
