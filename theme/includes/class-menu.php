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

	/**
	 * Print a wp nav menu slug
	 * for the given theme location
	 *
	 * @param string $theme_location Theme location.
	 */
	public static function nav_menu_slug( $theme_location = 'primary' ) {
		echo wp_kses( self::get_nav_menu_slug( $theme_location ), array() );
	}

	/**
	 * Return a wp nav menu slug
	 * for the given theme location
	 *
	 * @param string $theme_location Theme location.
	 */
	public static function get_nav_menu_slug( $theme_location = 'primary' ) {
		$theme_locations = get_nav_menu_locations();
		if ( ! isset( $theme_locations[ $theme_location ] ) ) {
			return false;
		}

		$menu_obj = get_term( $theme_locations[ $theme_location ], 'nav_menu' );
		if ( ! $menu_obj || ! isset( $menu_obj->slug ) ) {
			return false;
		}

		return $menu_obj->slug;
	}

	/**
	 * Print a wp nav menu
	 * as bootstrap dropdown
	 * for the given theme location
	 * using some sensible defaults
	 *
	 * @param string $theme_location Nav menu theme location.
	 * @param array  $extras         Extra menu parameters.
	 */
	public static function nav_menu_dropdown( $theme_location = 'primary', $extras = array() ) {
		echo wp_kses( self::get_nav_menu_dropdown( $theme_location, $extras ), array_merge( wp_kses_allowed_html( 'post' ), array(
			'button' => array(
				'class'         => array(),
				'type'          => array(),
				'id'            => array(),
				'data-toggle'   => array(),
				'aria-haspopup' => array(),
				'aria-expanded' => array(),
			),
			'ul' => array(
				'class'           => array(),
				'aria-labelledby' => array(),
			),
		) ) );
	}

	/**
	 * Return a wp nav menu
	 * as bootstrap dropdown
	 * for the given theme location
	 * using some sensible defaults
	 *
	 * @param string $theme_location Nav menu theme location.
	 * @param array  $extras         Extra menu parameters.
	 *
	 * @returns string
	 */
	public static function get_nav_menu_dropdown( $theme_location = 'primary', $extras = array() ) {
		$menu_class = isset( $extras['menu_class'] ) && ! empty( $extras['menu_class'] )
			? $extras['menu_class']
			: 'menu';

		$container_class = 'menu' === $menu_class
			? "$menu_class {$menu_class}-dropdown--{$theme_location} dropdown"
			: $menu_class;

		$args = array_merge( array(
			'btn_class'        => 'btn-default',
			'container'        => 'nav',
			'container_class'  => $container_class,
			'container_id'     => '',
			'name'             => self::get_nav_menu_name( $theme_location ),
			'wrap_class'       => '',
		), $extras );
		$slug = self::get_nav_menu_slug( $theme_location );
		$button_id = "{$menu_class}-dropdown--$theme_location";

		$show_level_class = isset( $extras['show_level_class'] )
			? (bool) $extras['show_level_class']
			: true;

		$wrap_class = "{$menu_class}__list";
		if ( $show_level_class ) {
			$wrap_class .= " {$menu_class}__list--level-0";
		}

		$wrap_class .= ' dropdown-menu';
		if ( '' !== $args['wrap_class'] ) {
			$wrap_class .= " {$args['wrap_class']}";
		}

		$nav_menu = '';
		$show_container = false;
		if ( $args['container'] ) {
			/**
			 * Filters the list of HTML tags that are valid for use as menu containers.
			 *
			 * @since 3.0.0
			 *
			 * @param array $tags The acceptable HTML tags for use as menu containers.
			 *                    Default is array containing 'div' and 'nav'.
			 */
			$allowed_tags = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
			if ( is_string( $args['container'] ) && in_array( $args['container'], $allowed_tags, true ) ) {
				$show_container = true;
				$class = $args['container_class'] ? ' class="' . esc_attr( $args['container_class'] ) . '"' : ' class="menu-' . $slug . '-container"';
				$id = $args['container_id'] ? ' id="' . esc_attr( $args['container_id'] ) . '"' : '';
				$nav_menu .= '<' . $args['container'] . $id . $class . '>';
			}
		}

		$nav_menu .= "<button class=\"btn {$args['btn_class']} dropdown-toggle\" type=\"button\" id=\"{$button_id}\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
				{$args['name']}
				<span class=\"caret\"></span>
			</button>";

		$nav_menu .= MOZ_Menu::get_nav_menu( $theme_location, array(
			'container'        => false,
			'items_wrap'       => "<ul class=\"{$wrap_class}\" aria-labelledby=\"{$button_id}\">%3\$s</ul>",
		));

		if ( $show_container ) {
			$nav_menu .= '</' . $args['container'] . '>';
		}

		return $nav_menu;
	}
}
