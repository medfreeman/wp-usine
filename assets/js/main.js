/**
 * Setup webpack public path
 * to enable lazy-including of
 * js chunks
 *
 */
import './vendor/webpack.publicPath';
/**
 * Import
 * fonts
 *
 */
import '../fonts/**/*.{eot,otf,ttf,woff,woff2,svg}'
/**
 * Import
 * images
 *
 */
import '../img/**/*.{gif,ico,jpg,jpeg,png,webp}';
/**
 * Import
 * sass
 *
 */
import '../scss/*.scss';
/**
 * Import
 * svgs
 *
 */
import '../svg/**/*.svg!../svg/sprite/**/*.svg'

/**
 * Your theme's js starts
 * here...
 */

// silly example:
import obj from './scripts/example';

/* eslint no-console: 0 */
console.log(obj);
