<?php
/**
 * Walker Nav Menu extension
 * to support Usine
 * menu with descriptions
 *
 * @author Mehdi Lahlou <http://usine.ch>
 */


// make sure this file is called by wp
defined( 'ABSPATH' ) or die();



/**
 * Class MInc_Walker_Nav_Menu_Description
 *
 * Prints the Html for the navigation
 * menus with descriptions in subtitles
 *
 * @since 1.0
 *
 * @uses  MOZ_Walker_Nav_Menu
 */
class MInc_Walker_Nav_Menu_Description extends MOZ_Walker_Nav_Menu {



	/**
	 * Start the element output.
	 *
	 * @see   Walker_Nav_Menu::start_el()
	 *
	 * @since 1.0
	 *
	 * @param string        $output Passed by reference. Used to append additional content.
	 * @param object        $item   Menu item data object.
	 * @param int           $depth  Depth of menu item. Used for padding.
	 * @param object|array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int           $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		/// Menu Item Opening

		$item_classes = array( '__item' );

		// add classes to current/parent/ancestor items
		if ( isset( $item->current ) && $item->current ) {
			$item_classes[] = '__item--current';
		}
		if ( isset( $item->current_item_ancestor ) && $item->current_item_ancestor ) {
			$item_classes[] = '__item--ancestor';
		}
		if ( isset( $item->current_item_parent ) && $item->current_item_parent ) {
			$item_classes[] = '__item--parent';
		}
		if ( isset( $item->has_children ) && $item->has_children ) {
			$item_classes[] = '__item--has-children';
		}

		// BEM-ify the given sub classes
		$item_classes_str = MOZ_BEM::get_bem( $args->menu_class, $item_classes );

		if ( isset( $item->classes[0] ) && ! empty( $item->classes[0] ) ) {
			// the first item in the 'classes' array is the user-set class
			// the rest of the classes are superfluous
			$item_classes_str .= " {$item->classes[0]}";
		}

		$output .= "<li class=\"$item_classes_str\">";

		/// Menu Link

		$attrs = array_filter( array(
			'title'  => $item->attr_title,
			'target' => $item->target,
			'rel'    => $item->xfn,
			'href'   => ( ! empty( $item->url ) && '#' !== $item->url ) ? $item->url : '',
			'class'  => "{$args->menu_class}__link"
		), function ( $attr ) {
			// filter out the empty
			// attributes
			return ! empty( $attr );
		});

		$tag = isset( $attrs['href'] ) ? 'a' : 'span';

		$link_content = $args->link_before
		                . apply_filters( 'the_title', $item->title, $item->ID )
		                . $args->link_after;

		$output .= $args->before;
		$output .= MOZ_Html::get_element( $tag, $attrs, $link_content );
		// Add subtitle
		$output .= MOZ_Html::get_element( 'span', array( 'class' => 'menu__subtitle' ), isset( $attrs['title'] ) ? $attrs['title'] : '' );
		$output .= $args->after;
	}
}