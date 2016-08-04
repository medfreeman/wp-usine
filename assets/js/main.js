/**
 * Setup webpack public path
 * to enable lazy-including of
 * js chunks
 *
 */
import './vendor/webpack.publicPath';
/* Bootstrap */
import 'bootstrap-webpack!./vendor/bootstrap.config.js';

/* eslint no-extra-semi: 0 */
/**
 * Import
 * fonts
 *
 */
import '../fonts/**/*.{eot,otf,ttf,woff,woff2,svg}';
/**
 * Import
 * images
 *
 */
import '../img/**/*.{gif,ico,jpg,jpeg,png,webp}';
/**
 * Import
 * less
 *
 */
import '../less/*.less';
/**
 * Import
 * svgs
 *
 */
import '../svg/**/*.svg!../svg/sprite/**/*.svg';

/**
 * Your theme's js starts
 * here...
 */
// vox colorbox
import './scripts/vox__link.colorbox.js';
