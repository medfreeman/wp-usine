<?php
/**
 * Theme Functions &
 * Functionality
 *
 * @package @@name
 */

?>
<?php

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

/*
	=========================================
		ACTION HOOKS & FILTERS
	=========================================
*/

/**--- Actions ---**/

add_action( 'after_setup_theme',  'usine_setup' );

add_action( 'tgmpa_register', 'usine_register_required_plugins' );

add_action( 'wp_enqueue_scripts', 'usine_styles' );

add_action( 'wp_enqueue_scripts', 'usine_scripts' );

/*
Expose php variables to js. just uncomment line
below and see function theme_scripts_localize.
*/

add_action( 'wp_enqueue_scripts', 'usine_scripts_localize', 20 );

// Add inline scripts to the page head.
add_action( 'wp_head', 'usine_head_inline_scripts', 1, 2 );

add_action( 'customize_register', 'usine_customize_register' );

add_action( 'customize_preview_init', 'usine_customize_preview' );

add_action( 'pre_get_posts', 'usine_bla_front_page' );

add_action( 'pre_comment_on_post', 'usine_validate_comment_author' );

add_action( 'get_header', 'usine_remove_admin_bar_bump' );

/**--- Filters ---**/


add_filter( 'script_loader_tag', 'usine_script_add_async_attribute', 10, 2 );

add_filter( 'comment_form_default_fields', 'usine_disable_comment_fields' );

add_filter( 'pre_get_document_title', 'usine_page_title' );

add_filter( 'document_title_separator', 'usine_page_title_separator' );

add_filter( 'wp_kses_allowed_html', 'usine_allow_additional_attrs_in_posts', 10, 3 );

add_filter( 'auto_update_theme', '__return_true' );

add_filter( 'auto_update_plugin', '__return_true' );

/*
	=========================================
		HOOKED Functions
	=========================================
*/

/**--- Actions ---**/

if ( ! function_exists( 'usine_setup' ) ) {
	/**
	 * Setup the theme
	 *
	 * @since 1.0
	 */
	function usine_setup() {

		// Let wp know we want to use html5 for content.
		add_theme_support( 'html5', array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
		) );

		// Let wp know we want to use post thumbnails.
		add_theme_support( 'post-thumbnails', array( 'page', 'vox' ) );

		// Add WP 4.1 title tag support.
		add_theme_support( 'title-tag' );

		/* Add Custom Logo Support. */

		/*
		add_theme_support( 'custom-logo', array(
			'width'       => 181, // Example Width Size
			'height'      => 42,  // Example Height Size
			'flex-width'  => true,
		) );
		*/

		// Register navigation menus for theme.
		register_nav_menus( array(
			'primary' => __( 'Menu principal', 'usine' ),   // Main nav in header.
			'left' => __( 'Menu déroulant à gauche', 'usine' ), // Secondary nav in footer.
		) );

		// Stop WP from printing emoji service on the front.
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );

		/*
		Remove toolbar for all users in front end.
		*/

		/*
		show_admin_bar( false );
		*/

		// Register Autoloaders Loader.
		$theme_dir = get_template_directory();
		include "$theme_dir/library/library-loader.php";
		include "$theme_dir/includes/includes-loader.php";
		include "$theme_dir/components/components-loader.php";

		// Register sidebars for theme.
		MInc_Utils::register_sidebar( 'right', __( 'Barre de droite', 'usine' ), array( 'widget_container_element' => 'div', 'widget_title_element' => 'h4' ) );
	}
}

