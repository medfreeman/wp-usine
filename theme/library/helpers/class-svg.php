<?php
/**
 * Static helpers for using svgs
 * in your theme
 *
 * @author Max G J Panas <http://maxpanas.com>
 * @package @@name
 */

/**
 * Class MOZ_SVG
 */
class MOZ_SVG {


	/**
	 * Get a given svg's
	 * markup
	 *
	 * @param string $filename The name of an svg file in corresponding folder.
	 *
	 * @return string
	 */
	public static function get_svg( $filename ) {
		ob_start();
			locate_template( "assets/svg/$filename.svg", true, false );
		return ob_get_clean();
	}


	/**
	 * Print a given svg's
	 * markup
	 *
	 * @param string $filename The name of an svg file in corresponding folder.
	 */
	public static function svg( $filename ) {
		echo wp_kses( self::get_svg( $filename ), array(
			'svg' => array(
				'width' => array(),
				'height' => array(),
				'viewbox' => array(),
				'version' => array(),
				'xmlns' => array(),
				'xmlns:xlink' => array(),
				'xlink:href' => array(),
			),
			'g' => array(
				'stroke' => array(),
				'stroke-width' => array(),
				// 'fill' => array(),
				'fill-rule' => array(),
			),
			'path' => array(
				'd' => array(),
				'id' => array(),
			),
			'use', array(
				'xmlns:xlink' => '',
				'xlink:href'  => '',
			),
		));
	}


	/**
	 * Get the markup for an
	 * svg sprite icon
	 *
	 * @param string $icon  The id of the icon to show (without the `icon-` prefix).
	 * @param array  $attrs Attributes for the `svg` element.
	 * @param string $alt   Accessible alternative text for the icon (https://gist.github.com/.davidhund/564331193e1085208d7e#gistcomment-1587234).
	 *
	 * @return string
	 */
	public static function get_icon( $icon, $attrs = array(), $alt = '' ) {
		if ( is_array( $icon ) && isset( $icon['icon'] ) ) {
			$icon = $icon['icon'];
		}

		$default_attrs = $alt ? array( 'role' => 'img' ) : array( 'aria-hidden' => 'true' );
		$final_attrs   = array_merge( $default_attrs, $attrs );

		$content = MOZ_Html::get_element( 'use', array(
			'xmlns:xlink' => 'http://www.w3.org/1999/xlink',
			'xlink:href'  => "#icon-$icon",
		) );

		if ( $alt ) {
			$content = "<title>$alt</title>" . $content;
		}

		return MOZ_Html::get_element( 'svg', $final_attrs, $content );
	}


	/**
	 * Print the markup for an
	 * svg sprite icon
	 *
	 * @param string $icon  The id of the icon to show (without the `icon-` prefix).
	 * @param array  $attrs Attributes for the `svg` element.
	 * @param string $alt   Accessible alternative text for the icon (https://gist.github.com/davidhund/564331193e1085208d7e#gistcomment-1587234).
	 */
	public static function icon( $icon, $attrs = array(), $alt = '' ) {
		echo wp_kses( self::get_icon( $icon, $attrs, $alt ), array(
			'svg' => array(
				'width' => array(),
				'height' => array(),
				'viewbox' => array(),
				'version' => array(),
				'xmlns' => array(),
				'xmlns:xlink' => array(),
				'xlink:href' => array(),
			),
			'g' => array(
				'stroke' => array(),
				'stroke-width' => array(),
				// 'fill' => array(),
				'fill-rule' => array(),
			),
			'path' => array(
				'd' => array(),
				'id' => array(),
			),
			'use', array(
				'xmlns:xlink' => '',
				'xlink:href'  => '',
			),
		));
	}
}
