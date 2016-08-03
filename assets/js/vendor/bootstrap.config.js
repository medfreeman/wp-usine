module.exports = {
	styleLoader: require('extract-text-webpack-plugin').extract('style-loader', 'css-loader!postcss-loader!less-loader'),
	scripts: {
		'dropdown': true
	},
	styles: {
		"mixins": true,

		"normalize": true,
		"print": true,

		"scaffolding": true,
		"grid": true,
		"buttons": true,
		"forms": true,

		"dropdowns": true,
		"media": true,

		"responsive-utilities": true
	}
};