if ( ! function_exists( 'usine_register_required_plugins' ) ) {
	/**
	 * Register required
	 * plugins with tgmpa.
	 */
	function usine_register_required_plugins() {
		$plugins = array(
			// This is an example of how to include a plugin from the WordPress Plugin Repository.
			array(
				'name'      => 'WP-LESS',
				'slug'      => 'wp-less',
				'required'  => true,
			),

			// This is an example of how to include a plugin from a GitHub repository in your theme.
			// This presumes that the plugin code is based in the root of the GitHub repository
			// and not in a subdirectory ('/src') of the repository.
			array(
				'name'      => 'Bla',
				'slug'      => 'wp-bla',
				'source'    => 'https://github.com/medfreeman/wp-bla/archive/master.zip',
				'required'  => true,
			),
			array(
				'name'      => 'Vox Usini',
				'slug'      => 'wp-voxusini',
				'source'    => 'https://github.com/medfreeman/wp-voxusini/archive/master.zip',
				'required'  => true,
			),
			array(
				'name'      => 'GitHub Updater',
				'slug'      => 'github-updater',
				'source'    => 'https://github.com/afragen/github-updater/archive/5.6.1.zip',
				'required'  => true,
			),

		);

		$config = array(
			'id'           => 'usine.ch',              // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the 	parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}
}

if ( ! function_exists( 'usine_styles' ) ) {
	/**
	 * Register and/or Enqueue
	 * Styles for the theme
	 *
	 * @since 1.0
	 */
	function usine_styles() {
		$theme_dir = get_stylesheet_directory_uri();

		wp_enqueue_style( 'main', "$theme_dir/assets/css/main.css", array(), null, 'all' );
		wp_enqueue_style( 'custom', "$theme_dir/less/colors.less", array(), null, 'all' );
	}
}

if ( ! function_exists( 'usine_scripts' ) ) {
	/**
	 * Register and/or Enqueue
	 * Scripts for the theme
	 *
	 * @since 1.0
	 */
	function usine_scripts() {
		$theme_dir = get_stylesheet_directory_uri();

		wp_enqueue_script( 'main', "$theme_dir/assets/js/main.js", array( 'jquery' ), null, true );
	}
}

if ( ! function_exists( 'usine_scripts_localize' ) ) {
	/**
	 * Attach variables we want
	 * to expose to our JS
	 *
	 * @since 3.12.0
	 */
	function usine_scripts_localize() {
		$ajax_url_params = array();

		wp_localize_script( 'main', 'urls', array(
			'home'  => home_url(),
			'theme' => get_stylesheet_directory_uri(),
			'ajax'  => add_query_arg( $ajax_url_params, admin_url( 'admin-ajax.php' ) ),
		) );

		wp_localize_script( 'main', 'vox', array(
			'downloadText'    => __( 'Télécharger le pdf', 'usine' ),
			'downloadTitle'   => __( 'Télécharger le pdf', 'usine' ),
			'currentItemText' => __( 'vox {current} sur {total}', 'usine' ),
			'previousText'    => __( 'précédent', 'usine' ),
			'nextText'        => __( 'suivant', 'usine' ),
		) );
	}
}

if ( ! function_exists( 'usine_head_inline_scripts' ) ) {
	/**
	 * Print inline scripts
	 * we want in html head.
	 */
	function usine_head_inline_scripts() {
		ob_start();
		// Replace the no-js class with js on the html element.
?>
<script>
	document.documentElement.className=document.documentElement.className.replace(/\bno-js\b/,'js');
</script>
<?php
		echo ob_get_clean(); // WPCS: XSS ok.
	}
}

if ( ! function_exists( 'usine_customize_register' ) ) {
	/**
	 * Register the theme customizations.
	 *
	 * @param object $wp_customize Wordpress customizer object.
	 */
	function usine_customize_register( $wp_customize ) {
		$wp_customize->add_section( USINE_THEME_SECTION_COLORS, array(
			'title' => __( 'Couleurs', 'usine' ),
			'description' => __( 'Personnalisez les couleurs du thème.', 'usine' ),
			'priority' => 30,
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_section( USINE_THEME_SECTION_VOX, array(
			'title' => __( 'Page des vox', 'usine' ),
			'description' => __( 'Choisissez la page dont le contenu s\'affichera au-dessus des vox.', 'usine' ),
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
			'label' => __( 'Couleur des bordures extérieures', 'usine' ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_BORDERS_COLOR_INSIDE, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#000000',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_BORDERS_COLOR_INSIDE, array(
			'label' => __( 'Couleur des bordures intérieures', 'usine' ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_BUTTONS_COLOR_BACKGROUND, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#2ba6cb',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_BUTTONS_COLOR_BACKGROUND, array(
			'label' => __( 'Couleur de fond des boutons', 'usine' ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_BUTTONS_COLOR_BACKGROUND_HOVER, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#2284a1',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_BUTTONS_COLOR_BACKGROUND_HOVER, array(
			'label' => __( 'Couleur de fond des boutons survolés', 'usine' ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_VOX_COLOR_BACKGROUND, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#105b9b',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_VOX_COLOR_BACKGROUND, array(
			'label' => __( 'Couleur de l\'icone du vox', 'usine' ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_LINK_COLOR, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#2ba6cb',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_LINK_COLOR, array(
			'label' => __( 'Couleur des liens', 'usine' ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_LINK_COLOR_HOVER, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#2795b6',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_LINK_COLOR_HOVER, array(
			'label' => __( 'Couleur des liens survolés', 'usine' ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_PRIMARY_MENU_LINK_COLOR, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#000000',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_PRIMARY_MENU_LINK_COLOR, array(
			'label' => __( 'Couleur des liens du menu principal', 'usine' ),
			'section' => USINE_THEME_SECTION_COLORS,
		) ) );

		$wp_customize->add_setting( USINE_THEME_MOD_PRIMARY_MENU_LINK_COLOR_HOVER, array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '#105b9b',
			'transport' => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, USINE_THEME_MOD_PRIMARY_MENU_LINK_COLOR_HOVER, array(
			'label' => __( 'Couleur des liens survolés du menu principal', 'usine' ),
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
			'label' => __( 'Page des vox', 'usine' ),
			'section' => USINE_THEME_SECTION_VOX,
		) );
	}
}

if ( ! function_exists( 'usine_customize_preview' ) ) {
	/**
	 * Inject the needed less variables into the theme customizer.
	 *
	 * @param object $wp_customize Wordpress customizer object.
	 */
	function usine_customize_preview( $wp_customize ) {
		if ( class_exists( 'WPLessPlugin' ) ) {

			$less = WPLessPlugin::getInstance();

			foreach ( USINE_THEME_MODS as $setting_name => $less_variable ) {
				$less->addVariable( $less_variable, $wp_customize->get_setting( $setting_name )->value() );
			}
		}
	}
}

if ( ! function_exists( 'usine_bla_front_page' ) ) {
	/**
	 * Load custom post type archive on home page
	 *
	 * Reference: http://www.wpaustralia.org/wordpress-forums/topic/pre_get_posts-and-is_front_page/
	 * Reference: http://wordpress.stackexchange.com/questions/30851/how-to-use-a-custom-post-type-archive-as-front-page
	 *
	 * @param object $query Wordpress query object.
	 */
	function usine_bla_front_page( $query ) {
		global $usine_front_page;
		// Only filter the main query on the front-end.
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		global $wp;
		$usine_front_page = false;

		// If the latest posts are showing on the home page.
		if ( ( is_home() && empty( $wp->query_string ) ) ) {
			$usine_front_page = true;
		}

		// If a static page is set as the home page.
		if ( ( $query->get( 'page_id' ) === get_option( 'page_on_front' ) && get_option( 'page_on_front' ) ) || empty( $wp->query_string ) ) {
			$usine_front_page = true;
		}

		if ( $usine_front_page ) :

			$paged = absint( $query->get( 'page' ) );
			$paged = $paged ? $paged : 1;

			$query->set( 'paged', $paged );

			$posts_per_page = get_option( 'posts_per_page' );
			if ( -1 !== $posts_per_page ) {
				$query->set( 'posts_per_page', $posts_per_page );
				$count_posts = wp_count_posts( 'bla' )->publish;
				$query->set( 'max_num_pages', ceil( $count_posts / $posts_per_page ) );
			}

			$query->set( 'post_type', 'bla' );
			$query->set( 'page_id', '' );

			// Set properties to match an archive.
			$query->is_page = 0;
			$query->is_singular = 0;
			$query->is_post_type_archive = 1;
			$query->is_archive = 1;

		endif;
	}
}

if ( ! function_exists( 'usine_script_add_async_attribute' ) ) {
	/**
	 * Add async
	 * and defer attributes
	 * to core.js.
	 *
	 * @param string $tag    Html code of script tag.
	 * @param string $handle Script handle.
	 */
	function usine_script_add_async_attribute( $tag, $handle ) {
		if ( 'core' !== $handle ) {
			return $tag;
		}
		return str_replace( ' src', ' async defer src', $tag );
	}
}

if ( ! function_exists( 'usine_validate_comment_author' ) ) {
	/**
	 * Validate comment and author before accepting.
	 */
	function usine_validate_comment_author() {
		if ( empty( sanitize_text_field( wp_unslash( $_POST['author'] ) ) ) || ( ! preg_match( '/[^\s]/', sanitize_text_field( wp_unslash( $_POST['author'] ) ) ) ) ) { // WPCS: input var ok. // WPCS: CSRF ok.
			wp_die( wp_kses( __( '<strong>Erreur</strong> : Veuillez saisir un nom.', 'usine' ), array( 'strong' => array() ) ) );
		} else if ( empty( sanitize_text_field( wp_unslash( $_POST['comment'] ) ) || ( ! preg_match( '/[^\s]/', sanitize_text_field( wp_unslash( $_POST['comment'] ) ) ) ) ) ) { // WPCS: input var ok. // WPCS: CSRF ok.
			wp_die( wp_kses( __( '<strong>Erreur</strong> : Veuillez saisir un message.', 'usine' ), array( 'strong' => array() ) ) );
		}
	}
}

if ( ! function_exists( 'usine_remove_admin_bar_bump' ) ) {
	/**
	 * Removes admin bar 28px bump to allow viewing the site correctly while connected
	 */
	function usine_remove_admin_bar_bump() {
		remove_action( 'wp_head', '_admin_bar_bump_cb' );
	}
}

if ( ! function_exists( 'usine_disable_comment_fields' ) ) {
	/**
	 * Disable email and url fields, add a single author field intead.
	 *
	 * @param array $fields Wordpress comment form fields.
	 */
	function usine_disable_comment_fields( $fields ) {
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

		$fields['author'] = '<p class="comment-form-author"><label for="author">' . __( 'Nom', 'usine' ) . ' ' . __( '(entrez également votre organisation, fonction.. si vous le souhaitez)', 'usine' ) . '</label> ' .
			( $req ? '<span class="required">*</span>' : '' ) .
			'<input id="author" name="author" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size="30"' . $aria_req . ' /></p>';

		unset( $fields['email'] );
		unset( $fields['url'] );
		return $fields;
	}
}

if ( ! function_exists( 'usine_page_title' ) ) {
	/**
	 * Customize the page title.
	 *
	 * @param string $title The original title.
	 * @return string The title to use.
	 */
	function usine_page_title( $title ) {
		global $usine_front_page;
		if ( $usine_front_page ) {
			$title = get_bloginfo( 'title' ) . ' | ' . get_bloginfo( 'description' );
		}
		return $title;
	}
}

if ( ! function_exists( 'usine_page_title_separator' ) ) {
	/**
	 * Customize the page title separator.
	 *
	 * @return string The separator to use.
	 */
	function usine_page_title_separator() {
		return '|';
	}
}

if ( ! function_exists( 'usine_allow_additional_attrs_in_posts' ) ) {
	/**
	 * Customize the allowed tags in posts and code using wp_kses with 'post'
	 * context.
	 *
	 * @param array  $tags    The original allowed tags array.
	 * @param string $context The context.
	 *
	 * @return array $tags The allowed tags array.
	 */
	function usine_allow_additional_attrs_in_posts( $tags, $context ) {
		if ( 'post' === $context ) {
			$allowed_img_attrs = isset( $tags['img'] ) ? $tags['img'] : array();
			$allowed_img_attrs['data-href'] = 1;
			$tags = array_merge( $tags, array( 'img' => $allowed_img_attrs ) );
		}
		return $tags;
	}
}

if ( ! function_exists( 'usine_pagination' ) ) {
	/**
	 * Prints a custom pagination markup.
	 *
	 * @param string $before Html to print before the pagination markup.
	 * @param string $after  Html to print after the pagination markup.
	 */
	function usine_pagination( $before = '', $after = '' ) {
		global $wp_query;

		$paged = isset( $wp_query->query_vars['paged'] ) ? absint( $wp_query->query_vars['paged'] ) : 1;

		$max_page = isset( $wp_query->query_vars['max_num_pages'] ) ? absint( $wp_query->query_vars['max_num_pages'] ) : 1;
		if ( 1 === $max_page ) {
			return;
		}

		$pages_to_show = 7;
		$pages_to_show_minus_1 = $pages_to_show - 1;
		$half_page_start = floor( $pages_to_show_minus_1 / 2 );
		$half_page_end = ceil( $pages_to_show_minus_1 / 2 );
		$start_page = $paged - $half_page_start;
		if ( $start_page <= 0 ) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if ( ( $end_page - $start_page ) !== $pages_to_show_minus_1 ) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if ( $end_page > $max_page ) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if ( $start_page <= 0 ) {
			$start_page = 1;
		}

		echo esc_html( $before ) . '<ul class="pagination--bla pagination__list clearfix">';

		if ( $start_page > 1 ) {
			echo '<li class="pagination__item first"><a class="pagination__link" href="' . esc_url( get_pagenum_link( 1 ) ) . '" title="First">' . esc_html( '&laquo;' ) . '</a></li>';
		}

		if ( $paged > 1 ) {
			echo '<li class="pagination__item previous">';
			echo wp_kses( get_previous_posts_link( '&lsaquo;' ), array( 'a' => array( 'href' => array() ) ) );
			echo '</li>';
		}

		for ( $i = $start_page; $i <= $end_page; $i++ ) {
			if ( $i === $paged ) {
				echo '<li class="pagination__item current">' . esc_html( $i ) . '</li>';
			} else {
				echo '<li class="pagination__item"><a class="pagination__link" href="' . esc_url( get_pagenum_link( $i ) ) . '">' . esc_html( $i ) . '</a></li>';
			}
		}

		if ( $paged < $max_page ) {
			echo '<li class="pagination__item next">';
			echo wp_kses( get_next_posts_link( '&rsaquo;' ), array( 'a' => array( 'href' => array() ) ) );
			echo '</li>';
		}

		if ( $end_page < $max_page ) {
			echo '<li class="pagination__item last"><a class="pagination__link" href="' . esc_url( get_pagenum_link( $max_page ) ) . '" title="Last">' . esc_html( '&raquo;' ) . '</a></li>';
		}
		echo '</ul>' . esc_html( $after ) . '';
	}
}
