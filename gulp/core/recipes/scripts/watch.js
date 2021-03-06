var gulp         = require('gulp');
var plumber      = require('gulp-plumber');
var named        = require('vinyl-named');
var gulpWebpack  = require('webpack-stream');
var browserSync  = require('browser-sync');

// utils
var deepMerge    = require('../../utils/deepMerge');
var logStats     = require('../../utils/webpackLogStats');
var notifaker    = require('../../utils/notifaker');
var pumped       = require('../../utils/pumped');

// config
var config    = require('../../config/scripts');
var fonts     = require('../../config/fonts');
var images    = require('../../config/images');
var styles    = require('../../config/styles');
var svg       = require('../../config/svg');


/**
 * Watch for changes
 * to JS assets and
 * update the JS packages
 * with webpack
 *
 * @returns {*}
 */
module.exports = function () {
	return gulp.src(config.paths.src)
		.pipe(plumber())

		.pipe(named()) // vinyl-named is used to allow for
									 // multiple entry files
		.pipe(gulpWebpack(
			deepMerge(
				config.options.webpack.defaults,
				config.options.webpack.watch,
				fonts.options.webpack.defaults,
				fonts.options.webpack.watch,
				images.options.webpack.defaults,
				images.options.webpack.watch,
				styles.options.webpack.defaults,
				styles.options.webpack.watch,
				svg.options.webpack.defaults,
				svg.options.webpack.watch
			), null, function (err, stats) {
				logStats(err, stats, { watch: true });

				// reload browser-sync when
				// a package is updated
				browserSync.reload();
				notifaker(pumped('JS and assets Packaged'));
   	 	})
		)

		.pipe(gulp.dest(config.paths.dest));
};