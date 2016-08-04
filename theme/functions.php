<?php
/**
 * Theme Functions &
 * Functionality
 *
 */

const USINE_TEXTDOMAIN = 'usine';
const USINE_THEME_SECTION_COLORS = 'colors';
const USINE_THEME_SECTION_VOX = 'vox';
const USINE_THEME_MOD_BORDERS_COLOR_OUTSIDE          = 'color_border_outside';
const USINE_THEME_MOD_BORDERS_COLOR_INSIDE           = 'color_border_inside';
const USINE_THEME_MOD_BUTTONS_COLOR_BACKGROUND       = 'color_button_background';
const USINE_THEME_MOD_BUTTONS_COLOR_BACKGROUND_HOVER = 'color_button_hover_background';
const USINE_THEME_MOD_VOX_COLOR_BACKGROUND           = 'color_vox_background';
const USINE_THEME_MOD_LINK_COLOR                     = 'color_link';
const USINE_THEME_MOD_LINK_COLOR_HOVER               = 'color_link_hover';
const USINE_THEME_MOD_VOX_PAGE                       = 'vox_page';
const USINE_THEME_MOD_PRIMARY_MENU_LINK_COLOR        = 'color_primary_menu_link';
const USINE_THEME_MOD_PRIMARY_MENU_LINK_COLOR_HOVER  = 'color_primary_menu_link_hover';
const USINE_THEME_MODS = array(
	USINE_THEME_MOD_BORDERS_COLOR_OUTSIDE         => '@borders__color_outside',
	USINE_THEME_MOD_BORDERS_COLOR_INSIDE          => '@borders__color_inside',
	USINE_THEME_MOD_VOX_COLOR_BACKGROUND          => '@vox__color_background',
	USINE_THEME_MOD_LINK_COLOR                    => '@link__color',
	USINE_THEME_MOD_LINK_COLOR_HOVER              => '@link__color_hover',
	USINE_THEME_MOD_VOX_PAGE                      => '@vox__page',
	USINE_THEME_MOD_PRIMARY_MENU_LINK_COLOR       => '@menu--primary__link_color',
	USINE_THEME_MOD_PRIMARY_MENU_LINK_COLOR_HOVER => '@menu--primary__link_color_hover',
);

require_once 'tgmpa/class-tgm-plugin-activation.php';

if ( class_exists( 'WPLessPlugin' ) ) {
	$less = WPLessPlugin::getInstance();

	foreach ( USINE_THEME_MODS as $setting_name => $less_variable ) {
		$less->addVariable( $less_variable, get_theme_mod( $setting_name ) );
	}
}

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

add_action( 'customize_register', 'usine_customize_register' );

add_action( 'customize_preview_init', 'usine_customize_preview' );

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
		
		// Add Custom Logo Support.
		/*
		add_theme_support( 'custom-logo', array(
			'width'       => 181, // Example Width Size
			'height'      => 42,  // Example Height Size
			'flex-width'  => true,
		) );
		*/

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
		wp_enqueue_style( 'custom', "$theme_dir/less/colors.less", array(), null, 'all' );
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

if ( ! function_exists( 'usine_customize_register' ) ) {
	function usine_customize_register( $wp_customize ) {
		$wp_customize->add_section( USINE_THEME_SECTION_COLORS, array(
			'title' => __( 'Couleurs', USINE_TEXTDOMAIN ),
			'description' => __( 'Personnalisez les couleurs du thème.', USINE_TEXTDOMAIN ),
			'priority' => 30,
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_section( USINE_THEME_SECTION_VOX, array(
			'title' => __( 'Page des vox', USINE_TEXTDOMAIN ),
			'description' => __( 'Choisissez la page dont le contenu s\'affichera au-dessus des vox.', USINE_TEXTDOMAIN ),
			'priority' => 200,
			'capability' => 'edit_theme_options',
		) );

		/* Colors section */
		$wp_customize->add_setting( USINE_THEME_MOD_BORDERS_COLOR_OUTSIDE, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#105b9b',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_BORDERS_COLOR_OUTSIDE, array(
			'label' => __( 'Couleur des bordures extérieures', USINE_TEXTDOMAIN ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_BORDERS_COLOR_INSIDE, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#000000',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_BORDERS_COLOR_INSIDE, array(
			'label' => __( 'Couleur des bordures intérieures', USINE_TEXTDOMAIN ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_BUTTONS_COLOR_BACKGROUND, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#2ba6cb',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_BUTTONS_COLOR_BACKGROUND, array(
			'label' => __( 'Couleur de fond des boutons', USINE_TEXTDOMAIN ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_BUTTONS_COLOR_BACKGROUND_HOVER, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#2284a1',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_BUTTONS_COLOR_BACKGROUND_HOVER, array(
			'label' => __( 'Couleur de fond des boutons survolés', USINE_TEXTDOMAIN ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_VOX_COLOR_BACKGROUND, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#105b9b',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_VOX_COLOR_BACKGROUND, array(
			'label' => __( 'Couleur de l\'icone du vox', USINE_TEXTDOMAIN ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_LINK_COLOR, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#2ba6cb',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_LINK_COLOR, array(
			'label' => __( 'Couleur des liens', USINE_TEXTDOMAIN ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_LINK_COLOR_HOVER, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#2795b6',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_LINK_COLOR_HOVER, array(
			'label' => __( 'Couleur des liens survolés', USINE_TEXTDOMAIN ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_PRIMARY_MENU_LINK_COLOR, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#000000',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_PRIMARY_MENU_LINK_COLOR, array(
			'label' => __( 'Couleur des liens du menu principal', USINE_TEXTDOMAIN ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_PRIMARY_MENU_LINK_COLOR_HOVER, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#105b9b',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_PRIMARY_MENU_LINK_COLOR_HOVER, array(
			'label' => __( 'Couleur des liens survolés du menu principal', USINE_TEXTDOMAIN ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		/* Vox section */
		$wp_customize->add_setting( USINE_THEME_MOD_VOX_PAGE, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => 0,
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( USINE_THEME_MOD_VOX_PAGE, array(
			'type' => 'dropdown-pages',
			'label' => __( 'Page des vox', USINE_TEXTDOMAIN ),
			'section' => USINE_THEME_SECTION_VOX,
		) );
	}
}

if ( ! function_exists( 'usine_customize_preview' ) ) {
	function usine_customize_preview( $wp_customize ) {
		if ( class_exists( 'WPLessPlugin' ) ) {

			$less = WPLessPlugin::getInstance();

			foreach ( USINE_THEME_MODS as $setting_name => $less_variable ) {
				$less->addVariable( $less_variable, $wp_customize->get_setting( $setting_name )->value() );
			}
		}
	}
}
