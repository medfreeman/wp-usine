/**
 * Project info config object
 *
 * All params optional unless
 * otherwise noted
 *
 * @params {
 *  string  name               (required) The built theme dirname and the theme text-domain
 *  string  prettyName         (required) The theme name as shown in the theme selector admin
 *  string  themeURI           The theme's URI
 *  string  githubThemeURI     The theme's github URI, for use with https://github.com/afragen/github-updater
 *  string  githubReleaseAsset Whether your theme uses github release asset, true or false, for use with https://github.com/afragen/github-updater
 *  string  description        A short description of the theme
 *  string  parentTheme        If this is a child theme, then put the parent
 *                             theme's directory name here
 *  string  version            The theme's version
 *  string  author             The theme's author
 *  string  authorURI          The theme author's URI
 *  string  license            The theme's license
 *  string  licenseURI         The theme license's URI
 *  array   tags               Keywords that could be associated with the theme
 * }
 */
module.exports = {
	name: 'usine',
	prettyName: 'Usine',
	themeURI: 'https://github.com/medfreeman/wp-usine',
	githubThemeURI: 'https://github.com/medfreeman/wp-usine',
	githubReleaseAsset: 'true',
	description: 'The 2016 theme for usine.ch. Built by Mehdi Lahlou',
	version: '1.0.0',
	author: 'Mehdi Lahlou <mehdi.lahlou@free.fr>',
	authorURI: 'https://github.com/medfreeman',
	license: 'GPLv2 or later'
};
