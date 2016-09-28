/* eslint-disable import/imports-first */
/* eslint-disable import/no-extraneous-dependencies */
/* eslint import/no-unresolved: [2, { ignore: ['^glob:'] }] */

/**
 * Setup webpack public path
 * to enable lazy-including of
 * js chunks
 *
 */
import './vendor/webpack.publicPath';

/* Bootstrap */
import 'bootstrap-webpack!./vendor/bootstrap.config';

/**
 * Import
 * fonts
 *
 */
import 'glob:../fonts/**/*.{eot,otf,ttf,woff,woff2,svg}';
/**
 * Import
 * images
 *
 */
import 'glob:../img/**/*.{gif,ico,jpg,jpeg,png,webp}';
/**
 * Import
 * less
 *
 */
import 'glob:../less/*.less';
/**
 * Import
 * svgs
 *
 */
import 'glob:../svg/**/*.svg!../svg/sprite/**/*.svg';

/**
 * Your theme's js starts
 * here...
 */
// home link click event
import './scripts/link__location';
// radio listen button
import './scripts/radio__listen';
// vox colorbox
import './scripts/vox__link.colorbox';
