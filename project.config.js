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
	themeURI: 'https://github.com/usine/wp-usine',
	githubThemeURI: 'https://github.com/usine/wp-usine',
	releaseAsset: 'true',
	description: 'The 2016 theme for usine.ch. Built by Mehdi Lahlou',
	version: '1.4.0',
	author: 'Mehdi Lahlou <mehdi.lahlou@free.fr>',
	authorURI: 'https://github.com/medfreeman',
	license: 'GPLv2 or later'
};
