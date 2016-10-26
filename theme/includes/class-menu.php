<?php
/**
 * Wordpress menus
 * utility class
 *
 * @author Mehdi Lahlou <http://usine.ch>
 * @package @@name
 */

// Make sure this file is called by wp.
defined( 'ABSPATH' ) or die();



/**
 * Class MInc_Menu
 *
 * Wordpress menus functions
 */
class MInc_Menu {

	/**
	 * Print a wp nav menu name
	 * for the given theme location
	 *
	 * @param string $theme_location Theme location.
	 */
	public static function nav_menu_name( $theme_location = 'primary' ) {
		echo wp_kses( self::get_nav_menu_name( $theme_location ), array() );
	}

	/**
	 * Return a wp nav menu name
	 * for the given theme location
	 *
	 * @param string $theme_location Theme location.
	 */
	public static function get_nav_menu_name( $theme_location = 'primary' ) {
		$theme_locations = get_nav_menu_locations();
		if ( ! isset( $theme_locations[ $theme_location ] ) ) {
			return false;
		}

		$menu_obj = get_term( $theme_locations[ $theme_location ], 'nav_menu' );
		if ( ! $menu_obj || ! isset( $menu_obj->name ) ) {
			return false;
		}

		return $menu_obj->name;
	}
}
