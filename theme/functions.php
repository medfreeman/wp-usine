<?php
/**
 * Theme Functions &
 * Functionality
 *
 */

const USINE_TEXTDOMAIN = 'usine';

/* =========================================
		ACTION HOOKS & FILTERS
   ========================================= */

/**--- Actions ---**/

add_action( 'after_setup_theme',  'usine_setup' );

add_action( 'wp_enqueue_scripts', 'usine_styles' );

add_action( 'wp_enqueue_scripts', 'usine_scripts' );

// expose php variables to js. just uncomment line
// below and see function theme_scripts_localize
// add_action( 'wp_enqueue_scripts', 'theme_scripts_localize', 20 );

/**--- Filters ---**/



/* =========================================
		HOOKED Functions
   ========================================= */

/**--- Actions ---**/


/**
 * Setup the theme
 *
 * @since 1.0
 */
if ( ! function_exists( 'usine_setup' ) ) {
	function usine_setup() {

		// Let wp know we want to use html5 for content
		add_theme_support( 'html5', array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
		) );

		// Let wp know we want to use post thumbnails
		add_theme_support( 'post-thumbnails', array( 'page', 'vox' ) );

		// Register navigation menus for theme
		register_nav_menus( array(
			'primary' => __( 'Menu principal', USINE_TEXTDOMAIN ),   // main nav in header
			'left' => __( 'Menu déroulant à gauche', USINE_TEXTDOMAIN ), // secondary nav in footer
		) );

		// Stop WP from printing emoji service on the front
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );

		// Remove toolbar for all users in front end
		show_admin_bar( false );

		// Register Autoloaders Loader
		$theme_dir = get_template_directory();
		include "$theme_dir/library/library-loader.php";
		include "$theme_dir/includes/includes-loader.php";
		include "$theme_dir/components/components-loader.php";

		// Register sidebars for theme
		MInc_Utils::register_sidebar( 'right', __( 'Barre de droite', USINE_TEXTDOMAIN ), array( 'widget_container_element' => 'div', 'widget_title_element' => 'h4' ) );
	}
}


/**
 * Register and/or Enqueue
 * Styles for the theme
 *
 * @since 1.0
 */
if ( ! function_exists( 'usine_styles' ) ) {
	function usine_styles() {
		$theme_dir = get_stylesheet_directory_uri();

		wp_enqueue_style( 'main', "$theme_dir/assets/css/main.css", array(), null, 'all' );
	}
}


/**
 * Register and/or Enqueue
 * Scripts for the theme
 *
 * @since 1.0
 */
if ( ! function_exists( 'usine_scripts' ) ) {
	function usine_scripts() {
		$theme_dir = get_stylesheet_directory_uri();

		wp_enqueue_script( 'main', "$theme_dir/assets/js/main.js", array( 'jquery' ), null, true );
	}
}


/**
 * Attach variables we want
 * to expose to our JS
 *
 * @since 3.12.0
 */
if ( ! function_exists( 'usine_scripts_localize' ) ) {
	function usine_scripts_localize() {
		$ajax_url_params = array();

		wp_localize_script( 'main', 'urls', array(
			'home'  => home_url(),
			'theme' => get_stylesheet_directory_uri(),
			'ajax'  => add_query_arg( $ajax_url_params, admin_url( 'admin-ajax.php' ) ),
		) );
	}
}
